<?php
namespace Composer\Installers\Test;

use Composer\Installers\CakePHPInstaller;
use Composer\Installers\ContaoInstaller;
use Composer\Repository\RepositoryManager;
use Composer\Repository\InstalledArrayRepository;
use Composer\Package\Package;
use Composer\Package\RootPackage;
use Composer\Package\Link;
use Composer\Package\Version\VersionParser;
use Composer\Composer;

class ContaoInstallerTest extends TestCase
{
    private $package;
    private $composer;
    private $io;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $this->package = new Package('CamelCased', '1.0', '1.0');
        $this->package->setExtra(array(
                'installer-name' => 'cased',
                'contao-major-version' => 2
            ));
        $this->io = $this->getMock('Composer\IO\PackageInterface');
        $this->composer = new Composer();
    }

    /**
     * testInflectPackageVars
     *
     * @return void
     */
    public function testInflectPackageVars()
    {
        $installer = new ContaoInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'CamelCased'));
        $this->assertEquals($result, array('name' => 'camelcased'));

        $installer = new ContaoInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'alllowercase'));
        $this->assertEquals($result, array('name' => 'alllowercase'));

        $installer = new ContaoInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'with-dash'));
        $this->assertEquals($result, array('name' => 'with-dash'));
    }

}