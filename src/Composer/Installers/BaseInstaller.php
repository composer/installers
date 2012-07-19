<?php
namespace Composer\Installers;

use Composer\Composer;
use Composer\Package\PackageInterface;

abstract class BaseInstaller
{
    protected $locations = array();
    protected $composer;
    protected $package;

    /**
     * Initializes base installer.
     *
     * @param PackageInterface $package
     * @param Composer         $composer
     */
    public function __construct(PackageInterface $package, Composer $composer)
    {
        $this->composer = $composer;
        $this->package = $package;
    }

    /**
     * Return the install path based on package type.
     *
     * @return string
     */
    public function getInstallPath()
    {
        $type = $this->package->getType();
        $packageLocation = strtolower(substr($type, strpos($type, '-') + 1));

        $prettyName = $this->package->getPrettyName();
        list($vendor, $name) = explode('/', $prettyName);
        $name = $this->inflectPackageName($name);

        $availableVars = array(
            'name', 'vendor', 'type',
        );

        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (!empty($extra['installer-paths'])) {
                $customPath = $this->mapCustomInstallPaths($extra['installer-paths'], $prettyName);
                if ($customPath !== false) {
                    return $this->templatePath($customPath, compact($availableVars));
                }
            }
        }

        if (!isset($this->locations[$packageLocation])) {
            throw new \InvalidArgumentException(sprintf('Package type "%s" is not supported', $type));
        }

        // TODO: Include all config vars (#12) but wait until
        // composer/composer#832 is merged.
        return $this->templatePath($this->locations[$packageLocation], compact($availableVars));
    }

    /**
     * For an installer to override. Modify how the package name is translated.
     *
     * @param  string $name
     * @return string
     */
    public function inflectPackageName($name)
    {
        return $name;
    }

    /**
     * Replace vars in a path
     *
     * @param  string $path
     * @param  array  $vars
     * @return string
     */
    protected function templatePath($path, array $vars = array())
    {
        if (strpos($path, '{') !== false) {
            extract($vars);
            preg_match_all('@\{\$([A-Za-z0-9_]*)\}@i', $path, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $var) {
                    $path = str_replace('{$' . $var . '}', $$var, $path);
                }
            }
        }

        return $path;
    }

    /**
     * Search through extra.installers-paths for a custom install path.
     *
     * @param  array  $paths
     * @param  string $name
     * @return string
     */
    protected function mapCustomInstallPaths(array $paths, $name)
    {
        foreach ($paths as $path => $names) {
            if (in_array($name, $names)) {
                return $path;
            }
        }

        return false;
    }
}
