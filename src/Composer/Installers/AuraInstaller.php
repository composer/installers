<?php
namespace Composer\Installers;

class AuraInstaller extends BaseInstaller
{
    protected $locations = array(
        'package'    => 'package/{$name}/',
        'include'     => 'include/{$name}/',
    );
}
