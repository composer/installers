<?php

namespace Composer\Installers\Test;

use Composer\Installers\PrestashopInstaller;
use Composer\Composer;

class PrestashopInstallerTest extends TestCase {

	/**
	 * @var Composer
	 */
	private $composer;

	public function setUp() {
		$this->composer = new Composer();
	}

	/**
	 * @dataProvider packageProvider
	 */
	public function testGetInstallPath($type, $name, $version, $expected) {
		$package = $this->getPackage($name, $version);
		$package->setType($type);

		$installer = new PrestashopInstaller($package, $this->composer);

		$path = $installer->getInstallPath($package, 'prestashop');
		$this->assertEquals($expected, $path);
	}

	public function packageProvider() {
		return array(
		    array(
			'prestashop-theme',
			'responsive',
			'1.0.0',
			'themes/responsive/',
		    ),
		    array(
			'prestashop-module',
			'price-module',
			'2.0.5',
			'modules/price-module/',
		    ),
		);
	}

}
