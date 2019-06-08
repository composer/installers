<?php
namespace Composer\Installers;

class AsgardInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'Modules/{$name}/',
        'theme' => 'Themes/{$name}/'
    );

    /**
     * Format package name.
     *
     * For package type asgard-module, cut off a trailing '-plugin' if present.
     *
     * For package type asgard-theme, cut off a trailing '-theme' if present.
     *
     */
    public function inflectPackageVars($vars)
    {
        if (in_array($vars['type'] , ["asgard-module" , "laravel-module"])) {
            return $this->inflectPluginVars($vars);
        }

        if (in_array($vars['type'] , ["asgard-theme" , "laravel-module"])) {
            return $this->inflectThemeVars($vars);
        }

        return $vars;
    }

    protected function inflectPluginVars($vars)
    {
        $vars['name'] = preg_replace('/-module$/', '', $vars['name']);
        $vars['name'] = str_replace(array('-', '_'), ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));

        return $vars;
    }

    protected function inflectThemeVars($vars)
    {
        $vars['name'] = preg_replace('/-theme$/', '', $vars['name']);
        $vars['name'] = str_replace(array('-', '_'), ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));

        return $vars;
    }
}
