<?php
namespace Composer\Installers;

class ZendInstaller extends BaseInstaller
{
    protected $locations = array(
        'library' => 'library/',
        'extra'   => 'extras/library/',
    );
}
