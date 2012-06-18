<?php
namespace Baton;

use Composer\Package\BasePackage;

class LithiumInstaller extends BaseInstaller
{

    protected $locations = array(
        'app'           => '',
        'library'       => 'libraries/{name}/',
        'controller'    => 'controllers/',
        'extension'     => 'extensions/{name}/',
        'model'         => 'models/',
    );
    protected $default = 'library';

    /**
     * Format package name to lowercase
     */
    public function inflectPackageName($name)
    {
        return strtolower(str_replace(array('-', '_'), '', $name));
    }

}