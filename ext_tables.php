<?php
if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'T3QDevTeam.' . $_EXTKEY,
		'tools',	 // Make module a submodule of 'web'
		't3quixplorer',	// Submodule key
		'',						// Position
		array(
			'List' => 'index',
			'FileSystem' => 'createEntry,showRenameForm,rename,showEditForm,editFile,processMarkedFiles',
			'Archive' => 'zip,unzip,rar,unrar,tar,untar',
			'TextFile' => 'showEditFileForm,saveFile,checkPhpSyntaxAction'
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_quixplorer.xlf',
		)
	);
}

// register t3quixplorer sprite icons
$relPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/';
$icons = array();
$icons['archive'] = $relPath . 'Archive.gif';
$icons['copy'] = $relPath . 'Copy.gif';
$icons['cut'] = $relPath . 'Cut.gif';
$icons['delete'] = $relPath . 'Delete.gif';
$icons['download'] = $relPath . 'Download.gif';
$icons['download-deactivated'] = $relPath . 'DownloadDeactivated.gif';
$icons['edit'] = $relPath . 'Edit.gif';
$icons['edit-deactivated'] = $relPath . 'EditDeactivated.gif';
$icons['extract'] = $relPath . 'Extract.gif';
$icons['extract-deactivated'] = $relPath . 'ExtractDeactivated.gif';
$icons['home'] = $relPath . 'Home.gif';
$icons['paste'] = $relPath . 'Paste.gif';
$icons['refresh'] = $relPath . 'Refresh.gif';
$icons['rename'] = $relPath . 'Rename.gif';
$icons['search'] = $relPath . 'Search.gif';
$icons['up'] = $relPath . 'Up.gif';
$icons['upload'] = $relPath . 'Upload.gif';
\TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons($icons, $_EXTKEY);