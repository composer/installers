<?php
namespace Composer\Installers;

class RedaxoInstaller extends BaseInstaller
{
    protected $locations = array(
        'addon'    => 'redaxo/include/addons/{$name}/',
    );
}
