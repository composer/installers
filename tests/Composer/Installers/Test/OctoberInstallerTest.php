<?php
namespace Composer\Installers\Test;

use Composer\Installers\OctoberInstaller;
use Composer\Package\Package;
use Composer\Composer;
use PHPUnit\Framework\TestCase as BaseTestCase;

class OctoberInstallerTest extends BaseTestCase
{
    /**
     * @var OctoberInstaller
     */
    private $installer;

    public function setUp()
    {
        $this->installer = new OctoberInstaller(
            new Package('NyanCat', '4.2', '4.2'),
            new Composer()
        );
    }

    /**
     * @dataProvider packageNameInflectionProvider
     */
    public function testInflectPackageVars($type, $vendor, $name, $expectedVendor, $expectedName)
    {
        $this->assertEquals(
            $this->installer->inflectPackageVars(array(
                'vendor' => $vendor,
                'name' => $name,
                'type' => $type
            )),
            array('vendor' => $expectedVendor, 'name' => $expectedName, 'type' => $type)
        );
    }

    public function packageNameInflectionProvider()
    {
        return array(
            array(
                'october-plugin',
                'acme',
                'subpagelist',
                'acme',
                'subpagelist',
            ),
            array(
                'october-plugin',
                'acme',
                'subpagelist-plugin',
                'acme',
                'subpagelist',
            ),
            array(
                'october-plugin',
                'acme',
                'semanticoctober',
                'acme',
                'semanticoctober',
            ),
            // tests vendor name containing a hyphen
            array(
                'october-plugin',
                'foo-bar-co',
                'blog',
                'foobarco',
                'blog'
            ),
            // tests that exactly one '-theme' is cut off
            array(
                'october-theme',
                'acme',
                'some-theme-theme',
                'acme',
                'some-theme',
            ),
            // tests that names without '-theme' suffix stay valid
            array(
                'october-theme',
                'acme',
                'someothertheme',
                'acme',
                'someothertheme',
            ),
        );
    }
}
