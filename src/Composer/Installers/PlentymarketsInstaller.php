<?php

namespace Composer\Installers;

class PlentymarketsInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'plugin'   => '{$name}/'
    );

    /**
     * Remove hyphen, "plugin" and format to camelcase
     */
    public function inflectPackageVars(array $vars): array
    {
        $vars['name'] = explode("-", $vars['name']);
        foreach ($vars['name'] as $key => $name) {
            $vars['name'][$key] = ucfirst($vars['name'][$key]);
            if (strcasecmp($name, "Plugin") == 0) {
                unset($vars['name'][$key]);
            }
        }
        $vars['name'] = implode("",$vars['name']);

        return $vars;
    }
}
