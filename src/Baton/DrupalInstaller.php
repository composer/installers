<?php
namespace Baton;

use Composer\Package\BasePackage;

class DrupalInstaller extends BaseInstaller
{

    protected $locations = array(
        'module'    => 'sites/all/modules/{name}/',
        'theme'     => 'sites/all/themes/{name}/',
    );
    protected $default = 'module';

}