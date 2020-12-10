<?php

namespace Composer\Installers\Test;

use Composer\Composer;
use Composer\Installers\IgniterInstaller;
use Composer\Package\Package;
use PHPUnit\Framework\TestCase as BaseTestCase;

class IgniterInstallerTest extends BaseTestCase
{
    /**
     * @var IgniterInstaller
     */
    private $installer;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $this->installer = new IgniterInstaller(
            new Package('NyanCat', '4.2', '4.2'),
            new Composer()
        );
    }

    /**
     * @dataProvider packageNameInflectionProvider
     * 
     * @return void
     */
    public function testInflectPackageVars($type, $vendor, $name, $expectedVendor, $expectedName)
    {
        $this->assertEquals(
            $this->installer->inflectPackageVars(array(
                'vendor' => $vendor,
                'name' => $name,
                'type' => $type,
            )),
            array('vendor' => $expectedVendor, 'name' => $expectedName, 'type' => $type)
        );
    }

    public function packageNameInflectionProvider(): array
    {
        return array(
            array(
                'igniter-extension',
                'acme',
                'pages',
                'acme',
                'pages',
            ),
            array(
                'igniter-extension',
                'acme',
                'pages-extension',
                'acme',
                'pages',
            ),
            // tests vendor name containing a hyphen
            array(
                'igniter-extension',
                'foo-bar-co',
                'blog',
                'foobarco',
                'blog',
            ),
            // tests that exactly one '-theme' is cut off
            array(
                'igniter-theme',
                'acme',
                'my-theme-theme',
                'acme',
                'my-theme',
            ),
            // tests that names without '-theme' suffix stay valid
            array(
                'igniter-theme',
                'acme',
                'someothertheme',
                'acme',
                'someothertheme',
            ),
        );
    }
}
