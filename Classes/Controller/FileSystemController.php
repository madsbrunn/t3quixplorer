<?php
namespace T3QDevTeam\T3quixplorer\Controller;

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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FileSystemController extends \T3QDevTeam\T3quixplorer\Controller\AbstractController {


	/**
	 * createEntry action
	 *
	 * @param string $type The type of the entry. Either file or directory
	 * @param string $name The name of the file or directory
	 * @return void
	 */
	public function createEntryAction($type, $name) {
		$path = $this->directory->getDirectory()->getPath();
		if ($type === 'file') {
			touch($path . '/' . $name);
		}
		if ($type === 'directory') {
			mkdir($path . '/' . $name);
		}
		GeneralUtility::fixPermissions($path . '/' . $name);
		$this->redirect('index', 'List', NULL, array('directory' => $this->directory->getRelativePath()));
	}

	/**
	 * show rename form
	 *
	 * @param string $relativePath
	 * @param string $name
	 * @return void
	 */
	public function showRenameFormAction($relativePath, $name) {
		$this->view->assign('relativePath', $relativePath);
		$this->view->assign('name', $name);
	}

	/**
	 * rename action
	 *
	 * @param string $relativePath
	 * @param string $oldName
	 * @param string $newName
	 * @return void
	 */
	public function renameAction($relativePath, $oldName = '', $newName = '') {
		$relativePath = rtrim($relativePath, '/') . '/';
		if ($relativePath === '/') $relativePath = '';
		$oldName = PATH_site . $relativePath . $oldName;
		$newName = PATH_site . $relativePath . $newName;
		if ($oldName === $newName) {
			// @ToDo: Add flash message
		} else {
			rename($oldName, $newName);
		}
		$this->redirect('index', 'List', NULL, array('directory' => $this->directory->getRelativePath()));
	}

}