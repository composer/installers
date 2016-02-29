<?php
namespace Composer\Installers;

class MolajoInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin'   => 'Source/Plugins/{$name}/',
        'resource' => 'Source/Resources/{$name}/',
        'theme' => 'Source/Themes/{$name}/'
    );
}
