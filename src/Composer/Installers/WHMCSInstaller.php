<?php

namespace Composer\Installers;

class WHMCSInstaller extends BaseInstaller
{
    protected $locations = array(
        'addons' => 'modules/addons/{$name}/',
        'fraud' => 'modules/fraud/{$name}/',
        'gateways' => 'modules/gateways/{$name}/',
        'notifications' => 'modules/notifications/{$name}/',
        'registrars' => 'modules/registrars/{$name}/',
        'reports' => 'modules/reports/{$name}/',
        'security' => 'modules/security/{$name}/',
        'servers' => 'modules/servers/{$name}/',
        'social' => 'modules/social/{$name}/',
        'support' => 'modules/support/{$name}/',
        'widgets' => 'modules/widgets/{$name}/',
        'hooks' => 'includes/hooks/',
        'api' => 'includes/api/',
        'lang' => 'lang/overrides/',
        'feeds' => 'feeds/',
        'templates' => 'templates/{$name}/',
        'includes' => 'includes/{$name}/'
    );
}
