<?php
namespace Composer\Installers;

class CakePHPInstaller extends BaseInstaller
{
    protected $locations = array(
        'app'           => '',
        'plugin'        => 'Plugin/{name}/',
        'lib'           => 'Lib/',
        'vendor'        => 'Vendor/{name}/',
        'model'         => 'Model/',
        'behavior'      => 'Model/Behavior/',
        'controller'    => 'Controller/',
        'component'     => 'Controller/Component/',
        'helper'        => 'View/Helper/',
        'theme'         => 'View/Themed/{name}/',
    );

    /**
     * Format package name to CamelCase
     */
    public function inflectPackageName($name, $package)
    {
        $name = strtolower(str_replace(array('-', '_'), ' ', $name));
        return str_replace(' ', '', ucwords($name));
    }
}
