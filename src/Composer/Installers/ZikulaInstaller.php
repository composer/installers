<?php
namespace Composer\Installers;

class ZikulaInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'extensions/{$vendor}-{$name}/',
        'theme'  => 'extensions/{$vendor}-{$name}/'
    );
}
