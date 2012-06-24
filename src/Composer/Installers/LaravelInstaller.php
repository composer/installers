<?php
namespace Composer\Installers;

class LaravelInstaller extends BaseInstaller
{
    protected $locations = array(
        'app'           => '',
        'library'       => 'libraries/{name}/',
    );
}
