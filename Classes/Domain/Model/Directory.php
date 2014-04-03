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
	 * Sort entries by
	 *
	 * @var string
	 */
	protected $sortBy = '';

	/**
	 * Sort direction
	 *
	 * @var string
	 */
	protected $sortDirection = '';

	/**
	 * Allowed sort directions
	 *
	 * @var array
	 */
	protected $allowedSortDirections = array('size', 'name');

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
	 * @param string $sortBy
	 * @param string $sortDirection
	 */
	public function __construct($directory, $sortBy, $sortDirection) {
		$this->setDirectory($this->getValidPath($directory));
		$this->setSortBy($sortBy);
		$this->setSortDirection($sortDirection);
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
	 * setter for directory
	 *
	 * @param string $directory
	 */
	public function setDirectory($directory) {
		$this->directory = new \DirectoryIterator($directory);
	}

	/**
	 * getter for sortBy
	 *
	 * @return string
	 */
	public function getSortBy() {
		return $this->sortBy;
	}

	/**
	 * setter for sortBy
	 *
	 * @param string $sortBy
	 */
	public function setSortBy($sortBy) {
		if (in_array($sortBy, $this->allowedSortDirections)) {
			$this->sortBy = $sortBy;
		} else {
			$this->sortBy = ''; // first folders, then files
		}
	}

	/**
	 * getter for sortDirection
	 *
	 * @return string
	 */
	public function getSortDirection() {
		return $this->sortDirection;
	}

	/**
	 * setter for sortDirection
	 *
	 * @param string $sortDirection
	 */
	public function setSortDirection($sortDirection) {
		$sortDirection = (string)strtoupper($sortDirection);
		if ($sortDirection === 'ASC' || $sortDirection === 'DESC') {
			$this->sortDirection = $sortDirection;
		} else {
			$this->sortDirection = 'ASC';
		}
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
		return $this->fileSystemRepository->getEntriesOfDirectory($this->directory, $this->sortBy, $this->sortDirection);
	}

}