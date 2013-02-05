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
        'agl'          => 'AglInstaller',
        'cakephp'      => 'CakePHPInstaller',
        'codeigniter'  => 'CodeIgniterInstaller',
        'drupal'       => 'DrupalInstaller',
        'fuel'         => 'FuelInstaller',
        'joomla'       => 'JoomlaInstaller',
        'kohana'       => 'KohanaInstaller',
        'laravel'      => 'LaravelInstaller',
        'lithium'      => 'LithiumInstaller',
        'magento'      => 'MagentoInstaller',
        'mako'         => 'MakoInstaller',
        'mediawiki'    => 'MediaWikiInstaller',
        'phpbb'        => 'PhpBBInstaller',
        'ppi'          => 'PPIInstaller',
        'silverstripe' => 'SilverStripeInstaller',
        'symfony1'     => 'Symfony1Installer',
        'wordpress'    => 'WordPressInstaller',
        'zend'         => 'ZendInstaller',
        'typo3-flow'   => 'TYPO3FlowInstaller'
    );

    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        $type = $package->getType();
        $frameworkType = $this->findFrameworkType($type);

        if ($frameworkType === false) {
            throw new \InvalidArgumentException(
                'Sorry the package type of this package is not yet supported.'
            );
        }

        $class = 'Composer\\Installers\\' . $this->supportedTypes[$frameworkType];
        $installer = new $class($package, $this->composer);

        return $installer->getInstallPath($package, $frameworkType);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        $frameworkType = $this->findFrameworkType($packageType);

        if ($frameworkType === false) {
            return false;
        }

        return preg_match('#' . $frameworkType . '-(\w+)#', $packageType, $matches) === 1;
    }

    /**
     * Finds a supported framework type if it exists and returns it
     *
     * @param  string $type
     * @return string
     */
    protected function findFrameworkType($type)
    {
        $frameworkType = false;

        foreach ($this->supportedTypes as $key => $val) {
            if ($key === substr($type, 0, strlen($key))) {
                $frameworkType = substr($type, 0, strlen($key));
                break;
            }
        }

        return $frameworkType;
    }
}
