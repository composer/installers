<?php
namespace Baton;

class LithiumInstaller extends BaseInstaller
{

    protected $locations = array(
        'app'           => '',
        'library'       => 'libraries/{name}/',
        'controller'    => 'controllers/',
        'extension'     => 'extensions/{name}/',
        'model'         => 'models/',
    );

    /**
     * Format package name to lowercase
     */
    public function inflectPackageName($name, $package)
    {
        return strtolower(str_replace(array('-', '_'), '', $name));
    }

}
