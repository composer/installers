<?php
namespace Composer\Installers;

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
        'cakephp'      => 'CakePHPInstaller',
        'codeigniter'  => 'CodeIgniterInstaller',
        'drupal'       => 'DrupalInstaller',
        'fuelphp'      => 'FuelPHPInstaller',
        'joomla'       => 'JoomlaInstaller',
        'kohana'       => 'KohanaInstaller',
        'laravel'      => 'LaravelInstaller',
        'lithium'      => 'LithiumInstaller',
        'magento'      => 'MagentoInstaller',
        'mako'         => 'MakoInstaller',
        'phpbb'        => 'PhpBBInstaller',
        'ppi'          => 'PPIInstaller',
        'silverstripe' => 'SilverStripeInstaller',
        'symfony1'     => 'Symfony1Installer',
        'wordpress'    => 'WordPressInstaller',
        'zend'         => 'ZendInstaller'
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
        }

        $class = 'Composer\\Installers\\' . $this->supportedTypes[$packageType];
        $installer = new $class($package, $this->composer);

        return $installer->getInstallPath();
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        if (preg_match('#(\w+)-(\w+)#', $packageType, $matches)) {
            return isset($this->supportedTypes[$matches[1]]);
        }

        return false;
    }
}
