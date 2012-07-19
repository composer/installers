<?php
namespace Composer\Installers;

class DrupalInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => 'modules/{$name}/',
        'theme'     => 'themes/{$name}/',
        'profile'   => 'profiles/{$name}/',
        'drush'     => 'drush/{$name}/',
    );
}
