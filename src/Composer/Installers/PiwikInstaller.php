<?php
namespace Composer\Installers;

class PiwikInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin' => 'plugins/{$name}/',
    );
}
