<?php
namespace Composer\Installers;

class KohanaInstaller extends BaseInstaller
{
    const PATTERN = 'module';

    protected $locations = array(
        'module' => 'modules/{$name}/',
    );
}
