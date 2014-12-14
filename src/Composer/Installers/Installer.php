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
        'asgard'       => 'AsgardInstaller',
        'agl'          => 'AglInstaller',
        'annotatecms'  => 'AnnotateCmsInstaller',
        'bitrix'       => 'BitrixInstaller',
        'cakephp'      => 'CakePHPInstaller',
        'chef'         => 'ChefInstaller',
        'codeigniter'  => 'CodeIgniterInstaller',
        'concrete5'    => 'Concrete5Installer',
        'craft'        => 'CraftInstaller',
        'croogo'       => 'CroogoInstaller',
        'dokuwiki'     => 'DokuWikiInstaller',
        'dolibarr'     => 'DolibarrInstaller',
        'drupal'       => 'DrupalInstaller',
        'elgg'         => 'ElggInstaller',
        'fuel'         => 'FuelInstaller',
        'fuelphp'      => 'FuelphpInstaller',
        'grav'         => 'GravInstaller',
        'hurad'        => 'HuradInstaller',
        'joomla'       => 'JoomlaInstaller',
        'kirby'        => 'KirbyInstaller',
        'kohana'       => 'KohanaInstaller',
        'laravel'      => 'LaravelInstaller',
        'lithium'      => 'LithiumInstaller',
        'magento'      => 'MagentoInstaller',
        'mako'         => 'MakoInstaller',
        'mediawiki'    => 'MediaWikiInstaller',
        'microweber'    => 'MicroweberInstaller',
        'modulework'   => 'MODULEWorkInstaller',
        'modxevo'      => 'MODXEvoInstaller',
        'moodle'       => 'MoodleInstaller',
        'october'      => 'OctoberInstaller',
        'oxid'         => 'OxidInstaller',
        'phpbb'        => 'PhpBBInstaller',
        'pimcore'      => 'PimcoreInstaller',
        'piwik'        => 'PiwikInstaller',
        'ppi'          => 'PPIInstaller',
        'puppet'       => 'PuppetInstaller',
        'redaxo'       => 'RedaxoInstaller',
        'roundcube'    => 'RoundcubeInstaller',
        'shopware'     => 'ShopwareInstaller',
        'silverstripe' => 'SilverStripeInstaller',
        'smf'          => 'SMFInstaller',
        'symfony1'     => 'Symfony1Installer',
        'thelia'       => 'TheliaInstaller',
        'tusk'         => 'TuskInstaller',
        'typo3-cms'    => 'TYPO3CmsInstaller',
        'typo3-flow'   => 'TYPO3FlowInstaller',
        'whmcs'        => 'WHMCSInstaller',
        'wolfcms'      => 'WolfCMSInstaller',
        'wordpress'    => 'WordPressInstaller',
        'zend'         => 'ZendInstaller',
        'zikula'       => 'ZikulaInstaller',
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

        $locationPattern = $this->getLocationPattern($frameworkType);

        return preg_match('#' . $frameworkType . '-' . $locationPattern . '#', $packageType, $matches) === 1;
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

        krsort($this->supportedTypes);

        foreach ($this->supportedTypes as $key => $val) {
            if ($key === substr($type, 0, strlen($key))) {
                $frameworkType = substr($type, 0, strlen($key));
                break;
            }
        }

        return $frameworkType;
    }

    /**
     * Get the second part of the regular expression to check for support of a
     * package type
     *
     * @param  string $frameworkType
     * @return string
     */
    protected function getLocationPattern($frameworkType)
    {
        $pattern = false;
        if (!empty($this->supportedTypes[$frameworkType])) {
            $frameworkClass = 'Composer\\Installers\\' . $this->supportedTypes[$frameworkType];
            /** @var BaseInstaller $framework */
            $framework = new $frameworkClass(null, $this->composer);
            $locations = array_keys($framework->getLocations());
            $pattern = $locations ? '(' . implode('|', $locations) . ')' : false;
        }

        return $pattern ? : '(\w+)';
    }

    /**
     * {@inheritDoc}
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package) {

        $backups = $this->backupSubdirs($repo, $package);

        try {
            parent::install($repo, $package);
        }
        catch (\Exception $e) {
            // In the case of an exception we should restore backups first,
            // before the script fails.
            $this->restoreSubdirs($repo, $package, $backups);
            throw $e;
        }

        $this->restoreSubdirs($repo, $package, $backups);
    }

    protected function backupSubdirs(InstalledRepositoryInterface $repo, PackageInterface $package) {
        $extra = $this->composer->getPackage()->getExtra();

        // if we got no subdir configuration, we do not have anythign to backup.
        if (empty($extra['installer-preserve-subpaths'])) {
            return array();
        }

        $subpaths = $extra['installer-preserve-subpaths'];

        $installPath = $this->getInstallPath($package);

        $installPathNormalized = $this->filesystem->normalizePath($installPath);

        $backup_paths = array();

        // Check if any subpath maybe affected by installation of this package.
        foreach ($subpaths as $path) {
            $normalizedPath = $this->filesystem->normalizePath($path);
            if (file_exists($path) && strpos($normalizedPath, $installPathNormalized) === 0) {
                $backup_paths[] = $normalizedPath;
            }
        }

        // If no paths need to backed up, we simply procceed.
        if (empty($backup_paths)) {
            return array();
        }

        // Otherwise we back those up to a cache subdirectory.
        $cache_dir = $this->composer->getConfig()->get('cache-dir');
        $unique = $package->getUniqueName() . ' ' . time();
        $cache_root = $this->filesystem->normalizePath($cache_dir . '/installer-preserve-subpaths/' . sha1($unique));
        $this->filesystem->ensureDirectoryExists($cache_root);

        $return = array();
        foreach ($backup_paths as $path) {
            $subfolder = sha1($path);
            $this->filesystem->rename($path, $cache_root . '/' . $subfolder);
            $return[$path] = $cache_root . '/' . $subfolder;
        }
        return $return;
    }

    protected function restoreSubdirs(InstalledRepositoryInterface $repo, PackageInterface $package, $backups) {
        if (empty($backups)) {
            return;
        }

        foreach ($backups as $original => $backup_location) {

            // Remove any code that was placed by the package at the place of
            // the original path.
            if (file_exists($original)) {
                if (is_dir($original)) {
                    $this->filesystem->emptyDirectory($original, false);
                    $this->filesystem->removeDirectory($original);
                }
                else {
                    $this->filesystem->remove($original);
                }

                $this->io->write(sprintf('<comment>Content of package %s was overwritten with preserved path %s!</comment>', $package->getUniqueName(), $original), true);
            }

            $this->filesystem->ensureDirectoryExists(dirname($original));
            $this->filesystem->rename($backup_location, $original);

            if ($this->filesystem->isDirEmpty(dirname($backup_location))) {
                $this->filesystem->removeDirectory(dirname($backup_location));
            }
        }
    }
}
