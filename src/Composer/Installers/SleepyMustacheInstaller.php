<?php
namespace Composer\Installers;

class SleepyMustacheInstaller extends BaseInstaller
{
    protected $locations = array(
        'base'   => 'app/',
        'module' => 'app/modules/{$name}/',
    );
}
