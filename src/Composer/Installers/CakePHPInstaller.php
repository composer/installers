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
    public function inflectPackageVars($vars)
    {
        if (isset($vars['pathName'])) {
            $vars['name'] = $vars['pathName'];
        } else {
            $vars['name'] = strtolower(str_replace(array('-', '_'), ' ', $vars['name']));
            $vars['name'] = str_replace(' ', '', ucwords($vars['name']));
		}

        return $vars;
    }
}
