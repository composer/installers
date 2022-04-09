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
        $extra = $this->package->getExtra();

        if ($vars['type'] === 'tastyigniter-extension') {
            if (!empty($extra['tastyigniter-extension']['code'])) {
                $parts = explode('.', $extra['tastyigniter-extension']['code']);
                $vars['vendor'] = $parts[0];
                $vars['name'] = $parts[1] ?? '';
            }

            $vars['vendor'] = preg_replace('/[^a-z0-9_]/i', '', $vars['vendor']);
            $vars['name'] = preg_replace('/^ti-ext-/', '', (string)$vars['name']);
        }

        if ($vars['type'] === 'tastyigniter-theme') {
            if (!empty($extra['tastyigniter-theme']['code'])) {
                $vars['name'] = $extra['tastyigniter-theme']['code'];
            }

            $vars['name'] = preg_replace('/^ti-theme-/', '', $vars['name']);
        }

        return $vars;
    }
}
