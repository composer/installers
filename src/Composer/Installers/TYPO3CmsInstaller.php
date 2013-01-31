<?php
namespace Composer\Installers;

/**
 * Extension installer for TYPO3 CMS
 *
 * @author Sascha Egerer <sascha.egerer@dkd.de>
 */
class TYPO3CmsInstaller extends BaseInstaller {

	protected $locations = array(
		'extension'   => 'typo3conf/ext/{$name}/'
	);

	/**
	 * Initializes base installer.
	 *
	 * @param \Composer\Package\PackageInterface $package
	 * @param \Composer\Composer         $composer
	 */
	public function __construct(\Composer\Package\PackageInterface $package, \Composer\Composer $composer) {
		parent::__construct($package, $composer);

		$composer->getDownloadManager()->setDownloader('t3x', new \Composer\Downloader\T3xDownloader(new \Composer\IO\NullIO(),$composer->getConfig()));
	}

	/**
	 * {@inheritDoc}
	 */
	public function supports($packageType) {
		return 'extension' === $packageType;
	}

}
?>