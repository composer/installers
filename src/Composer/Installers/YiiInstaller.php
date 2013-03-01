<?php
namespace Composer\Installers;

class YiiInstaller extends BaseInstaller
{
    protected $locations = array(
        'extension' => 'protected/extensions/{$name}/',
        'module'  => 'protected/modules/{$name}/',
    );
}
