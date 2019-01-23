<?php

namespace Composer\Installers;

class NitroPHPInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => 'Module/{$name}/'
    );
}
