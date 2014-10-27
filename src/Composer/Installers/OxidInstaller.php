<?php
namespace Composer\Installers;

class OxidInstaller extends BaseInstaller
{
    protected $locations = array(
	'shop'		=> '{$name}/',
        'module'    => 'modules/{$name}/',
        'theme'  => 'application/views/{$name}/',
        'out'    => 'out/{$name}/'
    );
}
