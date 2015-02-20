<?php
namespace Composer\Installers\Test;

use Composer\Installers\SixAdminInstaller;
use Composer\Package\Package;
use Composer\Composer;

class SixAdminInstallerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    private $installer;

    public function setUp()
    {
        $this->installer = new SixAdminInstaller(
            new Package('NyanCat', '4.2', '4.2'),
            new Composer()
        );
    }

    /**
     * @dataProvider packageNameInflectionProvider
     */
    public function testInflectPackageVars($type, $name, $expected)
    {
        $this->assertEquals(
            $this->installer->inflectPackageVars(['name' => $name, 'type' => $type]),
            ['name' => $expected, 'type' => $type]
        );
    }

    public function packageNameInflectionProvider()
    {
        return [
            [
                '6admin-module',
                'core-module',
                'core'
            ],
            [
                '6admin-module',
                'Media-module',
                'media'
            ]
        ];
    }
}
