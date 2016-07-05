<?php
namespace Composer\Installers\Test;

use Composer\Installers\AlfredInstaller;
use Composer\Package\Package;
use Composer\Composer;

class AlfredInstallerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AlfredInstaller
     */
    private $installer;

    public function setUp()
    {
        $this->installer = new AlfredInstaller(
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
            $this->installer->inflectPackageVars(array('name' => $name, 'type' => $type)),
            array('name' => $expected, 'type' => $type)
        );
    }

    public function packageNameInflectionProvider()
    {
        return array(
            array(
                'alfred-module',
                'alfred-module',
                'Alfred'
            ),
            array(
                'alfred-module',
                'blog',
                'Blog'
            )
        );
    }
}
