<?php

namespace Composer\Installers;

class LaminasInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module' => 'module/{$name}/',
    ];
}