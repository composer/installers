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
        $extra = [];
        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
        }

        if ($vars['type'] === 'tastyigniter-extension') {
            return $this->inflectExtensionVars($vars, $extra);
        }

        if ($vars['type'] === 'tastyigniter-theme') {
            return $this->inflectThemeVars($vars, $extra);
        }

        return $vars;
    }

    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflectExtensionVars(array $vars, array $extra): array
    {
        if (isset($extra['tastyigniter-extension']['code'])) {
            $parts = explode('.', $extra['tastyigniter-extension']['code']);
            $vars['vendor'] = $parts[0];
            $vars['name'] = $parts[1];
        }

        $vars['vendor'] = preg_replace('/[^a-z0-9_]/i', '', $vars['vendor']);
        $vars['name'] = preg_replace('/^ti-ext-/', '', $vars['name']);

        return $vars;
    }

    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflectThemeVars(array $vars, array $extra): array
    {
        if (isset($extra['tastyigniter-theme']['code'])) {
            $vars['name'] = $extra['tastyigniter-theme']['code'];
        }

        $vars['name'] = preg_replace('/^ti-theme-/', '', $vars['name']);

        return $vars;
    }
}
