<?php
namespace Composer\Installers;

class BagistoInstaller extends BaseInstaller
{
    protected $locations = array(
        'package' => 'packages/Webkul/{$name}/',
        'theme'   => 'packages/Webkul/Themes/{$name}/',
    );
}
