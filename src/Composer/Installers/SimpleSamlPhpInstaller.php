<?php
namespace Composer\Installers;

class SimpleSamlPhpInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => 'vendor/simplesamlphp/simplesamlphp/modules/{$name}/'
    );
}
