<?php
namespace Composer\Installers;

class MakoInstaller extends BaseInstaller
{
    const PATTERN = 'package';

    protected $locations = array(
        'package' => 'app/packages/{$name}/',
    );
}
