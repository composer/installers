<?php
namespace Composer\Installers;

class AuraInstaller extends BaseInstaller
{
    protected $locations = array(
        'package' => 'package/{$vendor}.{$name}/',
        'include' => 'include/{$name}/',
    );

    /**
     * Format package vars to Vendor.Name
     */
    public function inflectPackageVars($vars)
    {
        if ($vars['type'] === 'aura-package') {
            $vars['name'] = ucfirst($vars['name']);
            $vars['vendor'] = ucfirst($vars['vendor']);
        }

        return $vars;
    }
}
