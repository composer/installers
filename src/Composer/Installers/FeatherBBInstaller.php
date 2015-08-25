<?php
namespace Composer\Installers;

class FeatherBBInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin'    => 'plugin/{$name}/',
        'language'  => 'lang/{$name}/',
        'style'     => 'styles/{$name}/',
    );
}
