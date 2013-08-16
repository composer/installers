<?php
namespace Composer\Installers;

class MagentoInstaller extends BaseInstaller
{
    protected $locations = array(
        /*
         * TODO: Breaking a theme into seperate repos is weird. It would be nice
         * to be able to set an install path map. Maybe out of scope.
         */
        'theme'   => 'app/design/frontend/{$name}/',
        'skin'    => 'skin/frontend/default/{$name}/',
        'library' => 'lib/{$name}/',
    );
}
