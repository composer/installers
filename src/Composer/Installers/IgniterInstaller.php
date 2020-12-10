<?php

namespace Composer\Installers;

class IgniterInstaller extends BaseInstaller
{
    protected $locations = array(
        'extension' => 'extensions/{$vendor}/{$name}/',
        'theme' => 'themes/{$name}/',
    );

    /**
     * Format package name.
     *
     * Cut off leading 'ti-' if present.
     * Cut off trailing '-extension' or '-theme' if present.
     * Strip vendor name of characters that is not alphanumeric or an underscore
     *
     */
    public function inflectPackageVars($vars)
    {
        if ($vars['type'] === 'igniter-extension') {
            $vars['vendor'] = preg_replace('/[^a-z0-9_]/i', '', $vars['vendor']);
            $vars['name'] = preg_replace('/^ti-|-extension$/', '', $vars['name']);
        }

        if ($vars['type'] === 'igniter-theme') {
            $vars['name'] = preg_replace('/^ti-|-theme$/', '', $vars['name']);
        }

        return $vars;
    }
}