<?php
namespace Composer\Installers;

class MorfyInstaller extends BaseInstaller
{
    protected $locations = array(
        'theme'     => 'themes/{$name}/',
        'plugin'       => 'plugins/{$name}/',
    );
}
