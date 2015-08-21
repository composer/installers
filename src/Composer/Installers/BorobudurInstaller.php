<?php
namespace Composer\Installers;

class BorobudurInstaller extends BaseInstaller
{
    public function getLocations()
    {
        $vendorDir = $this->composer->getConfig()->get('vendor-dir');

        return array(
            'component' => sprintf('%s/{$vendor}/components/{$name}/', $vendorDir),
            'bundle' => sprintf('%s/{$vendor}/bundles/{$name}/', $vendorDir)
        );
    }
}
