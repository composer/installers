<?php
namespace Composer\Installers;

class HnhInstaller extends BaseInstaller
{
    protected $locations = [
        'module' => 'modules/{$name}/',
        'plugin' => 'plugins/{$name}/',
        'theme'  => 'themes/{$name}/',
    ];

    /**
     * Format package name.
     *
     * For package type hnh-module, cut off a trailing '-module' if present.
     *
     * For package type hnh-plugin, cut off a trailing '-plugin' if present.
     *
     * For package type hnh-theme, cut off a trailing '-theme' if present.
     *
     */
    public function inflectPackageVars($vars)
    {
        if ($vars['type'] === 'hnh-module') {
            return $this->inflectModuleVars($vars);
        }

        if ($vars['type'] === 'hnh-plugin') {
            return $this->inflectPluginVars($vars);
        }

        if ($vars['type'] === 'hnh-theme') {
            return $this->inflectThemeVars($vars);
        }

        return $vars;
    }

    protected function inflectModuleVars($vars)
    {
        $vars['name'] = ucfirst(preg_replace('/-module$/', '', $vars['name']));

        return $vars;
    }

    protected function inflectPluginVars($vars)
    {
        $vars['name'] = ucfirst(preg_replace('/-plugin$/', '', $vars['name']));

        return $vars;
    }

    protected function inflectThemeVars($vars)
    {
        $vars['name'] = ucfirst(preg_replace('/-theme$/', '', $vars['name']));

        return $vars;
    }
}
