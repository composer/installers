<?php
namespace Composer\Installers;

class FuelPHPInstaller extends BaseInstaller
{
    protected $locations = array(
        'core'    => 'fuel/core/',
        'module'  => 'fuel/app/modules/{$name}/',
        'package' => 'fuel/packages/{$name}/',
    );
}
