<?php
namespace Composer\Installers;

class AlfredInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'Modules/{$name}/'
    );

    /**
     * Format package name.
     *
     * For package type alfred-module, cut off a trailing '-module' if present.
     *
     */
    public function inflectPackageVars($vars)
    {
        if ($vars['type'] === 'alfred-module') {
            return $this->inflectPluginVars($vars);
        }

        return $vars;
    }

    protected function inflectPluginVars($vars)
    {
        $vars['name'] = ucfirst(preg_replace('/-module/', '', $vars['name']));

        return $vars;
    }
}
