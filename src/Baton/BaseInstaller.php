<?php
namespace Baton;

use Composer\Package\BasePackage;

abstract class BaseInstaller
{

    /**
     * Package locations
     *
     * @var array
     */
    protected $locations = array(
        'app' => '',
    );

    /**
     * Default key if none found
     *
     * @var string
     */
    protected $default = null;

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

        $targetDir = $package->getTargetDir();
        if (!empty($targetDir)) {
            return $this->templatePath($targetDir, compact('name', 'vendor', 'type'));
        }

        $base = false;
        if (isset($this->locations[$packageLocation])) {
            $base = $this->locations[$packageLocation];
        } else if (isset($this->locations[$this->default])) {
            $base = $this->locations[$this->default];
        } else if (!empty($this->locations)) {
            $base = current($this->locations);
        }

        if ($base === false) {
            throw new \InvalidArgumentException(
                'Package install location could not be found.'
            );
        }

        return $this->templatePath($base, compact('name', 'vendor', 'type'));
    }

    /**
     * For an installer to override. Modify how the package name is translated.
     *
     * @param string $name
     * @param BasePackage $package
     * @return string
     */
    public function inflectPackageName($name, $package)
    {
        return $name;
    }

    /**
     * Replace vars in a path
     *
     * @param string $path
     * @param array $vars
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