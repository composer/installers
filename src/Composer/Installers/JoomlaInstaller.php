<?php
namespace Composer\Installers;

class JoomlaInstaller extends BaseInstaller
{
    const PATTERN = '(component|module|template|plugin|library)';

    protected $locations = array(
        'component'    => 'components/{$name}/',
        'module'       => 'modules/{$name}/',
        'template'     => 'templates/{$name}/',
        'plugin'       => 'plugins/{$name}/',
        'library'      => 'libraries/{$name}/',
    );

    // TODO: Add inflector for mod_ and com_ names
}
