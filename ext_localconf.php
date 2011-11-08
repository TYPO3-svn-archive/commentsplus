<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Comments',
	array(
		'Comment' => 'list, new, create'
	),
	array(
		'Comment' => 'create'
	)
);

?>