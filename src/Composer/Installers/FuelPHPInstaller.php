<?php
namespace Composer\Installers;

class FuelPHPInstaller extends BaseInstaller
{
    protected $locations = array(
        'core'    => 'fuel/core/',
        'module'  => 'fuel/modules/{$name}/',
        'package' => 'fuel/packages/{$name}/',
    );
}
