<?php
namespace Composer\Installers;

class FuelPHPInstaller extends BaseInstaller
{
    protected $locations = array(
        'app'           => '',
        'module'        => 'modules/{name}/',
    );
}
