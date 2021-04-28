<?php
namespace Composer\Installers\Test;

use Composer\Installers\MauticInstaller;
use Composer\Package\Package;
use Composer\Composer;

class MauticInstallerTest extends TestCase
{
    /**
     * @var MauticInstaller
     */
    private $installer;

    /**
     * @var \Composer\Composer
     */
    protected $composer;

    public function setUp()
    {
        $this->composer = new Composer();
    }

    /**
     * @param string[] $vars
     * @param string[] $expectedVars
     *
     * @covers ::inflectPackageVars
     *
     * @dataProvider provideExpectedInflectionResults
     */
    final public function testInflectPackageVars($vars, $expectedVars)
    {
        $package = new Package($vars['name'], '1.0.0', '1.0.0');
        $package->setType($vars['type']);
        if (isset($vars['extra'])) {
            $package->setExtra((array) $vars['extra']);
        }

        $installer = new MauticInstaller(
            $package,
            $this->composer
        );

        $actual = $installer->inflectPackageVars($vars);
        $this->assertEquals($actual, $expectedVars);
    }

    /**
     * Provides various parameters for packages and the expected result after
     * inflection
     *
     * @return array
     */
    final public function provideExpectedInflectionResults()
    {
        return array(
            //check bitrix-dir is correct
            array(
                array(
                    'name' => 'mautic/grapes-js-builder-bundle', 
                    'type' => 'mautic-plugin'
                ),
                array(
                    'name' => 'GrapesJsBuilderBundle',
                    'type' => 'mautic-plugin'
                )
            ),
            // Check if composer renames the name based on the given
            // installation directory
            array(
                array(
                    'name' => 'mautic/grapes-js-builder-bundle', 
                    'type' => 'mautic-plugin', 
                    'extra' => array(
                        'install-directory-name' => 'GrapesJsBuilderPlugin'
                    )
                ),
                array(
                    'name' => 'GrapesJsBuilderPlugin', 
                    'type' => 'mautic-plugin', 
                    'extra' => array(
                        'install-directory-name' => 'GrapesJsBuilderPlugin'
                    )
                )                
            ),
            array(
                array(
                    'name' => 'mautic/theme-blank-grapejs', 
                    'type' => 'mautic-theme'
                ),
                array(
                    'name' => 'ThemeBlankGrapejs', 
                    'type' => 'mautic-theme'
                )
            ),
            array(
                array(
                    'name' => 'mautic/theme-blank-grapejs', 
                    'type' => 'mautic-theme', 
                    'extra' => array(
                        'install-directory-name' => 'blank-grapejs'
                    )
                ),
                array(
                    'name' => 'blank-grapejs', 
                    'type' => 'mautic-theme', 
                    'extra' => array(
                        'install-directory-name' => 'blank-grapejs'
                    )
                )                
            )
        );
    }
}
