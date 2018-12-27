<?php
namespace Composer\Installers;

/**
 * Provides installer for assets (npm, bower).
 */
class AssetsInstaller extends BaseInstaller
{
    protected $locations = array(
        'asset' => 'assets/{$name}/',
    );
}
