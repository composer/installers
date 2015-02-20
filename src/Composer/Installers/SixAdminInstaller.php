<?php
namespace Composer\Installers;

class SixAdminInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => '6admin/{$name}/'
    );

    /**
     * Format package name.
     *
     * For package type 6admin-module, cut off a trailing '-module' if present.
     *
     */
    public function inflectPackageVars($vars)
    {
        if ($vars['type'] === '6admin-module') {
            return $this->inflectPluginVars($vars);
        }

        return $vars;
    }

    protected function inflectPluginVars($vars)
    {
        $vars['name'] = strtolower(preg_replace('/-module/', '', $vars['name']));

        return $vars;
    }
}
