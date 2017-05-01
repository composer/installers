<?php
namespace Composer\Installers;

class PicoInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin' => 'plugins/{$name}/',
        'theme'  => 'themes/{$name}/',
    );

    /**
     * Format package name
     *
     * Converts package names to StudlyCase and removes "-plugin" and "-theme"
     * suffixes if present.
     *
     * @param  array $vars
     * @return array
     */
    public function inflectPackageVars($vars)
    {
        $vars['name'] = preg_replace('/[\.\-_]+(?>plugin|theme)$/u', '', $vars['name']);
        $vars['name'] = preg_replace_callback(
            '/(?>^[\.\-_]*|[\.\-_]+)(.)/u',
            function ($matches) {
                return strtoupper($matches[1]);
            },
            $vars['name']
        );

        return $vars;
    }
}
