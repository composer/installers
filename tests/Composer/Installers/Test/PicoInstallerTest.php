<?php
namespace Composer\Installers\Test;

use Composer\Installers\PicoInstaller;
use Composer\Package\Package;
use Composer\Composer;

class PicoInstallerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PicoInstaller
     */
    private $installer;

    public function setUp()
    {
        $this->installer = new PicoInstaller(
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
                'pico-plugin',
                'nyancat',
                'Nyancat',
            ),
            array(
                'pico-plugin',
                'nyan-cat',
                'NyanCat',
            ),
            array(
                'pico-plugin',
                'NyanCat',
                'NyanCat',
            ),
            // tests that '-plugin' and '-theme' suffixes are cut off
            array(
                'pico-theme',
                'nyan-cat-theme',
                'NyanCat',
            ),
            // tests that 'plugin' and 'theme' suffixes without separator stay valid
            array(
                'pico-theme',
                'NyanCatTheme',
                'NyanCatTheme',
            ),
            // tests that multiple separators are treated as a single separator
            array(
                'pico-theme',
                'nyan---cat',
                'NyanCat',
            ),
            // tests mixed separator characters
            array(
                'pico-plugin',
                'awesome-nyan.cat_plugin',
                'AwesomeNyanCat',
            ),
            // tests that 'pico-' prefixes aren't treated specially
            array(
                'pico-plugin',
                'pico-nyan-cat',
                'PicoNyanCat'
            ),
        );
    }
}
