<?php
namespace Baton;

use Composer\Package\BasePackage;

class FuelPHPInstaller extends BaseInstaller
{

    protected $locations = array(
        'app'           => '',
        'module'        => 'modules/{name}/',
    );
    protected $default = 'module';

}