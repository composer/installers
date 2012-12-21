<?php
namespace Composer\Installers;

class FuelPHPInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'modules/{$name}/',
    );
}
