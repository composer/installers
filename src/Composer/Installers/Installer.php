<?php
namespace Composer\Installers;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

class Installer extends LibraryInstaller
{
    /**
     * Package types to installer class map
     *
     * @var array
     */
    private $supportedTypes = array(
        'agl'          => 'AglInstaller',
        'annotatecms'  => 'AnnotateCmsInstaller',
        'cakephp'      => 'CakePHPInstaller',
        'codeigniter'  => 'CodeIgniterInstaller',
        'croogo'       => 'CroogoInstaller',
        'drupal'       => 'DrupalInstaller',
        'fuel'         => 'FuelInstaller',
        'joomla'       => 'JoomlaInstaller',
        'kohana'       => 'KohanaInstaller',
        'laravel'      => 'LaravelInstaller',
        'lithium'      => 'LithiumInstaller',
        'magento'      => 'MagentoInstaller',
        'mako'         => 'MakoInstaller',
        'mediawiki'    => 'MediaWikiInstaller',
        'modulework'   => 'MODULEWorkInstaller',
        'oxid'         => 'OxidInstaller',
        'phpbb'        => 'PhpBBInstaller',
        'ppi'          => 'PPIInstaller',
        'silverstripe' => 'SilverStripeInstaller',
        'symfony1'     => 'Symfony1Installer',
        'wordpress'    => 'WordPressInstaller',
        'zend'         => 'ZendInstaller',
        'typo3-flow'   => 'TYPO3FlowInstaller'
    );

    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        $type = $package->getType();
        $frameworkType = $this->findFrameworkType($type);

        if ($frameworkType === false) {
            throw new \InvalidArgumentException(
                'Sorry the package type of this package is not yet supported.'
            );
        }

        $class = 'Composer\\Installers\\' . $this->supportedTypes[$frameworkType];
        $installer = new $class($package, $this->composer);

        return $installer->getInstallPath($package, $frameworkType);
    }

    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        if (!$repo->hasPackage($package)) {
            throw new \InvalidArgumentException('Package is not installed: '.$package);
        }

        $repo->removePackage($package);

        $installPath = $this->getInstallPath($package);
        $this->io->write(sprintf('Deleting %s - %s', $installPath, $this->filesystem->removeDirectory($installPath) ? '<comment>deleted</comment>' : '<error>not deleted</error>'));
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        $frameworkType = $this->findFrameworkType($packageType);

        if ($frameworkType === false) {
            return false;
        }

        return preg_match('#' . $frameworkType . '-(\w+)#', $packageType, $matches) === 1;
    }

    /**
     * Finds a supported framework type if it exists and returns it
     *
     * @param  string $type
     * @return string
     */
    protected function findFrameworkType($type)
    {
        $frameworkType = false;

        foreach ($this->supportedTypes as $key => $val) {
            if ($key === substr($type, 0, strlen($key))) {
                $frameworkType = substr($type, 0, strlen($key));
                break;
            }
        }

        return $frameworkType;
    }
}
