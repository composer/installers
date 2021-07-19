<?php

namespace Composer\Installers;

class AkauntingInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'modules/{$name}',
    );
}