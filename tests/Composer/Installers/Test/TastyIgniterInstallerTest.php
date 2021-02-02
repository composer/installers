<?php

namespace Composer\Installers\Test;

use Composer\Composer;
use Composer\Installers\TastyIgniterInstaller;
use Composer\Package\Package;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TastyIgniterInstallerTest extends BaseTestCase
{
    /**
     * @var TastyIgniterInstaller
     */
    private $installer;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $this->installer = new TastyIgniterInstaller(
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
            array(
                'vendor' => $expectedVendor,
                'name' => $expectedName,
                'type' => $type
            )
        );
    }

    public function packageNameInflectionProvider()
    {
        return array(
            array(
                'tastyigniter-extension',
                'acme',
                'pages',
                'acme',
                'pages',
            ),
            array(
                'tastyigniter-extension',
                'acme',
                'ti-ext-pages',
                'acme',
                'pages',
            ),
            // tests vendor name containing a hyphen
            array(
                'tastyigniter-extension',
                'foo-bar-co',
                'blog',
                'foobarco',
                'blog',
            ),
            // tests that exactly one '-theme' is cut off
            array(
                'tastyigniter-theme',
                'acme',
                'ti-theme-theme',
                'acme',
                'theme',
            ),
            // tests that names without '-theme' suffix stay valid
            array(
                'tastyigniter-theme',
                'acme',
                'someothertheme',
                'acme',
                'someothertheme',
            ),
        );
    }
}
