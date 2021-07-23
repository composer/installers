<?php

namespace Composer\Installers;

class AimeosInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'extension'   => 'ext/{$name}/',
    );
}
