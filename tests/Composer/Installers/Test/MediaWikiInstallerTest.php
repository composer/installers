<?php
namespace Composer\Installers\Test;

use Composer\Installers\MediaWikiInstaller;
use Composer\Package\Package;
use Composer\Composer;
use Composer\Config;

class MediaWikiInstallerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var MediaWikiInstaller
	 */
	private $installer;

	public function setUp()
	{
		$this->installer = new MediaWikiInstaller(
			new Package('NyanCat', '4.2', '4.2'),
			new Composer()
		);
	}

	/**
	 * @dataProvider packageNameInflectionProvider
	 */
	public function testInflectPackageVars($input, $expected)
	{
		$this->assertEquals(
			$this->installer->inflectPackageVars(array('name' => $input)),
			array('name' => $expected)
		);
	}

	public function packageNameInflectionProvider()
	{
		return array(
			array(
				'sub-page-list',
				'SubPageList',
			),
			array(
				'semantic-mediawiki',
				'SemanticMediawiki',
			)
		);
	}
}