<?php
namespace Composer\Installers;

class CodeIgniterInstaller extends BaseInstaller
{
    const PATTERN = '(library|third-party|module)';

    protected $locations = array(
        'library'     => 'application/libraries/{$name}/',
        'third-party' => 'application/third_party/{$name}/',
        'module'      => 'application/modules/{$name}/',
    );
}
