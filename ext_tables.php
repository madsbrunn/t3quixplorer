<?php
if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'MadsBrunn.' . $_EXTKEY,
		'tools',	 // Make module a submodule of 'web'
		't3quixplorer',	// Submodule key
		'',						// Position
		array(
			'Quixplorer' => 'list, createEntry',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_quixplorer.xlf',
		)
	);
}

/*if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::addModule('tools','txt3quixplorerM1',"",t3lib_extMgm::extPath($_EXTKEY).'mod1/');
}*/