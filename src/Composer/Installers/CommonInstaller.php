<?php
namespace Composer\Installers;

class CommonInstaller extends BaseInstaller
{
    protected $locations = array(
        'webroot'    => '{$webroot}/',
    );
}
