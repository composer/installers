<?php
namespace Composer\Installers;

class ContaoInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'system/modules/{$name}/',
        'plugin' => 'plugins/{$name}/',
    );

    /**
     * Format package vars.
     */
    public function inflectPackageVars($vars)
    {
        $vars = $this->inflectPackageName($vars);

        return $vars;
    }

    protected function inflectPackageName($vars)
    {
        $vars['name'] = strtolower($vars['name']);

        return $vars;
    }

}
