<?php
namespace Composer\Installers;

class CodeIgniterInstaller extends BaseInstaller
{
    protected $locations = array(
        'library'     => 'application/libraries/{$name}/',
        'helpers' => 'application/helpers/{$name}/',
        'third-party' => 'application/third_party/{$name}/',
        'module'      => 'application/modules/{$name}/',
    );
}
