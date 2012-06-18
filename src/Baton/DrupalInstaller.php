<?php
namespace Baton;

use Composer\Package\BasePackage;

class DrupalInstaller extends BaseInstaller
{

    protected $locations = array(
        'module'    => 'modules/{name}/',
        'theme'     => 'themes/{name}/',
    );
    protected $default = 'module';

}