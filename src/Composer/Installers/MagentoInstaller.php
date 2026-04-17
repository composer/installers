<?php

namespace Composer\Installers;

class MagentoInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'i18n'   => 'app/i18n/{$name}/',
        'theme'   => 'app/design/frontend/{$name}/',
        'skin'    => 'skin/frontend/default/{$name}/',
        'library' => 'lib/{$name}/',
    );
}
