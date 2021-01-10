<?php
namespace Composer\Installers;

class StarbugInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'modules/{$name}/'
    );
}
