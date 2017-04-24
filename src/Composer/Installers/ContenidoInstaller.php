<?php
namespace Composer\Installers;

use Composer\Package\PackageInterface;

class ContenidoInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin'    => 'contenido/plugins/{$name}/'
    );
}
