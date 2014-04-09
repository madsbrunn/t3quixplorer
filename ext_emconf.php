<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "t3quixplorer".
 *
 * Auto generated 29-03-2014 07:40
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Typo3 Quixplorer',
	'description' => 'This extension introduces Quixplorer! A backend module that makes you capable of exploring the files and folders of your entire webserver. Browse directories. View and edit ascii files. Create, copy, move, delete, archive files and directories. Download and upload files. Change permissions on files and folders.',
	'category' => 'module',
	'shy' => 0,
	'version' => '2.0.0',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => 'mod1',
	'state' => 'alpha',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Mads Brunn, Stefan Fröemken',
	'author_email' => 'mads@brunn.dk,froemken@gmail.com',
	'author_company' => 'T3QDevTeam',
	'CGLcompliance' => NULL,
	'CGLcompliance_note' => NULL,
	'constraints' => 
	array (
		'depends' => 
		array (
			'php' => '5.3.0',
			'typo3' => '6.2.0',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
);

?>