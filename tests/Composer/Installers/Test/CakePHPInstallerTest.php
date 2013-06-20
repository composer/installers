<?php
namespace Composer\Installers\Test;

use Composer\Package\Package;
use Composer\Composer;
use Composer\Config;

class CakePHPInstallerTest extends TestCase
{
    private $composer;
    private $config;
    private $vendorDir;
    private $binDir;
    private $dm;
    private $repository;
    private $io;
    private $fs;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
	    $this->package = new Package('CamelCased', '1.0', '1.0');
	    $this->io = $this->getMock('Composer\IO\PackageInterface');
	    $this->composer = new Composer();
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {

    }

    /**
     * testInflectPackageVars
     *
     * @return void
     */
    public function testInflectPackageVars()
    {
        $installer = new \Composer\Installers\CakePHPInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'CamelCased'));
        $this->assertEquals($result, array('name' => 'CamelCased'));

        $installer = new \Composer\Installers\CakePHPInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'with-dash'));
        $this->assertEquals($result, array('name' => 'WithDash'));

        $installer = new \Composer\Installers\CakePHPInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'with_underscore'));
        $this->assertEquals($result, array('name' => 'WithUnderscore'));
    }

}
