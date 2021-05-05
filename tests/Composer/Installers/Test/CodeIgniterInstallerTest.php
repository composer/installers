<?php
namespace Composer\Installers\Test;

use Composer\Installers\CodeIgniterInstaller;
use Composer\Repository\RepositoryManager;
use Composer\Repository\InstalledArrayRepository;
use Composer\Package\Package;
use Composer\Package\RootPackage;
use Composer\Package\Version\VersionParser;
use Composer\Composer;
use Composer\Config;

class CodeIgniterInstallerTest extends TestCase
{
    /**
     * @var Composer
     */
    private $composer;
    /**
     * @var Package
     */
    private $package;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $this->package = new Package('CamelCased', '1.0', '1.0');
        $this->composer = new Composer();
        $this->composer->setConfig(new Config(false));
    }

    /**
     * testInflectPackageVars
     *
     * @return void
     */
    public function testInflectPackageVars()
    {
        $installer = new CodeIgniterInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'AdiPrasetyo'));
        $this->assertEquals($result, array('name' => 'AdiPrasetyo'));

        $installer = new CodeIgniterInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'ap-programming'));
        // $this->assertEquals($result, array('name' => 'ApProgramming'));

        $installer = new CodeIgniterInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'youtube_ap_programming'));
        $this->assertEquals($result, array('name' => 'YoutubeApProgramming'));

        $installer = new CodeIgniterInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'sukrosono/youtube'));
        $this->assertEquals($result, array('name' => 'Sukrosono/Youtube'));

        $installer = new CodeIgniterInstaller($this->package, $this->composer);
        $result = $installer->inflectPackageVars(array('name' => 'ap/enter-rebel'));
        $this->assertEquals($result, array('name' => 'Ap/EnterRebel'));
    }

    /**
     * Test getLocations returning appropriate values based on CodeIgniter 3.1.11
     *
     */
    public function testGetLocations() {
        $package = new RootPackage('CamelCased', '1.0', '1.0');
        $composer = $this->composer;

        $io = $this->getMockBuilder('Composer\IO\IOInterface')->getMock();
        $config = $this->getMockBuilder('Composer\Config')->getMock();

        // Simultaneous support for Composer 1 and 2
        $constructorArg3 = null;
        $reflectorClass = new \ReflectionClass( '\Composer\Repository\RepositoryManager');
        if ($reflectorClass->getConstructor()->getNumberOfRequiredParameters() == 3) {
            $constructorArg3 = $this->getMockBuilder('Composer\Util\HttpDownloader')->disableOriginalConstructor()->getMock();
        }
        $rm = new RepositoryManager(
            $io,
            $config,
            $constructorArg3
        );
        $composer->setRepositoryManager($rm);
        $installer = new CodeIgniterInstaller($package, $composer);

        // initial test
        $this->setCIVersion($rm, '3.1.11');
        $result = $installer->getLocations();
        // $this->assertStringContainsString('application/', $result['application']);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('module', $result);

    }

    protected function setCIVersion($rm, $version) {
        $parser = new VersionParser();
        list(, $version) = explode(' ', $parser->parseConstraints($version));
        $installed = new InstalledArrayRepository();
        $package = new Package('codeigniter/framework', $version, $version);
        $installed->addPackage($package);
        $rm->setLocalRepository($installed);
    }

}
