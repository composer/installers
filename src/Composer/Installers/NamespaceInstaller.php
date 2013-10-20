<?php
/*
 * Composer Installers
 */
namespace Composer\Installers;

use Composer\Composer;
use Composer\Package\PackageInterface;

/**
 * Custom namespace installer for Composer.
 * This installer converts the vendor and package name
 * to CamelCase suitable to be used as a formal namespace.
 * @example vendor-name/package-name to VendorName/PackageName
 */
class NamespaceInstaller extends BaseInstaller
{
    /**
     * Installation locations
     * @var array
     */
    protected $locations = array(
        'vendor-package' => '{$vendorDir}/{$vendor}/{$name}/',
    );

    /**
     * Substitute package variables
     * @param array $vars
     * @return array
     */
    public function inflectPackageVars($vars)
    {
        $vars['name']   = $this->formatToCamelCase($vars['name']);
        $vars['vendor'] = $this->formatToCamelCase($vars['vendor']);

        return $vars;
    }

    /**
     * Format string to CamelCase keeping existing uppercase chars.
     * @param string $string
     * @return string
     */
    protected function formatToCamelCase($string)
    {
        $string = str_replace('-', ' ', $string);
        return str_replace(' ', '', ucwords($string));
    }
}
