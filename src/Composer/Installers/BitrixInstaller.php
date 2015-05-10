<?php
namespace Composer\Installers;

class BitrixInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => 'bitrix/modules/{$name}/',
        'component' => 'bitrix/components/{$name}/',
        'theme'     => 'bitrix/templates/{$name}/'
    );
}
