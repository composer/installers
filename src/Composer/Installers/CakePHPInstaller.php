<?php
namespace Composer\Installers;

use Composer\Package\PackageInterface;
use Composer\Package\LinkConstraint\VersionConstraint;

class CakePHPInstaller extends BaseInstaller
{
    protected $locations = array(
        'plugin' => 'Plugin/{$name}/',
    );

    /**
     * Format package name to CamelCase
     */
    public function inflectPackageVars($vars)
    {
        $nameParts = explode('/', $vars['name']);
        foreach ($nameParts as &$value) {
            $value = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $value));
            $value = str_replace(array('-', '_'), ' ', $value);
            $value = str_replace(' ', '', ucwords($value));
        }
        $vars['name'] = implode('/', $nameParts);

        return $vars;
    }

    /**
     * Change the default plugin location when cakephp >= 3.0
     */
    public function getLocations() {
        $package = $this->composer->getPackage();
        if (!$package) {
            return $this->locations;
        }
        $requires = $package->getRequires();
        foreach ($requires as $require) {
            if ($require->getTarget() === 'cakephp/cakephp') {
                $cake3 = new VersionConstraint('>=', '3.0.0');
                if ($cake3->matches($require->getConstraint())) {
                    $this->locations['plugin'] = 'plugins/{$name}/';
                }
                break;
            }
        }
        return $this->locations;
    }
}
