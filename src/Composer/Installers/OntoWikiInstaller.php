<?php

namespace Composer\Installers;

class OntoWikiInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'extension' => 'extensions/{$name}/',
        'theme' => 'extensions/themes/{$name}/',
        'translation' => 'extensions/translations/{$name}/',
    );

    /**
     * Format package name to lower case and remove ".ontowiki" suffix
     */
    public function inflectPackageVars(array $vars): array
    {
        $vars['name'] = strtolower($vars['name']);
        $vars['name'] = preg_replace('/.ontowiki$/', '', $vars['name']);
        $vars['name'] = preg_replace('/-theme$/', '', $vars['name']);
        $vars['name'] = preg_replace('/-translation$/', '', $vars['name']);

        return $vars;
    }
}
