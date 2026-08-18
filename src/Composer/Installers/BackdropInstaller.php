<?php

namespace Composer\Installers;

class BackdropInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'core'    => 'core/',
        'module'  => 'modules/{$name}/',
        'theme'   => 'themes/{$name}/',
        'layout'  => 'layouts/{$name}/',
        'profile' => 'profiles/{$name}/',
        'drush'   => 'drush/{$name}/',
    );
}
