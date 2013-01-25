<?php
namespace Composer\Installers;

use Composer\IO\ConsoleIO;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\ArgvInput;

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

		$io = $this->createIOObject();

		$composer->getDownloadManager()->setDownloader('t3x', new \Composer\Downloader\T3xDownloader($io,$composer->getConfig()));
	}

	/**
	 * Currently it is not possible to get the "IO" Object at this point
	 * so we create our own IO object because the downloader needs it
	 * to log stuff to the console.
	 *
	 * @return ConsoleIO
	 */
	private function createIOObject() {
		$input = new ArgvInput();
		$output = new ConsoleOutput();

		$helperSet = new HelperSet(array(
			new FormatterHelper(),
			new DialogHelper(),
		));

		return new ConsoleIO($input, $output, $helperSet);
	}

	/**
	 * {@inheritDoc}
	 */
	public function supports($packageType) {
		return 'extension' === $packageType;
	}

}
?>