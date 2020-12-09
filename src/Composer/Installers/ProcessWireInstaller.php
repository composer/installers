<?php

namespace Composer\Installers;

class ProcessWireInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'  => 'site/modules/{$name}/',
    );
}
