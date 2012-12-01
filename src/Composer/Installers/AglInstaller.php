<?php
namespace Composer\Installers;

class AglInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'More/{$name}/',
    );

    /**
     * Format package name to CamelCase
     */
    public function inflectPackageVars($vars)
    {
        $vars['name'] = preg_replace('/(?:^|_|-)(.?)/e', "strtoupper('$1')", $vars['name']);

        return $vars;
    }
}
