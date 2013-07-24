<?php

/*
 * TYPO3 CMS Extension Downloader
 * Extracts the TYPO3 CMS T3X Format
 */

namespace Composer\Downloader;

/**
 * @author Sascha Egerer <sascha.egerer@dkd.de
 */
class T3xDownloader extends ArchiveDownloader
{

	/**
	 * @param string $file path to the archive file
	 * @param string $path path where the extension should be extracted to
	 */
	protected function extract($file, $path)
	{
		// get file contents
		$fileContentStream = file_get_contents($file);
		$extensionData = $this->decodeTerExchangeData($fileContentStream);
		if (substr($path, -1) !== DIRECTORY_SEPARATOR) {
			$path .= DIRECTORY_SEPARATOR;
		}

		$files = $this->extractFilesArrayFromExtensionData($extensionData);
		$directories = $this->extractDirectoriesFromExtensionData($files);
		$this->createDirectoriesForExtensionFiles($directories, $path);
		$this->writeExtensionFiles($files, $path);
		$this->writeEmConf($extensionData, $path);
	}

	/**
	 * @param $stream
	 * @return array
	 * @throws \RuntimeException
	 */
	public function decodeTerExchangeData($stream) {
		$parts = explode(':', $stream, 3);
		if ($parts[1] == 'gzcompress') {
			if (function_exists('gzuncompress')) {
				$parts[2] = gzuncompress($parts[2]);
			} else {
				throw new \RuntimeException('Decoding Error: No decompressor available for compressed content. gzcompress()/gzuncompress() functions are not available!', 1359124403);
			}
		}
		if (md5($parts[2]) == $parts[0]) {
			$output = unserialize($parts[2]);
			if (!is_array($output)) {
				throw new \RuntimeException('Error: Content could not be unserialized to an array. Strange (since MD5 hashes match!)', 1359124554);
			}
		} else {
			throw new \RuntimeException('Error: MD5 mismatch. Maybe the extension file was downloaded and saved as a text file and thereby corrupted!?', 1359124556);
		}
		return $output;
	}


	/**
	 * Returns the "FILES" part from the data array
	 *
	 * @param array $extensionData
	 * @return mixed
	 */
	protected function extractFilesArrayFromExtensionData(array $extensionData) {
		return $extensionData['FILES'];
	}

	/**
	 * Extract needed directories from given extensionDataFilesArray
	 *
	 * @param array $files
	 * @return array
	 */
	protected function extractDirectoriesFromExtensionData(array $files) {
		$directories = array();
		foreach ($files as $filePath => $file) {
			preg_match('/(.*)\\//', $filePath, $matches);
			if(count($matches) > 0) {
				$directories[] = $matches[0];
			}
		}
		return $directories;
	}

	/**
	 * Loops over an array of directories and creates them in the given root path
	 * It also creates nested directory structures
	 *
	 * @param array $directories
	 * @param string $rootPath
	 * @return void
	 */
	protected function createDirectoriesForExtensionFiles(array $directories, $rootPath) {
		foreach ($directories as $directory) {
			$this->createNestedDirectory($rootPath . $directory);
		}
	}

	/**
	 * Wrapper for utility method to create directory recusively
	 *
	 * @throws \RuntimeException
	 * @param string $directory Absolute path
	 */
	protected function createNestedDirectory($directory) {
		$currentPath = $directory;
		if (!@is_dir($currentPath)) {
			do {
				$separatorPosition = strrpos($currentPath, DIRECTORY_SEPARATOR);
				$currentPath = substr($currentPath, 0, $separatorPosition);
			} while (!is_dir($currentPath) && $separatorPosition !== FALSE);

			$result = @mkdir($directory,  0777, TRUE);
			if (!$result) {
				throw new \RuntimeException('Could not create directory "' . $directory . '"!', 1170251400);
			}
		}
	}

	/**
	 * Loops over an array of files and writes them to the given rootPath
	 *
	 * @param array $files
	 * @param string $rootPath
	 * @return void
	 */
	protected function writeExtensionFiles(array $files, $rootPath) {
		foreach ($files as $file) {
			$filename = $rootPath . $file['name'];
			$content = $file['content'];

			if ($fd = fopen($filename, 'wb')) {
				fwrite($fd, $content);
				fclose($fd);
			}
		}
	}

	/**
	 * @param array $extensionData
	 * @param string $path path of the extension folder
	 */
	protected function writeEmConf(array $extensionData, $path) {
		$emConfContent = $this->constructEmConf($extensionData);
		if ($fd = fopen($path . 'em_conf.php', 'wb')) {
			fwrite($fd, $emConfContent);
			fclose($fd);
		}
	}

	/**
	 * Generates the content for the ext_emconf.php file
	 *
	 * @internal
	 * @param array $extensionData
	 * @return string
	 */
	public function constructEmConf(array $extensionData) {
		$emConf = $this->fixEmConf($extensionData['EM_CONF']);
		$emConf = var_export($emConf, TRUE);
		$code = '<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "' . $extensionData['extKey'] . '".
 *
 * Auto generated ' . date('d-m-Y H:i') . '
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = ' . $emConf . ';

?>';
		return str_replace('  ', chr(9), $code);
	}

	/**
	 * Fix the em conf - Converts old / ter em_conf format to new format
	 *
	 * @param array $emConf
	 * @return array
	 */
	public function fixEmConf(array $emConf) {
		if (!isset($emConf['constraints']) || !isset($emConf['constraints']['depends']) || !isset($emConf['constraints']['conflicts']) || !isset($emConf['constraints']['suggests'])) {
			if (!isset($emConf['constraints']) || !isset($emConf['constraints']['depends'])) {
				$emConf['constraints']['depends'] = $this->stringToDependency($emConf['dependencies']);
				if (strlen($emConf['PHP_version'])) {
					$emConf['constraints']['depends']['php'] = $emConf['PHP_version'];
				}
				if (strlen($emConf['TYPO3_version'])) {
					$emConf['constraints']['depends']['typo3'] = $emConf['TYPO3_version'];
				}
			}
			if (!isset($emConf['constraints']) || !isset($emConf['constraints']['conflicts'])) {
				$emConf['constraints']['conflicts'] = $this->dependencyToString($emConf['conflicts']);
			}
			if (!isset($emConf['constraints']) || !isset($emConf['constraints']['suggests'])) {
				$emConf['constraints']['suggests'] = array();
			}
		} elseif (isset($emConf['constraints']) && isset($emConf['dependencies'])) {
			$emConf['suggests'] = isset($emConf['suggests']) ? $emConf['suggests'] : array();
			$emConf['dependencies'] = $this->dependencyToString($emConf['constraints']);
			$emConf['conflicts'] = $this->dependencyToString($emConf['constraints'], 'conflicts');
		}
		unset($emConf['private']);
		unset($emConf['download_password']);
		unset($emConf['TYPO3_version']);
		unset($emConf['PHP_version']);
		return $emConf;
	}

	/**
	 * Checks whether the passed dependency is TER2-style (array) and returns a
	 * single string for displaying the dependencies.
	 *
	 * It leaves out all version numbers and the "php" and "typo3" dependencies,
	 * as they are implicit and of no interest without the version number.
	 *
	 * @param mixed $dependency Either a string or an array listing dependencies.
	 * @param string $type The dependency type to list if $dep is an array
	 * @return string A simple dependency list for display
	 */
	static public function dependencyToString($dependency, $type = 'depends') {
		if (is_array($dependency)) {
			if (isset($dependency[$type]['php'])) {
				unset($dependency[$type]['php']);
			}
			if (isset($dependency[$type]['typo3'])) {
				unset($dependency[$type]['typo3']);
			}
			$dependencyString = count($dependency[$type]) ? implode(',', array_keys($dependency[$type])) : '';
			return $dependencyString;
		}
		return '';
	}

	/**
	 * Checks whether the passed dependency is TER-style (string) or
	 * TER2-style (array) and returns a single string for displaying the
	 * dependencies.
	 *
	 * It leaves out all version numbers and the "php" and "typo3" dependencies,
	 * as they are implicit and of no interest without the version number.
	 *
	 * @param mixed $dependency Either a string or an array listing dependencies.
	 * @return string A simple dependency list for display
	 */
	public function stringToDependency($dependency) {
		$constraint = array();
		if (is_string($dependency) && strlen($dependency)) {
			$dependency = explode(',', $dependency);
			foreach ($dependency as $v) {
				$constraint[$v] = '';
			}
		}
		return $constraint;
	}

}
