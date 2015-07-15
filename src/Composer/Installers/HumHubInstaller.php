<?php
namespace Composer\Installers;

class HumHubInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => 'modules/{$name}/',
        'theme'     => 'themes/{$name}/'
    );

    /**
     * Format package name.
     *
     * For package type humhub-module, cut off 'humhub-module-' if present.
     *
     * For package type humhub-theme, cut off 'humhub-theme-' if present.
     *
     */
    public function inflectPackageVars($vars)
    {
        if ($vars['type'] === 'humhub-module') {
            return $this->inflectModuleVars($vars);
        }

        if ($vars['type'] === 'humhub-theme') {
            return $this->inflectThemeVars($vars);
        }

        return $vars;
    }

    protected function inflectModuleVars($vars)
    {
        $vars['name'] = preg_replace('/^humhub-module-/', '', $vars['name']);

        return $vars;
    }

    protected function inflectThemeVars($vars)
    {
        $vars['name'] = preg_replace('/^humhub-theme-/', '', $vars['name']);

        return $vars;
    }
}
