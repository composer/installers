<?php
namespace Composer\Installers;

class BlestaInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin' => 'plugins/{$name}/',
        'gateway-merchant' => 'components/gateways/merchant/{$name}/',
        'gateway-nonmerchant' => 'components/gateways/nonmerchant/{$name}/',
        'module' => 'components/modules/{$name}/',
        'invoice-template' => 'components/invoice_templates/{$name}/',
        'report' => 'components/reports/{$name}/',
    );
}
