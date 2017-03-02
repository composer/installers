<?php
namespace Composer\Installers;

class LavaLiteInstaller extends BaseInstaller
{
    protected $locations = [
        'package' => 'packages/{$name}/',
        'theme'   => 'public/themes/{$name}/',
    ];
}
