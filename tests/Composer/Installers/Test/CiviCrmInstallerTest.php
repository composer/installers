<?php
namespace Composer\Installers\Test;

use Composer\Installers\CiviCrmInstaller;
use Composer\Package\Package;
use Composer\Composer;
use PHPUnit\Framework\TestCase as BaseTestCase;

class CiviCrmInstallerTest extends BaseTestCase
{
    /**
     * @var CiviCrmInstaller
     */
    private $installer;

    public function setUp()
    {
        $this->installer = new CiviCrmInstaller(
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
            array('name' => $expected, 'type' => $type),
            $this->installer->inflectPackageVars(array('name' => $name, 'type' => $type))
        );
    }

    public function packageNameInflectionProvider()
    {
        return array(
            array(
                'civicrm-ext',
                'org.civicrm.shoreditch',
                'org.civicrm.shoreditch'
            ),
            array(
                'civicrm-ext',
                'org.civicrm.flexmailer',
                'org.civicrm.flexmailer'
            ),
            array(
                'civicrm-ext',
                'uk.co.vedaconsulting.mosaico',
                'uk.co.vedaconsulting.mosaico'
            )
        );
    }
}
