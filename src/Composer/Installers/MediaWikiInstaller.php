<?php
namespace Composer\Installers;

class MediaWikiInstaller extends BaseInstaller
{
    protected $locations = array(
        'extension' => 'extensions/{$name}/',
    );

    /**
     * Make package name a MediaWiki extension name using CamelCase
     * though we keep upercased characters.
     */
    public function inflectPackageVars($vars)
    {
        $vars['name'] = str_replace( '-', ' ', $vars['name'] );
        $vars['name'] = str_replace( ' ', '', ucwords( $vars['name'] ) );

        return $vars;
    }

}
