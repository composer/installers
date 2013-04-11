<?php
namespace Composer\Installers;

class KohanaInstaller extends BaseInstaller
{
    protected $locations = array(
        'module' => 'modules/{$name}/',
        'vendor' => 'application/vendor/{$name}/',
    );
}
