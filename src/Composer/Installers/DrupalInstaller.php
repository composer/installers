<?php
namespace Composer\Installers;

class DrupalInstaller extends BaseInstaller
{
    protected $locations = array(
        'core'             => 'core/',
        'module'           => 'modules/contrib/{$name}/',
        'theme'            => 'themes/contrib/{$name}/',
        'library'          => 'libraries/{$name}/',
        'profile'          => 'profiles/{$name}/',
        'drush'            => 'drush/{$name}/'
    );
}
