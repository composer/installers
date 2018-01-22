<?php
namespace Composer\Installers;

class Yii2Installer extends BaseInstaller
{
    protected $locations = array(
        'theme'     => 'web/{$name}/',
    );
}
