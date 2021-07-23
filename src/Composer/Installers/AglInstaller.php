<?php

namespace Composer\Installers;

class AglInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'module' => 'More/{$name}/',
    );

    /**
     * Format package name to CamelCase
     */
    public function inflectPackageVars(array $vars): array
    {
        $vars['name'] = preg_replace_callback('/(?:^|_|-)(.?)/', function ($matches) {
            return strtoupper($matches[1]);
        }, $vars['name']);

        return $vars;
    }
}
