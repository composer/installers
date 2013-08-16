<?php
namespace Composer\Installers;

class PhpBBInstaller extends BaseInstaller
{
    const PATTERN = '(extension|language|style)';

    protected $locations = array(
        'extension' => 'ext/{$vendor}/{$name}/',
        'language'  => 'language/{$name}/',
        'style'     => 'styles/{$name}/',
    );
}
