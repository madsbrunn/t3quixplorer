<?php
namespace MadsBrunn\T3quixplorer\Domain\Repository;

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

/**
 * @package t3quixplorer
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FileSystemRepository  {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * Injects the object manager
	 *
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * find all directories and files of given directory
	 *
	 * @param string $directory
	 * @return array
	 */
	public function findAllByDirectory($directory) {
		$directory = new \DirectoryIterator($directory);
		$entries = array();
		/** @var \DirectoryIterator $entry */
		foreach ($directory as $entry) {
			if ($entry->isDot()) {
				continue;
			} elseif ($entry->isDir() || $entry->isFile()) {
				/** @var \MadsBrunn\T3quixplorer\Domain\Model\Entry $entry */
				$entry = $this->objectManager->get('MadsBrunn\\T3quixplorer\\Domain\\Model\\Entry', $entry);
				$entries[$entry->name] = $entry;
			} else {
				// is link or what ever
				continue;
			}
		}
		return $entries;
	}

}