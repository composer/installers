<?php
namespace Composer\Installers;

class LithiumInstaller extends BaseInstaller
{
    const PATTERN = '(library|source)';

    protected $locations = array(
        'library' => 'libraries/{$name}/',
        'source'  => 'libraries/_source/{$name}/'
    );
}
