<?php
namespace Composer\Installers;

class MediaWikiInstaller extends BaseInstaller
{
    protected $locations = array(
        'extension' => 'extensions/{$name}/',
    );

    /**
     * Format package name to CamelCase keeping existing uppercase chars.
     */
    public function inflectPackageVars($vars)
    {
        $vars['name'] = str_replace('-', ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));

        return $vars;
    }

}
