<?php
namespace Composer\Installers;

class PPIInstaller extends BaseInstaller
{
    const PATTERN = 'module';

    protected $locations = array(
        'module' => 'modules/{$name}/',
    );
}
