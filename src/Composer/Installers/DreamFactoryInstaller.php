<?php
namespace Composer\Installers;

class DreamFactoryInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin'  => 'storage/plugins/{$vendor}/{$name}/',
        'library' => 'storage/plugins/{$vendor}/{$name}/',
        'app'     => 'web/{$name}/',
    );
}
