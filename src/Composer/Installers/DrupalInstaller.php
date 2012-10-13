<?php
namespace Composer\Installers;

class DrupalInstaller extends BaseInstaller
{
    protected $locations = array(
        'core'      => 'core',
        'module'    => 'modules/{$name}/',
        'theme'     => 'themes/{$name}/',
        'profile'   => 'profiles/{$name}/',
        'drush'     => 'drush/{$name}/',
    );
}
