<?php
namespace Composer\Installers\Test;

use Composer\Composer;
use Composer\Installers\GravInstaller;

class GravInstallerTest extends TestCase
{
    /* @var \Composer\Composer */
    protected $composer;

    public function setUp()
    {
        $this->composer = new Composer();
    }

    public function testInflectPackageVars()
    {
        $package     = $this->getPackage('vendor/name', '0.0.0');
        $installer   = new GravInstaller($package, $this->composer);
        $packageVars = $this->getPackageVars($package);

        $this->assertEquals('test',
            $installer->inflectPackageVars(array_merge($packageVars, array('name' => 'test')))['name']);

        foreach ($installer->getLocations() as $name => $location) {
            $this->assertEquals('test',
                $installer->inflectPackageVars(array_merge($packageVars, array('name' => "$name-test")))['name']);
            $this->assertEquals('test',
                $installer->inflectPackageVars(array_merge($packageVars, array('name' => "test-$name")))['name']);
            $this->assertEquals('test-test',
                $installer->inflectPackageVars(array_merge($packageVars, array('name' => "$name-test-test")))['name']);
            $this->assertEquals('test-test',
                $installer->inflectPackageVars(array_merge($packageVars, array('name' => "test-test-$name")))['name']);
            $this->assertEquals('test',
                $installer->inflectPackageVars(array_merge($packageVars, array('name' => "grav-$name-test")))['name']);
            $this->assertEquals('test',
                $installer->inflectPackageVars(array_merge($packageVars, array('name' => "grav-test-$name")))['name']);
            $this->assertEquals('test-test',
                $installer->inflectPackageVars(
                    array_merge($packageVars, array('name' => "grav-$name-test-test")))['name']);
            $this->assertEquals('test-test',
                $installer->inflectPackageVars(
                    array_merge($packageVars, array('name' => "grav-test-test-$name")))['name']);
        }
    }

    /**
     * @param $package  \Composer\Package\PackageInterface
     */
    public function getPackageVars($package)
    {
        $type = $package->getType();

        $prettyName = $package->getPrettyName();
        if (strpos($prettyName, '/') !== false) {
            list($vendor, $name) = explode('/', $prettyName);
        } else {
            $vendor = '';
            $name   = $prettyName;
        }

        return compact('name', 'vendor', 'type');
    }
}
