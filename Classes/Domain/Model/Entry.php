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
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * @package t3quixplorer
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Entry {

	public $name;
	public $path;
	public $fullPath;
	public $isDir;
	public $size;
	public $perms;
	public $mtime;

	/**
	 * constructor of this class
	 *
	 * @param \DirectoryIterator $entry
	 */
	public function __construct(\DirectoryIterator $entry) {
		$this->name = $entry->getFilename();
		$this->path = $entry->getPath();
		$this->fullPath = $entry->getPathname();
		$this->isDir = $entry->isDir();
		$this->size = $entry->getSize();
		$this->perms = $entry->getPerms();
		$this->mtime = $entry->getMTime();
	}

	/**
	 * return formatted filesize
	 *
	 * @return string
	 */
	public function getSize() {
		return GeneralUtility::formatSize($this->size, ' Bytes| KB| MB| GB | TB');
	}

	/**
	 * This is my own interpretation how to calculate the perms
	 * Maybe there is someone to create a better method
	 *
	 * @return string
	 */
	public function getPerms() {
		$perms = array();
		for ($i = 0; $i < 16; $i++) {
			if ($this->perms & pow(2, $i)) {
				if ($i === 0 || $i === 3 || $i === 6) {
					$perms[$i] = 'x';
				}
				if ($i === 1 || $i === 4 || $i === 7) {
					$perms[$i] = 'w';
				}
				if ($i === 2 || $i === 5 || $i === 8) {
					$perms[$i] = 'r';
				}
				if ($i === 15) {
					$perms[$i] = '-';
				}
			} else {
				if ($i === 15) {
					$perms[$i] = 'd';
				} else {
					if (MathUtility::isIntegerInRange($i, 0, 8)) {
						$perms[$i] = '-';
					}
				}
			}
		}
		krsort($perms);
		return implode('', $perms);
	}

	/**
	 * getter for relative path
	 *
	 * @return string
	 */
	public function getRelativePath() {
		if (!GeneralUtility::isFirstPartOfStr($this->fullPath, PATH_site)) {
			$relativePath = '';
		} else {
			$relativePath = str_replace(PATH_site, '', $this->fullPath);
		}
		return $relativePath;
	}

}