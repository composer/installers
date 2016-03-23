<?php
namespace Composer\Installers;

class DrupalInstaller extends BaseInstaller
{
	protected $locations = array(
		'core'                => 'core/',
		'drush'               => 'drush/{$name}/',
		'module'              => 'modules/contrib/{$name}/',
		'custom-module'       => 'modules/custom/{$name}/',
		'library'             => 'libraries/{$name}/',
		'theme'               => 'themes/contrib/{$name}/',
		'custom-theme'        => 'themes/custom/{$name}/',
		'profile'             => 'profiles/contrib/{$name}/',
		'custom-profile'      => 'profiles/custom/{$name}/',
		'theme-engine'        => 'themes/engines/contrib/{$name}/',
		'custom-theme-engine' => 'themes/engines/custom/{$name}/',
	);
}
