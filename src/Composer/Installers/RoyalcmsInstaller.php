<?php
namespace Composer\Installers;

class RoyalcmsInstaller extends BaseInstaller
{
    protected $locations = array(
        'app'       => 'content/apps/{$name}/',
        'plugin'    => 'content/plugins/{$name}/',
        'theme'     => 'content/themes/{$name}/',
    );
}
