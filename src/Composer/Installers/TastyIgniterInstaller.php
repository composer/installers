<?php

namespace Composer\Installers;

class TastyIgniterInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'extension' => 'extensions/{$vendor}/{$name}/',
        'theme' => 'themes/{$name}/',
    );

    /**
     * Format package name.
     *
     * Cut off leading 'ti-ext-' or 'ti-theme-' if present.
     * Strip vendor name of characters that is not alphanumeric or an underscore
     *
     */
    public function inflectPackageVars(array $vars): array
    {
        if ($vars['type'] === 'tastyigniter-extension') {
            $vars['vendor'] = $this->pregReplace('/[^a-z0-9_]/i', '', $vars['vendor']);
            $vars['name'] = $this->pregReplace('/^ti-ext-/', '', $vars['name']);
        }

        if ($vars['type'] === 'tastyigniter-theme') {
            $vars['name'] = $this->pregReplace('/^ti-theme-/', '', $vars['name']);
        }

        return $vars;
    }
}
