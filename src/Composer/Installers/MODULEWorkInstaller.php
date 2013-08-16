<?php
namespace Composer\Installers;

class MODULEWorkInstaller extends BaseInstaller
{
    const PATTERN = 'module';

    protected $locations = array(
        'module'    => 'modules/{$name}/'
    );
}
