<?php
namespace Composer\Installers;

class ZendInstaller extends BaseInstaller
{
    const PATTERN = '(library|extra)';

    protected $locations = array(
        'library' => 'library/{$name}/',
        'extra'   => 'extras/library/{$name}/',
    );
}
