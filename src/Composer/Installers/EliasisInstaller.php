<?php
namespace Composer\Installers;

class EliasisInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'  => 'modules/{$name}/'
    );
}
