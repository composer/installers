<?php
namespace Composer\Installers;

use Composer\Package\PackageInterface;
class OxidInstaller extends BaseInstaller
{
	const VENDOR_PATTERN = '/^modules\/[vendor=(.+)]\/.+/';

    protected $locations = array(
        'module'    => 'modules/{$name}/',
        'theme'  => 'application/views/{$name}/',
        'out'    => 'out/{$name}/',
    );

	/**
	 * getInstallPath
	 *
	 * @param PackageInterface $package
	 * @param string $frameworkType
	 * @return void
	 */
	public function getInstallPath(PackageInterface $package, $frameworkType = '')
	{
		$installPath = parent::getInstallPath($package, $frameworkType);
		$this->prepareVendorDirectory($installPath);
		return $installPath;
	}

	/**
	 * prepareVendorDirectory
	 *
	 * Makes sure there is a vendormetadata.php file inside
	 * the vendor folder if there is a vendor folder.
	 *
	 * @param string $installPath
	 * @return void
	 */
	protected function prepareVendorDirectory($installPath)
	{
		var_dump('installPath');
		var_dump($installPath);
		$matches = '';
		$hasVendorDirectory = preg_match(self::VENDOR_PATTERN, $installPath, $matches);
		var_dump('hasVendorDirectory');
		var_dump($hasVendorDirectory);
		if (!$hasVendorDirectory) {
			return;
		}

		$vendorDirectory = $matches['vendor'];
		var_dump('vendorDirectory');
		var_dump($vendorDirectory);
	}
}