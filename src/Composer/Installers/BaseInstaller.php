<?php
namespace Composer\Installers;

use Composer\Composer;
use Composer\Package\PackageInterface;

abstract class BaseInstaller
{
    protected $locations = array();
    protected $composer;
    protected $package;

    /**
     * Initializes base installer.
     *
     * @param PackageInterface $package
     * @param Composer         $composer
     */
    public function __construct(PackageInterface $package, Composer $composer)
    {
        $this->composer = $composer;
        $this->package = $package;
    }

    /**
     * Return the install path based on package type.
     *
     * @param  PackageInterface $package
     * @return string
     */
    public function getInstallPath(PackageInterface $package)
    {
        $type = $this->package->getType();
        $packageLocation = strtolower(substr($type, strpos($type, '-') + 1));

        $prettyName = $this->package->getPrettyName();
        if (strpos($prettyName, '/') !== false) {
            list($vendor, $name) = explode('/', $prettyName);
        } else {
            $vendor = '';
            $name = $prettyName;
        }

        $availableVars = $this->inflectPackageVars(compact('name', 'vendor', 'type'));

        $customPath = $this->getCustomInstallPath($package, $prettyName);
        if ($customPath !== false) {
            $installPath = $customPath;
        }
        if ($this->composer->getPackage()) {
            $customPath = $this->getCustomInstallPath($this->composer->getPackage(), $prettyName);
            if ($customPath !== false) {
                $installPath = $customPath;
            }
        }

        if (!empty($installPath)) {
            return $this->templatePath($installPath, $availableVars);
        }

        if (!isset($this->locations[$packageLocation])) {
            throw new \InvalidArgumentException(sprintf('Package type "%s" is not supported', $type));
        }

        return $this->templatePath($this->locations[$packageLocation], $availableVars);
    }

    /**
     * For an installer to override to modify the vars per installer.
     *
     * @param  array $vars
     * @return array
     */
    public function inflectPackageVars($vars)
    {
        return $vars;
    }

    /**
     * Search through extra.installers-paths for a custom install path.
     *
     * @param  PackageInterface $package
     * @param  string $prettyName
     * @return string
     */
    protected function getCustomInstallPath(PackageInterface $package, $prettyName) {
        $extra = $package->getExtra();
        if (empty($extra['installer-paths'])) {
            return false;
        }

        foreach ($extra['installer-paths'] as $path => $names) {
            if (in_array($prettyName, $names)) {
                return $path;
            }
        }

        return false;
    }

    /**
     * Replace vars in a path
     *
     * @param  string $path
     * @param  array  $vars
     * @return string
     */
    protected function templatePath($path, array $vars = array())
    {
        if (strpos($path, '{') !== false) {
            extract($vars);
            preg_match_all('@\{\$([A-Za-z0-9_]*)\}@i', $path, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $var) {
                    $path = str_replace('{$' . $var . '}', $$var, $path);
                }
            }
        }

        return $path;
    }
}
