<?php
namespace Composer\Installers;

class LithiumInstaller extends BaseInstaller
{
    protected $locations = array(
        'app'     => '',
        'library' => 'libraries/{$name}/',
        'source'  => 'libraries/_source/{$name}/'
    );
}
