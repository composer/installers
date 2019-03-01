<?php
namespace Composer\Installers;

/**
 * An installer to handle MODX specifics when installing packages.
 */
class MODXInstaller extends BaseInstaller
{
    protected $locations = array(
        'extra' => 'core/packages/{$name}/',
        'component' => '{$name}'
    );
}
