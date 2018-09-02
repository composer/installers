<?php
namespace Composer\Installers\Test;

use Composer\Installers\InternaInstaller;
use Composer\Package\Package;
use Composer\Composer;

class InternaInstallerTest extends TestCase
{
    /**
     * @var InternaInstaller
     */
    private $installer;

    public function setUp()
    {
        $this->installer = new InternaInstaller(
            new Package('NyanCat', '4.2', '4.2'),
            new Composer()
        );
    }

    /**
     * @dataProvider packageNameInflectionProvider
     * @param $type
     * @param $vendor
     * @param $name
     * @param $expectedVendor
     * @param $expectedName
     * @param $installPath
     * @param $testName
     */
    public function testInflectPackageVars(
        $type,
        $vendor,
        $name,
        $expectedVendor,
        $expectedName,
        $installPath,
        $testName
    )
    {
        $this->assertEquals(
            $this->installer->inflectPackageVars(array(
                'vendor' => $vendor,
                'name' => $name,
                'type' => $type
            )),
            array('vendor' => $expectedVendor, 'name' => $expectedName, 'type' => $type),
             "Test failed on `$testName`"
        );

        if ($installPath !== null)
        {
            $key = substr($type, strrpos( $type, '-') + 1);
            $isset = isset($this->installer->getLocations()[$key]);
            $this->assertTrue($isset, "Installer type $type is not supported!");

            if ($isset)
            {
                $this->assertEquals($installPath, $this->installer->getLocations()[$key]);
            }
        }
    }

    public function packageNameInflectionProvider()
    {
        return array(
            array(
                'interna-module',                   // Type
                'interna',                          // Vendor
                'core-lib',                         // Name
                'Interna',                          // Expected Vendor
                'CoreLib',                          // Expected Name
                'app/code/{$vendor}/{$name}/',      // Install Path
                'Test Dash in Name',                // Description
            ),
            array(
                'interna-module',                   // Type
                'interna-core',                     // Vendor
                'core',                             // Name
                'InternaCore',                      // Expected Vendor
                'Core',                             // Expected Name
                'app/code/{$vendor}/{$name}/',      // Install Path
                'Test dash in Vendor',              // Description
            ),
            array(
                'interna-module',                   // Type
                'interna',                          // Vendor
                'core',                             // Name
                'Interna',                          // Expected Vendor
                'Core',                             // Expected Name
                'app/code/{$vendor}/{$name}/',      // Install Path
                'Default behavior',             // Description
            ),
            array(
                'interna-extension',                // Type
                'interna',                          // Vendor
                'core',                             // Name
                'interna',                          // Expected Vendor
                'core',                             // Expected Name
                null,                               // Install Path
                'Non Interna Module',               // Description
            ),
            array(
                'interna-module',                   // Type
                '-interna',                         // Vendor
                'core',                             // Name
                'Interna',                          // Expected Vendor
                'Core',                             // Expected Name
                'app/code/{$vendor}/{$name}/',      // Install Path
                'Vendor PreDash',               // Description
            ),
            array(
                'interna-module',                   // Type
                'interna',                          // Vendor
                '-core',                            // Name
                'Interna',                          // Expected Vendor
                'Core',                             // Expected Name
                'app/code/{$vendor}/{$name}/',      // Install Path
                'Name PreDash',             // Description
            ),
        );
    }
}
