<?php
namespace Composer\Installers;

class Concrete5Installer extends BaseInstaller
{
    protected $locations = array(
        'package'    => 'packages/{$name}/',
        'theme'      => 'themes/{$name}/',
        'block'      => 'blocks/{$name}/',
    );
}
