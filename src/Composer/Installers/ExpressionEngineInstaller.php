<?php

namespace Composer\Installers;

use Composer\Package\PackageInterface;

class ExpressionEngineInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    private $ee2Locations = array(
        'addon'   => 'system/expressionengine/third_party/{$name}/',
        'theme'   => 'themes/third_party/{$name}/',
    );

    /** @var array<string, string> */
    private $ee3Locations = array(
        'addon'   => 'system/user/addons/{$name}/',
        'theme'   => 'themes/user/{$name}/',
    );

    public function getInstallPath(PackageInterface $package, string $frameworkType = ''): string
    {
        if ($frameworkType === 'ee2') {
            $this->locations = $this->ee2Locations;
        } elseif ($frameworkType === 'ee3') {
            $this->locations = $this->ee3Locations;
        }

        return parent::getInstallPath($package, $frameworkType);
    }
}
