<?php
namespace Composer\Installers;

class DrupalInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => 'sites/all/modules/{$name}/',
        'theme'     => 'sites/all/themes/{$name}/',
        'profile'   => 'profiles/{$name}/',
        'drush'     => 'drush/{$name}/',
    );
}
