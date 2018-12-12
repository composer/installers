<?php
namespace Composer\Installers;

class MelisPlatformInstaller extends BaseInstaller
{
    protected $locations = array(
        'site' => 'module/MelisSites/{$name}/',
    );
}
