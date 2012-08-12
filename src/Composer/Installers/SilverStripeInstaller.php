<?php
namespace Composer\Installers;

class SilverStripeInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => '{$name}/',
        'theme'  => 'themes/{$name}/',
    );
}
