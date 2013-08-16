<?php
namespace Composer\Installers;

class DrupalInstaller extends BaseInstaller
{
    const PATTERN = '(module|theme|profile|drush)';

    protected $locations = array(
        'module'    => 'modules/{$name}/',
        'theme'     => 'themes/{$name}/',
        'profile'   => 'profiles/{$name}/',
        'drush'     => 'drush/{$name}/',
    );
}
