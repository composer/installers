<?php
namespace Baton;

use Composer\Package\BasePackage;

class LaravelInstaller extends BaseInstaller
{

    protected $locations = array(
        'app'           => '',
        'library'       => 'libraries/{name}/',
    );
    protected $default = 'library';

}