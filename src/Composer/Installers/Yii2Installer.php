<?php
namespace Composer\Installers;

class Yii2Installer extends BaseInstaller
{
    protected $locations = array(
      'extensions' => 'extensions/{$name}',
      'modules'    => 'modules/{$name}',
      'theme'      => 'web/{$name}/',
    );
}
