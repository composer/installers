<?php
namespace Composer\Installers;

class WordPressInstaller extends BaseInstaller
{
    const PATTERN = '(plugin|theme|muplugin)';

    protected $locations = array(
        'plugin'    => 'wp-content/plugins/{$name}/',
        'theme'     => 'wp-content/themes/{$name}/',
        'muplugin'  => 'wp-content/mu-plugins/{$name}/',
    );
}
