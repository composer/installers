<?php
namespace Composer\Installers;

class CodeIgniterInstaller extends BaseInstaller
{
    protected $locations = array(
        'library'     => 'libraries/{$name}/',
        'third-party' => 'third_party/{$name}/',
        'module'      => 'modules/{$name}/',
    );
}
