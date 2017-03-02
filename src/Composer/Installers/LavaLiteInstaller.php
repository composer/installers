<?php
namespace Composer\Installers;

class LavaLiteInstaller extends BaseInstaller
{
    protected $locations = array(
        'package' => 'packages/{$name}/',
        'theme'   => 'public/themes/{$name}/',
    );
}
