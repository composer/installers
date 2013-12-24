<?php
namespace Composer\Installers;

class WordPressInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin'    => 'wp-content/plugins/{$name}/',
        'theme'     => 'wp-content/themes/{$name}/',
        'language'  => 'wp-content/languages/',
        'muplugin'  => 'wp-content/mu-plugins/{$name}/',
    );
}
