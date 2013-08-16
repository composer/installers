<?php
namespace Composer\Installers;

class LaravelInstaller extends BaseInstaller
{
    const PATTERN = 'library';

    protected $locations = array(
        'library' => 'libraries/{$name}/',
    );
}
