<?php
namespace Composer\Installers\Test;

use Composer\Installers\CakePHPInstaller;
use Composer\Package\Package;
use Composer\Package\RootPackage;
use Composer\Package\Link;
use Composer\Package\Version\VersionParser;
use Composer\Composer;

class CakePHPInstallerTest extends TestCase
{
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
        $installer = new CakePHPInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'CamelCased'));
        $this->assertEquals($result, array('name' => 'CamelCased'));

        $installer = new CakePHPInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'with-dash'));
        $this->assertEquals($result, array('name' => 'WithDash'));

        $installer = new CakePHPInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'with_underscore'));
        $this->assertEquals($result, array('name' => 'WithUnderscore'));

        $installer = new CakePHPInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'cake/acl'));
        $this->assertEquals($result, array('name' => 'Cake/Acl'));

        $installer = new CakePHPInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'cake/debug-kit'));
        $this->assertEquals($result, array('name' => 'Cake/DebugKit'));
    }

    /**
     * Test getLocations returning appropriate values based on CakePHP version
     *
     */
    public function testGetLocations() {
        $parser = new VersionParser();
        $package = new RootPackage('CamelCased', '1.0', '1.0');
        $composer = new Composer();
        $installer = new CakePHPInstaller($package, $composer);

        // 2.0 < cakephp < 3.0
        $version = $parser->parseConstraints('2.0.0');
        $package->setRequires(array(
            new Link('CamelCased', 'cakephp/cakephp', $version)
        ));
        $composer->setPackage($package);
        $result = $installer->getLocations();
        $this->assertContains('Plugin/', $result['plugin']);

        $version = $parser->parseConstraints('2.5.9');
        $package->setRequires(array(
            new Link('CamelCased', 'cakephp/cakephp', $version)
        ));
        $composer->setPackage($package);
        $result = $installer->getLocations();
        $this->assertContains('Plugin/', $result['plugin']);

        // cakephp >= 3.0
        $version = $parser->parseConstraints('3.0.*-dev');
        $package->setRequires(array(
            new Link('CamelCased', 'cakephp/cakephp', $version)
        ));
        $composer->setPackage($package);
        $result = $installer->getLocations();
        $this->assertContains('plugins/', $result['plugin']);

        $version = $parser->parseConstraints('~8.8');
        $package->setRequires(array(
            new Link('CamelCased', 'cakephp/cakephp', $version)
        ));
        $composer->setPackage($package);
        $result = $installer->getLocations();
        $this->assertContains('plugins/', $result['plugin']);
    }

}
