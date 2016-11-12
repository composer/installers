<?php
namespace Composer\Installers;

class Concrete5Installer extends BaseInstaller
{
    protected $locations = array(
        'block'      => 'application/blocks/{$name}/',
        'package'    => 'packages/{$name}/',
        'theme'      => 'application/themes/{$name}/',
        'update'     => 'updates/{$name}/',
    );
}
