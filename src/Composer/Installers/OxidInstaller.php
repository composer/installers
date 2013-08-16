<?php
namespace Composer\Installers;

class OxidInstaller extends BaseInstaller
{
    const PATTERN = 'module';

    protected $locations = array(
        'module'    => 'modules/{$name}/'
    );
}
