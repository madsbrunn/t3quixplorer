<?php
namespace MadsBrunn\T3quixplorer\ViewHelpers;

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
 * @package socialpublish
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DirectoryInformationViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Create sprite icon for file
	 *
	 * @param \MadsBrunn\T3quixplorer\Domain\Model\Directory $directory
	 * @return string html
	 */
	public function render(\MadsBrunn\T3quixplorer\Domain\Model\Directory $directory) {
		$directoryInformation = array();
		/** @var \MadsBrunn\T3quixplorer\Domain\Model\Entry $entry */
		foreach ($directory->getEntries() as $entry) {
			$directoryInformation['size'] += (int)$entry->size;
			$directoryInformation['entries'] += 1;
			if ($entry->isDir) {
				$directoryInformation['directories'] += 1;
			} else {
				$directoryInformation['files'] += 1;
			}
		}
		$this->templateVariableContainer->add('size', GeneralUtility::formatSize($directoryInformation['size'], ' Bytes| KB| MB| GB| TB'));
		$this->templateVariableContainer->add('entries', $directoryInformation['entries']);
		$this->templateVariableContainer->add('directories', $directoryInformation['directories']);
		$this->templateVariableContainer->add('files', $directoryInformation['files']);
		$this->templateVariableContainer->add('freeDiskSpace', $this->getDiskFreeSpace($directory));
		$output = $this->renderChildren();
		$this->templateVariableContainer->remove('size');
		$this->templateVariableContainer->remove('entries');
		$this->templateVariableContainer->remove('directories');
		$this->templateVariableContainer->remove('files');
		$this->templateVariableContainer->remove('freeDiskSpace');
		return $output;
	}

	/**
	 * get disk free space
	 *
	 * @param \MadsBrunn\T3quixplorer\Domain\Model\Directory $directory
	 * @return string
	 */
	protected function getDiskFreeSpace(\MadsBrunn\T3quixplorer\Domain\Model\Directory $directory) {
		if(function_exists('disk_free_space')) {
			$freeDiskSpace = GeneralUtility::formatSize(disk_free_space($directory->getDirectory()->getPath()), ' Bytes| KB| MB| GB| TB');
		} else {
			$freeDiskSpace = '?';
		}
		return $freeDiskSpace;
	}

}