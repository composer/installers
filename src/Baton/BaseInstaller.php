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
        'app' => '/',
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
        list($packageVendor, $name) = explode('/', $name);
        $name = $this->inflectPackageName($name);

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

        if (strpos($base, '{') !== false) {
            preg_match_all('@\{([A-Za-z0-9_]*)\}@i', $base, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $var) {
                    $base = str_replace('{' . $var . '}', $$var, $base);
                }
            }
        }

        return $base;
    }

    /**
     * Modify how the package name is translated.
     *
     * @param string $name
     * @return string
     */
    public function inflectPackageName($name)
    {
        return $name;
    }

}