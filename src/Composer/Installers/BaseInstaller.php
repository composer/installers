<?php
namespace Composer\Installers;

use Composer\Package\BasePackage;

abstract class BaseInstaller
{
    /**
     * Package locations
     *
     * @var array
     */
    protected $locations = array();

    /**
     * Return the install path based on package type.
     *
     * @return string
     */
    public function getInstallPath(BasePackage $package)
    {
        $type = $package->getType();
        $packageLocation = strtolower(substr($type, strpos($type, '-') + 1));

        $name = $package->getPrettyName();
        list($vendor, $name) = explode('/', $name);
        $name = $this->inflectPackageName($name, $package);

        if (!isset($this->locations[$packageLocation])) {
            throw new \InvalidArgumentException(sprintf('Package type "%s" is not supported', $type));
        }

        return $this->templatePath($this->locations[$packageLocation], compact('name', 'vendor', 'type'));
    }

    /**
     * For an installer to override. Modify how the package name is translated.
     *
     * @param  string      $name
     * @param  BasePackage $package
     * @return string
     */
    public function inflectPackageName($name, $package)
    {
        return $name;
    }

    /**
     * Replace vars in a path
     *
     * @param  string $path
     * @param  array  $vars
     * @return string
     */
    protected function templatePath($path, $vars = array())
    {
        if (strpos($path, '{') !== false) {
            extract($vars);
            preg_match_all('@\{([A-Za-z0-9_]*)\}@i', $path, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $var) {
                    $path = str_replace('{' . $var . '}', $$var, $path);
                }
            }
        }

        return $path;
    }
}
