<?php
namespace Composer\Installers;

class InternaInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => 'app/code/{$vendor}/{$name}/',
    );

    /**
     * Format package name of interna-module to CamelCase
     */
    public function inflectPackageVars($vars)
    {
        if ($vars['type'] === 'interna-module') {

            // Vendor
            $vars['vendor'] = preg_replace_callback('/(-[a-z])/', function ($matches) {
                return strtoupper($matches[0][1]);
            }, ucfirst($vars['vendor']));

            // Name
            $vars['name'] = preg_replace_callback('/(-[a-z])/', function ($matches) {
                return strtoupper($matches[0][1]);
            }, ucfirst($vars['name']));
        }

        return $vars;
    }
}
