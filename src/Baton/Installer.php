<?php
namespace Baton;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class Installer extends LibraryInstaller
{

    /**
     * Package types to installer class map
     *
     * @var array
     */
    private $supportedTypes = array(
        'cakephp'     => 'CakePHPInstaller',
        'codeigniter' => 'CodeIgniterInstaller',
        'drupal'      => 'DrupalInstaller',
        'fuelphp'     => 'FuelPHPInstaller',
        'joomla'      => 'JoomlaInstaller',
        'laravel'     => 'LaravelInstaller',
        'lithium'     => 'LithiumInstaller',
        'phpbb'       => 'PhpBBInstaller',
        'symfony1'    => 'Symfony1Installer',
        'wordpress'   => 'WordPressInstaller',
    );

    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        $type = $package->getType();
        $packageType = substr($type, 0, strpos($type, '-'));

        if (!isset($this->supportedTypes[$packageType])) {
            throw new \InvalidArgumentException(
                'Sorry the package type of this package is not yet supported.'
            );
        } else {
            $class = "\\Baton\\" . $this->supportedTypes[$packageType];
            $Installer = new $class;
            return $Installer->getInstallPath($package);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        foreach ($this->supportedTypes as $type => $sub) {
            if (substr($packageType, 0, strlen($type)) === $type) {
                return true;
            }
        }
        return false;
    }

}