<?php
namespace Composer\Installers\Test;

use Composer\Installers\Installer;
use Composer\Util\Filesystem;
use Composer\Package\Package;
use Composer\Package\RootPackage;
use Composer\Composer;
use Composer\Config;

class InstallerTest extends TestCase
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
        $this->fs = new Filesystem;

        $this->composer = new Composer();
        $this->config = new Config();
        $this->composer->setConfig($this->config);

        $this->vendorDir = realpath(sys_get_temp_dir()) . DIRECTORY_SEPARATOR . 'baton-test-vendor';
        $this->ensureDirectoryExistsAndClear($this->vendorDir);

        $this->binDir = realpath(sys_get_temp_dir()) . DIRECTORY_SEPARATOR . 'baton-test-bin';
        $this->ensureDirectoryExistsAndClear($this->binDir);

        $this->config->merge(array(
            'config' => array(
                'vendor-dir' => $this->vendorDir,
                'bin-dir' => $this->binDir,
            ),
        ));

        $this->dm = $this->getMockBuilder('Composer\Downloader\DownloadManager')
            ->disableOriginalConstructor()
            ->getMock();
        $this->composer->setDownloadManager($this->dm);

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
    public function testSupports($type, $expected)
    {
        $installer = new Installer($this->io, $this->composer);
        $this->assertSame($expected, $installer->supports($type), sprintf('Failed to show support for %s', $type));
    }

    /**
     * dataForTestSupport
     */
    public function dataForTestSupport()
    {
        return array(
            array('agl-module', true),
            array('cakephp', false),
            array('cakephp-', false),
            array('cakephp-app', true),
            array('codeigniter-app', true),
            array('drupal-module', true),
            array('fuelphp-module', true),
            array('joomla-library', true),
            array('kohana-module', true),
            array('laravel-library', true),
            array('lithium-library', true),
            array('magento-library', true),
            array('mako-package', true),
            array('mediawiki-extension', true),
            array('phpbb-extension', true),
            array('ppi-module', true),
            array('silverstripe-module', true),
            array('silverstripe-theme', true),
            array('symfony1-plugin', true),
            array('typo3-flow-plugin', true),
            array('wordpress-plugin', true),
            array('zend-library', true),
        );
    }

    /**
     * testInstallPath
     *
     * @dataProvider dataForTestInstallPath
     */
    public function testInstallPath($type, $path, $name)
    {
        $installer = new Installer($this->io, $this->composer);
        $package = new Package($name, '1.0.0', '1.0.0');

        $package->setType($type);
        $result = $installer->getInstallPath($package);
        $this->assertEquals($path, $result);
    }

    /**
     * dataFormTestInstallPath
     */
    public function dataForTestInstallPath()
    {
        return array(
            array('agl-module', 'More/MyTestPackage/', 'agl/my_test-package'),
            array('cakephp-plugin', 'Plugin/Ftp/', 'shama/ftp'),
            array('codeigniter-library', 'libraries/my_package/', 'shama/my_package'),
            array('codeigniter-module', 'modules/my_package/', 'shama/my_package'),
            array('drupal-module', 'modules/my_module/', 'shama/my_module'),
            array('drupal-theme', 'themes/my_module/', 'shama/my_module'),
            array('drupal-profile', 'profiles/my_module/', 'shama/my_module'),
            array('drupal-drush', 'drush/my_module/', 'shama/my_module'),
            array('fuelphp-module', 'modules/my_package/', 'shama/my_package'),
            array('joomla-plugin', 'plugins/my_plugin/', 'shama/my_plugin'),
            array('kohana-module', 'modules/my_package/', 'shama/my_package'),
            array('laravel-library', 'libraries/my_package/', 'shama/my_package'),
            array('lithium-library', 'libraries/li3_test/', 'user/li3_test'),
            array('magento-library', 'lib/foo/', 'test/foo'),
            array('mako-package', 'app/packages/my_package/', 'shama/my_package'),
            array('mediawiki-extension', 'extensions/APC/', 'author/APC' ),
            array('mediawiki-extension', 'extensions/UploadWizard/', 'author/upload-wizard' ),
            array('mediawiki-extension', 'extensions/SyntaxHighlight_GeSHi/', 'author/syntax-highlight_GeSHi' ),
            array('phpbb-extension', 'ext/test/foo/', 'test/foo'),
            array('phpbb-style', 'styles/foo/', 'test/foo'),
            array('phpbb-language', 'language/foo/', 'test/foo'),
            array('ppi-module', 'modules/foo/', 'test/foo'),
            array('silverstripe-module', 'my_module/', 'shama/my_module'),
            array('silverstripe-theme', 'themes/my_theme/', 'shama/my_theme'),
            array('symfony1-plugin', 'plugins/sfShamaPlugin/', 'shama/sfShamaPlugin'),
            array('symfony1-plugin', 'plugins/sfShamaPlugin/', 'shama/sf-shama-plugin'),
            array('typo3-flow-package', 'Packages/Application/my_package/', 'shama/my_package'),
            array('typo3-flow-build', 'Build/my_package/', 'shama/my_package'),
            array('wordpress-plugin', 'wp-content/plugins/my_plugin/', 'shama/my_plugin'),
            array('zend-extra', 'extras/library/', 'shama/zend_test'),
        );
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
        $installer = new Installer($this->io, $this->composer);
        $package = new Package('shama/ftp', '1.0.0', '1.0.0');

        $package->setType('cakephp-whoops');
        $result = $installer->getInstallPath($package);
    }

    /**
     * testCustomInstallPath
     */
    public function testCustomInstallPath()
    {
        $installer = new Installer($this->io, $this->composer);
        $package = new Package('shama/ftp', '1.0.0', '1.0.0');
        $package->setType('cakephp-plugin');
        $consumerPackage = new RootPackage('foo/bar', '1.0.0', '1.0.0');
        $this->composer->setPackage($consumerPackage);
        $consumerPackage->setExtra(array(
            'installer-paths' => array(
                'my/custom/path/{$name}/' => array(
                    'shama/ftp',
                    'foo/bar',
                ),
            ),
        ));
        $result = $installer->getInstallPath($package);
        $this->assertEquals('my/custom/path/Ftp/', $result);
    }

    /**
     * testCustomInstallerName
     */
    public function testCustomInstallerName() {
        $installer = new Installer($this->io, $this->composer);
        $package = new Package('shama/cakephp-ftp-plugin', '1.0.0', '1.0.0');
        $package->setType('cakephp-plugin');
        $package->setExtra(array(
            'installer-name' => 'FTP',
        ));
        $result = $installer->getInstallPath($package);
        $this->assertEquals('Plugin/FTP/', $result);
    }

    /**
     * testNoVendorName
     */
    public function testNoVendorName()
    {
        $installer = new Installer($this->io, $this->composer);
        $package = new Package('sfPhpunitPlugin', '1.0.0', '1.0.0');

        $package->setType('symfony1-plugin');
        $result = $installer->getInstallPath($package);
        $this->assertEquals('plugins/sfPhpunitPlugin/', $result);
    }

}
