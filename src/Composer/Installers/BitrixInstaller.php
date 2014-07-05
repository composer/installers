<?php
namespace Composer\Installers;

class BitrixInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => 'local/modules/{$name}/',
        'component' => 'local/components/{$name}/',
        'theme'     => 'bitrix/themes/{$name}/'
    );
}
