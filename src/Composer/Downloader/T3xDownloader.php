<?php

/*
 * TYPO3 CMS Extension Downloader
 * Extracts the TYPO3 CMS T3X Format
 */

namespace Composer\Downloader;

use Composer\Util\ProcessExecutor;
use Composer\IO\IOInterface;

/**
 * @author Sascha Egerer <sascha.egerer@dkd.de
 */
class T3xDownloader extends ArchiveDownloader
{

	/**
	 * @param $file path to the archive file
	 * @param $path path where the extension should be extracted to
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
				$res = fwrite($fd, $content);
				fclose($fd);
			}
		}
	}
}
