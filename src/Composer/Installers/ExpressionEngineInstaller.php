<?php
namespace Composer\Installers;

class ExpressionEngineInstaller extends BaseInstaller
{

    protected $locations = array(
        'addon'   => 'system/user/addons/{$name}/',
        'theme'   => 'themes/user/{$name}/',
    );
}
