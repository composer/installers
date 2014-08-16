<?php
namespace Composer\Installers;

use Composer\DependencyResolver\Pool;
use Composer\Package\PackageInterface;
use Composer\Package\LinkConstraint\MultiConstraint;
use Composer\Package\LinkConstraint\VersionConstraint;

class CakePHPInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin' => 'Plugin/{$name}/',
    );

    /**
     * Format package name to CamelCase
     */
    public function inflectPackageVars($vars)
    {
        $nameParts = explode('/', $vars['name']);
        foreach ($nameParts as &$value) {
            $value = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $value));
            $value = str_replace(array('-', '_'), ' ', $value);
            $value = str_replace(' ', '', ucwords($value));
        }
        $vars['name'] = implode('/', $nameParts);

        return $vars;
    }

    /**
     * Change the default plugin location when cakephp >= 3.0
     */
    public function getLocations()
    {
        if ($this->matchesCakeVersion('>=', '3.0.0')) {
            $this->locations['plugin'] = 'plugins/{$name}/';
        }
        return $this->locations;
    }

    /**
     * Add installer-name for CakePHP >= 3.0.0
     *
     * @param PackageInterface $package
     * @param string $frameworkType
     * @return string
     */
    public function getInstallPath(PackageInterface $package, $frameworkType = '')
    {
        $extra = $package->getExtra();
        if (empty($extra['installer-name']) && $this->matchesCakeVersion('>=', '3.0.0')) {
            $this->setInstallerName($package);
        }
        return parent::getInstallPath($package, $frameworkType);
    }

    /**
     * Check if CakePHP version matches against a version
     *
     * @param string $matcher
     * @param string $version
     * @return bool
     */
    protected function matchesCakeVersion($matcher, $version)
    {
        $repositoryManager = $this->composer->getRepositoryManager();
        if ($repositoryManager) {
            $repos = $repositoryManager->getLocalRepository();
            if (!$repos) {
                return false;
            }
            $cake3 = new MultiConstraint(array(
                new VersionConstraint($matcher, $version),
                new VersionConstraint('!=', '9999999-dev'),
            ));
            $pool = new Pool('dev');
            $pool->addRepository($repos);
            $packages = $pool->whatProvides('cakephp/cakephp');
            foreach ($packages as $package) {
                $installed = new VersionConstraint('=', $package->getVersion());
                if ($cake3->matches($installed)) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }

    /**
     * Set installer-name based on namespace for the source path
     *
     * With one autoload path this will be used as installer-name.
     * With two autoload paths the first non `tests` foldername will be set.
     * If more then 2 autoload paths are provided, installer-name will only be
     * set for if `src` folder is used.
     *
     * @param PackageInterface $package
     */
    protected function setInstallerName(PackageInterface $package)
    {
        $autoLoad = $package->getAutoload();
        foreach ($autoLoad as $type => $typeConfig) {
            if ($type !== 'psr-4') {
                continue;
            }
            $count = count($typeConfig);
            foreach ($typeConfig as $namespace => $path) {
                if ($path === 'tests') {
                    continue;
                }
                if ($count > 2 && $path !== 'src') {
                    continue;
                }
                $installerName = trim(str_replace('\\', '/', $namespace), '/');
                $package->setExtra(array(
                    'installer-name' => $installerName,
                ));
            }
            break;
        }
    }

}
