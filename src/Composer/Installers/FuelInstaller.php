<?php
namespace Composer\Installers;

class FuelInstaller extends BaseInstaller
{
    const PATTERN = '(module|package)';

    protected $locations = array(
        'module'  => 'fuel/app/modules/{$name}/',
        'package' => 'fuel/packages/{$name}/',
    );
}
