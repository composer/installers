<?php
namespace Composer\Installers;

/**
 * An installer to handle TYPO3 Flow specifics when installing packages.
 */
class TYPO3FlowInstaller extends BaseInstaller
{
    protected $locations = array(
        'package'   => 'Packages/Application/{$name}/',
        'framework' => 'Packages/Framework/{$name}/',
        'plugin'    => 'Packages/Plugins/{$name}/',
        'site'      => 'Packages/Sites/{$name}/',
        'build'     => 'Build/{$name}/',
    );
}
