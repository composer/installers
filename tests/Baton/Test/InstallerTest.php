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
     */
    public function testSupports()
    {
        $types = array(
            'cakephp', 'codeigniter', 'drupal', 'fuelphp',
            'joomla', 'laravel', 'lithium', 'wordpress',
        );
        $Installer = new Installer($this->vendorDir, $this->binDir, $this->dm, $this->io);
        foreach ($types as $type) {
            $this->assertTrue($Installer->supports($type), sprintf('Failed to show support for %s', $type));
        }
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

        $Package->setType('cakephp-whoops');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('Vendor/Ftp/', $result);
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
        $this->assertEquals('modules/my_module/', $result);
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

        $Package->setType('lithium-libraries');
        $result = $Installer->getInstallPath($Package);
        $this->assertEquals('libraries/li3test/', $result);
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

}