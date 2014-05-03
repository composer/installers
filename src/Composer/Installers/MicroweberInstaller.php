<?php
namespace Composer\Installers;

class MicroweberInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => 'userfiles/modules/{$name}/',
        'template'     => 'userfiles/templates/{$name}/',
        'elements'  => 'userfiles/elements/{$name}/',
    );
}
