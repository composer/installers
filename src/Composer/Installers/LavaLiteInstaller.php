<?php
namespace Composer\Installers;
class LavaLiteInstaller extends BaseInstaller
{
    protected $locations = array(
        'theme'     => 'public/themes/{$name}/',
        'package'   => 'packages/{$name}/',
    );
