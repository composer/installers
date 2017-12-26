<?php
namespace Composer\Installers;

class CiviCrmInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => 'ext/{$name}/'
    );
}
