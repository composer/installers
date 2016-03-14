<?php
namespace Composer\Installers;

class TypiCMSInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'Modules/{$name}/',
    );
}
