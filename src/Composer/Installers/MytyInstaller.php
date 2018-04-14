<?php
namespace Composer\Installers;

/**
 * Composer installer for myty projects and modules.
 * Myty is a closed source CMF/CMS developed by tyclipso.net since 2003
 * @see https://myty.readme.io
 * @see https://tyclipso.net
 */
class MytyInstaller extends BaseInstaller
{
    // Myty composer components are located in DocRoot/3rdParty
    protected $locations = array(
        'base' => 'tycon/',
        'project' => 'projects/{$name}/',
        'module'   => 'tycon/modules/{$name}/'
    );
}
