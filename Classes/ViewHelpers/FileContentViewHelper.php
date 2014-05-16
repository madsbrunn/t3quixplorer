<?php
namespace T3QDevTeam\T3quixplorer\ViewHelpers;

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
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @package t3quixplorer
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FileContentViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \TYPO3\CMS\T3editor\T3editor
	 * @inject
	 */
	protected $t3editor = NULL;

	/**
	 * @var \TYPO3\CMS\Core\Page\PageRenderer
	 * @inject
	 */
	protected $pageRenderer = NULL;

	/**
	 * Create sprite icon for file
	 *
	 * @param string $relativePath
	 * @param string $fileName
	 * @return string html
	 */
	public function render($relativePath, $fileName) {
		if (!$this->t3editor->isEnabled()) {
			return '<textarea rows="20" cols="50">Tag auch</textarea>';
		}
		$this->t3editor->setModeByFile(PATH_site . $relativePath . $fileName);
		$this->pageRenderer->loadPrototype();
		$this->pageRenderer->loadScriptaculous();

		$fileContent = file_get_contents(PATH_site . $relativePath . $fileName);
		$htmlForTextarea =  $this->t3editor->getCodeEditor('tx_t3quixplorer_tools_t3quixplorert3quixplorer[code]', 'enable-tab', $fileContent, 'rows="20" cols="50" style="width: 90%"', 'content of file', array());

		$path_t3e = ExtensionManagementUtility::extRelPath('t3editor');
		$path_codemirror = 'contrib/codemirror/js/';
		$js = GeneralUtility::wrapJS(
			'T3editor = T3editor || {};' .
			'T3editor.lang = ' . json_encode($this->getJavaScriptLabels()) . ';' . LF .
			'T3editor.PATH_t3e = "' . $GLOBALS['BACK_PATH'] . $path_t3e . '"; ' . LF .
			'T3editor.PATH_codemirror = "' . $GLOBALS['BACK_PATH'] . $path_codemirror . '"; ' . LF .
			'T3editor.URL_typo3 = "' . htmlspecialchars(GeneralUtility::getIndpEnv('TYPO3_SITE_URL') . TYPO3_mainDir) . '"; ' . LF .
			'T3editor.template = ' . $this->getPreparedTemplate() . ';' . LF .
			'T3editor.ajaxSavetype = "";' . LF
		);
		$js .= $this->t3editor->getModeSpecificJavascriptCode();

		return $htmlForTextarea . LF . $js;
	}

	/**
	 * Get the template code, prepared for javascript (no line breaks, quoted in single quotes)
	 *
	 * @return string The template code, prepared to use in javascript
	 */
	protected function getPreparedTemplate() {
		$T3editor_template = GeneralUtility::getUrl(GeneralUtility::getFileAbsFileName('EXT:t3editor/res/templates/t3editor.html'));
		$T3editor_template = addslashes($T3editor_template);
		$T3editor_template = str_replace(array(CR, LF), array('', '\' + \''), $T3editor_template);
		return '\'' . $T3editor_template . '\'';
	}

	/**
	 * Gets the labels to be used in JavaScript in the Ext JS interface.
	 * TODO this method is copied from EXT:Recycler, maybe this should be refactored into a helper class
	 *
	 * @return array The labels to be used in JavaScript
	 */
	protected function getJavaScriptLabels() {
		$coreLabels = array();
		$extensionLabels = $this->getJavaScriptLabelsFromLocallang('js.', 'label_');
		return array_merge($coreLabels, $extensionLabels);
	}

	/**
	 * Gets labels to be used in JavaScript fetched from the current locallang file.
	 * TODO this method is copied from EXT:Recycler, maybe this should be refactored into a helper class
	 *
	 * @param string $selectionPrefix Prefix to select the correct labels (default: 'js.')
	 * @param string $stripFromSelectionName Sub-prefix to be removed from label names in the result (default: '')
	 * @return array Lables to be used in JavaScript of the current locallang file
	 * @todo Check, whether this method can be moved in a generic way to $GLOBALS['LANG']
	 */
	protected function getJavaScriptLabelsFromLocallang($selectionPrefix = 'js.', $stripFromSelectionName = '') {
		$extraction = array();
		$labels = array_merge((array) $GLOBALS['LOCAL_LANG']['default'], (array) $GLOBALS['LOCAL_LANG'][$GLOBALS['LANG']->lang]);
		// Regular expression to strip the selection prefix and possibly something from the label name:
		$labelPattern = '#^' . preg_quote($selectionPrefix, '#') . '(' . preg_quote($stripFromSelectionName, '#') . ')?#';
		// Iterate throuh all locallang lables:
		foreach ($labels as $label => $value) {
			if (strpos($label, $selectionPrefix) === 0) {
				$key = preg_replace($labelPattern, '', $label);
				$extraction[$key] = $value;
			}
		}
		return $extraction;
	}

}