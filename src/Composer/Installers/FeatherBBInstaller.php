<?php
namespace Composer\Installers;

class FeatherBBInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin'    => 'plugins/{$name}/',
        'language'  => 'featherbb/lang/{$name}/',
        'theme'     => 'style/themes/{$name}/',
    );
}
