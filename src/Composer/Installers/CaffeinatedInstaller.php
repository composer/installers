<?php
namespace Composer\Installers;

class CaffeinatedInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'App/Modules/{$name}/',
        'theme' => 'App/Themes/{$name}/'
    );

    /**
     * Format package name.
     *
     * For package type caffeinated-module, cut off a trailing '-plugin' if present.
     *
     * For package type caffeinated-theme, cut off a trailing '-theme' if present.
     *
     */
    public function inflectPackageVars($vars)
    {
        if ($vars['type'] === 'caffeinated-module') {
            return $this->inflectPluginVars($vars);
        }

        if ($vars['type'] === 'caffeinated-theme') {
            return $this->inflectThemeVars($vars);
        }

        return $vars;
    }

    protected function inflectPluginVars($vars)
    {
        $vars['name'] = ucfirst(preg_replace('/-module/', '', $vars['name']));

        return $vars;
    }

    protected function inflectThemeVars($vars)
    {
        $vars['name'] = ucfirst(preg_replace('/-theme$/', '', $vars['name']));

        return $vars;
    }
}
