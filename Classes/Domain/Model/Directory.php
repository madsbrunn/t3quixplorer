<?php
namespace MadsBrunn\T3quixplorer\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Stefan Froemken <froemken@gmail.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @package t3quixplorer
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Directory {

	/**
	 * @var \MadsBrunn\T3quixplorer\Domain\Repository\FileSystemRepository
	 */
	protected $fileSystemRepository;

	/**
	 * The initial directory
	 *
	 * @var \DirectoryIterator
	 */
	protected $directory = '';

	/**
	 * subdirectory
	 *
	 * @var \DirectoryIterator
	 */
	protected $subDirectory = '';





	/**
	 * inject FileSystemRepository
	 *
	 * @param \MadsBrunn\T3quixplorer\Domain\Repository\FileSystemRepository $fileSystemRepository
	 */
	public function injectFileSystemRepository(\MadsBrunn\T3quixplorer\Domain\Repository\FileSystemRepository $fileSystemRepository) {
		$this->fileSystemRepository = $fileSystemRepository;
	}





	/**
	 * Constructor of this class
	 *
	 * @param string $directory
	 */
	public function __construct($directory) {
		$this->setDirectory($this->getValidPath($directory));
	}

	/**
	 * convert directory into valid path
	 *
	 * @param $directory
	 * @return string
	 */
	protected function getValidPath($directory) {
		if (empty($directory)) {
			$path = PATH_site;
		} else {
			$path = GeneralUtility::resolveBackPath(PATH_site . $directory);
			if (!GeneralUtility::isFirstPartOfStr($path, PATH_site)) {
				$path = PATH_site;
			}

			// check if directory exists
			if (!is_dir($path)) {
				$path = PATH_site;
			}
		}
		return $path;
	}

	/**
	 * getter for directory
	 *
	 * @return \DirectoryIterator
	 */
	public function getDirectory() {
		return $this->directory;
	}

	/**
	 * getter for directory name
	 *
	 * @TODO: Seems to be not working
	 * @return string
	 */
	public function getName() {
		$path = $this->directory->getPathname();
		return $path;
	}

	/**
	 * getter for relative path
	 *
	 * @return string
	 */
	public function getRelativePath() {
		$fullPath = $this->directory->getPath();
		if (!GeneralUtility::isFirstPartOfStr($fullPath, PATH_site)) {
			$relativePath = '';
		} else {
			$relativePath = str_replace(PATH_site, '', $fullPath);
		}
		return $relativePath;
	}

	/**
	 * setter for directory
	 *
	 * @param string $directory
	 */
	public function setDirectory($directory) {
		$this->directory = new \DirectoryIterator($directory);
	}

	/**
	 * get subdirectory
	 *
	 * @return string
	 */
	public function getSubdirectory() {
		$subDirectory = dirname($this->directory->getPath());
		// you should never have the possibility to access directories outside of current project
		if (!GeneralUtility::isFirstPartOfStr($subDirectory, PATH_site)) {
			$subDirectory = PATH_site;
		}
		// remove first part of directory
		$subDirectory = str_replace(PATH_site, '', $subDirectory);
		return $subDirectory;
	}

	/**
	 * get entries of current directory
	 *
	 * @return array
	 */
	public function getEntries() {
		return $this->fileSystemRepository->getEntriesOfDirectory($this->directory);
	}

}