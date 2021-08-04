<?php

namespace Composer\Installers;

class PantheonInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'quicksilver-script' => 'web/private/scripts/quicksilver/{$name}/',
        'quicksilver-module' => 'web/private/scripts/quicksilver/{$name}/',
    );
}
