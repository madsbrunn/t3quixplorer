<?php
namespace MadsBrunn\T3quixplorer\Controller;

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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class QuixplorerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \MadsBrunn\T3quixplorer\Domain\Repository\FileSystemRepository
	 */
	protected $fileSystemRepository;

	/**
	 * inject FileSystemRepository
	 *
	 * @param \MadsBrunn\T3quixplorer\Domain\Repository\FileSystemRepository $fileSystemRepository
	 */
	public function injectFileSystemRepository(\MadsBrunn\T3quixplorer\Domain\Repository\FileSystemRepository $fileSystemRepository) {
		$this->fileSystemRepository = $fileSystemRepository;
	}

	/**
	 * list action
	 *
	 * @param string $directory
	 * @return void
	 */
	public function listAction($directory = '') {

		// get current directory
		if (empty($directory)) {
			$currentDirectory = PATH_site;
		} else {
			$currentDirectory = PATH_site . $directory;

			// check if directory exists
			if (!is_dir($currentDirectory)) {
				$currentDirectory = PATH_site;
			}
		}

		// get files and folders of current directory
		$entries = $this->fileSystemRepository->findAllByDirectory($currentDirectory);
		$this->view->assign('entries', $entries);
	}

}