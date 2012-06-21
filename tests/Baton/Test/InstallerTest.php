<?php
namespace Baton\Test;

use Baton\Installer;
use Composer\Util\Filesystem;
use Composer\Package\MemoryPackage;

class InstallerTest extends TestCase
{

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
        $this->fs = new Filesystem;

        $this->vendorDir = realpath(sys_get_temp_dir()) . DIRECTORY_SEPARATOR . 'baton-test-vendor';
        $this->ensureDirectoryExistsAndClear($this->vendorDir);

        $this->binDir = realpath(sys_get_temp_dir()) . DIRECTORY_SEPARATOR . 'baton-test-bin';
        $this->ensureDirectoryExistsAndClear($this->binDir);

        $this->dm = $this->getMockBuilder('Composer\Downloader\DownloadManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = $this->getMock('Composer\Repository\InstalledRepositoryInterface');

        $this->io = $this->getMock('Composer\IO\IOInterface');
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        $this->fs->removeDirectory($this->vendorDir);
        $this->fs->removeDirectory($this->binDir);
    }

    /**
     * testSupports
     *
     * @return void
     *
     * @dataProvider dataForTestSupport
     */
    public function testSupports($type, $result)
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $this->assertSame($result, $Installer->supports($type), sprintf('Failed to show support for %s', $type));
    }

    public function dataForTestSupport()
    {
        return array(
            array('cakephp', false),
            array('cakephp-', false),
            array('cakephp-app', true),
            array('codeigniter-app', true),
            array('drupal-module', true),
            array('fuelphp-module', true),
            array('joomla-library', true),
            array('laravel-library', true),
            array('lithium-library', true),
            array('phpbb-extension', true),
            array('symfony1-plugin', true),
            array('wordpress-plugin', true),
            array('zend-library', true),
        );
    }

    /**
     * testWithTargetDir
     *
     * @return void
     */
    public function testWithTargetDir()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('shama/ftp', '1.0.0', '1.0.0');
        $Package->setType('cakephp-plugin');
        $Package->setExtra(array(
            'baton' => array(
                'path' => 'a/custom/Path/{name}/',
            ),
        ));
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('a/custom/Path/Ftp/', $result);

        $Package->setType('zend-extra');
        $Package->setExtra(array(
            'baton' => array(
                'path' => 'a/customZend/Path/{vendor}/{name}/',
            ),
        ));
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('a/customZend/Path/shama/ftp/', $result);
    }

    /**
     * testGetCakePHPInstallPath
     *
     * @return void
     */
    public function testGetCakePHPInstallPath()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('shama/ftp', '1.0.0', '1.0.0');

        $Package->setType('cakephp-plugin');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('Plugin/Ftp/', $result);
    }

    /**
     * testGetCakePHPInstallPathException
     *
     * @return void
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetCakePHPInstallPathException()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('shama/ftp', '1.0.0', '1.0.0');

        $Package->setType('cakephp-whoops');
        $result = $Installer->getInstallPath($Package);
    }

    /**
     * testGetCodeIgniterInstallPath
     *
     * @return void
     */
    public function testGetCodeIgniterInstallPath()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('shama/my_package', '1.0.0', '1.0.0');

        $Package->setType('codeigniter-library');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('libraries/my_package/', $result);
    }

    /**
     * testGetDrupalInstallPath
     *
     * @return void
     */
    public function testGetDrupalInstallPath()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('shama/my_module', '1.0.0', '1.0.0');

        $Package->setType('drupal-module');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('sites/all/modules/my_module/', $result);
    }

    /**
     * testGetFuelPHPInstallPath
     *
     * @return void
     */
    public function testGetFuelPHPInstallPath()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('shama/my_package', '1.0.0', '1.0.0');

        $Package->setType('fuelphp-module');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('modules/my_package/', $result);
    }

    /**
     * testGetJoomlaInstallPath
     *
     * @return void
     */
    public function testGetJoomlaInstallPath()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('shama/my_plugin', '1.0.0', '1.0.0');

        $Package->setType('joomla-plugin');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('plugins/my_plugin/', $result);
    }

    /**
     * testGetLaravelInstallPath
     *
     * @return void
     */
    public function testGetLaravelInstallPath()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('shama/my_package', '1.0.0', '1.0.0');

        $Package->setType('laravel-library');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('libraries/my_package/', $result);
    }

    /**
     * testGetLithiumInstallPath
     *
     * @return void
     */
    public function testGetLithiumInstallPath()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('user/li3_test', '1.0.0', '1.0.0');

        $Package->setType('lithium-library');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('libraries/li3test/', $result);
    }

    /**
     * testGetPhpBBInstallPath
     *
     * @return void
     */
    public function testGetPhpBBInstallPath()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('test/foo', '1.0.0', '1.0.0');

        $Package->setType('phpbb-extension');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('ext/test/foo/', $result);
    }

    /**
     * testGetSymfony1InstallPath
     *
     * @return void
     */
    public function testGetSymfony1InstallPath()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('shama/sfShamaPlugin', '1.0.0', '1.0.0');

        $Package->setType('symfony1-plugin');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('plugins/sfShamaPlugin/', $result);
    }

    /**
     * testGetWordPressInstallPath
     *
     * @return void
     */
    public function testGetWordPressInstallPath()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('shama/my_plugin', '1.0.0', '1.0.0');

        $Package->setType('wordpress-plugin');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('wp-content/plugins/my_plugin/', $result);
    }

    /**
     * testGetZendInstallPath
     *
     * @return void
     */
    public function testGetZendInstallPath()
    {
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        $Package = new MemoryPackage('shama/zend_test', '1.0.0', '1.0.0');

        $Package->setType('zend-extra');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('extras/library/', $result);
    }

}
