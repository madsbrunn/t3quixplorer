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

/**
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * current directory with additional information
	 *
	 * @var \T3QDevTeam\T3quixplorer\Domain\Model\Directory
	 */
	protected $directory;

	/**
	 * add some variables for all actions
	 * Info: Sure, I know I can set directory in controller actions, but then I have to add them in EACH controller action.
	 * With this solution the directory was generated at a very early state
	 *
	 * @return void
	 */
	public function initializeAction() {
            
		// get directory
		if ($this->request->hasArgument('directory')) {
			$directory = $this->request->getArgument('directory');
		} else {
			$directory = '';
		}
		// get sortBy
		if ($this->request->hasArgument('sortBy')) {
			$sortBy = $this->request->getArgument('sortBy');
		} else {
			$sortBy = '';
		}
		// get sort directory
		if ($this->request->hasArgument('sortDirection')) {
			$sortDirection = $this->request->getArgument('sortDirection');
		} else {
			$sortDirection = '';
		}
		$this->directory = $this->objectManager->get('T3QDevTeam\\T3quixplorer\\Domain\\Model\\Directory', $directory, $sortBy, $sortDirection);
	}

	/**
	 * add directory model to view
	 *
	 * @return void
	 */
	public function initializeView() {
		$this->view->assign('directory', $this->directory);
	}

}