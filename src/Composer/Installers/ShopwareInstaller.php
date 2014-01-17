<?php
namespace Composer\Installers;

class ShopwareInstaller extends BaseInstaller
{
    protected $locations = array(
        'backend-plugin'    => 'engine/Shopware/Plugins/Local/Backend/{$name}/',
        'core-plugin'       => 'engine/Shopware/Plugins/Local/Core/{$name}/',
        'frontend-plugin'   => 'engine/Shopware/Plugins/Local/Frontend/{$name}/',
        'theme'             => 'templates/{$name}/'
    );
}
