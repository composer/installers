<?php
namespace Composer\Installers;

class CakePHPInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin' => 'Plugin/{$name}/',
    );

    /**
     * Format package name to CamelCase
     */
    public function inflectPackageName($name)
    {
        $name = strtolower(str_replace(array('-', '_'), ' ', $name));

        return str_replace(' ', '', ucwords($name));
    }
}
