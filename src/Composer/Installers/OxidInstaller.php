<?php
namespace Composer\Installers;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;

class OxidInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'modules/{$name}/',
        'theme'  => 'application/views/{$name}/',
        'out'    => 'out/{$name}/',
    );

    public function __construct(PackageInterface $package = null, Composer $composer = null, IOInterface $io = null)
    {
        if (null === $package) {
            $package = $composer->getPackage();
        }

        $extraOxidRoot = $extraModuleVendor = false;
        if (null !== $package) {
            $extra = $package->getExtra();
            if (isset($extra['oxid-root'])) {
                foreach ($this->locations as $name => $location) {
                    $this->locations[$name] = "{$extra['oxid-root']}/{$location}";
                }
                $extraOxidRoot = true;
            }

            if (isset($extra['module-vendor'])) {
                $this->locations['module'] = str_replace(
                    'modules/',
                    "modules/{$extra['module-vendor']}/",
                    $this->locations['module']
                );
                $extraModuleVendor = true;
            }
        }

        $composerPackage = $composer->getPackage();

        if (null !== $composerPackage) {
            $extra = $composerPackage->getExtra();
            if (isset($extra['oxid-root']) && !$extraOxidRoot) {
                foreach ($this->locations as $name => $location) {
                    $this->locations[$name] = "{$extra['oxid-root']}/{$location}";
                }
            }

            if (isset($extra['module-vendor']) && !$extraModuleVendor) {
                $this->locations['module'] = str_replace(
                    'modules/',
                    "modules/{$extra['module-vendor']}/",
                    $this->locations['module']
                );
            }
        }

        parent::__construct($package, $composer, $io);
    }
}
