<?php
namespace Composer\Installers;

class QuicksilverInstaller extends BaseInstaller
{
    protected $locations = array(
        'script'    => 'web/private/scripts/quicksilver/{$name}/',
    );
}
