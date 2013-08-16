<?php
namespace Composer\Installers;

class AnnotateCmsInstaller extends BaseInstaller
{
    const PATTERN = '(module|component|service)';

    protected $locations = array(
        'module'    => 'addons/modules/{$name}/',
        'component' => 'addons/components/{$name}/',
        'service'   => 'addons/services/{$name}/',
    );
}
