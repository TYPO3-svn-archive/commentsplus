<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Comments',
	'Comments Plus'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Comments Plus');


t3lib_extMgm::addLLrefForTCAdescr('tx_commentsplus_domain_model_comment', 'EXT:commentsplus/Resources/Private/Language/locallang_csh_tx_commentsplus_domain_model_comment.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_commentsplus_domain_model_comment');
$TCA['tx_commentsplus_domain_model_comment'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:commentsplus/Resources/Private/Language/locallang_db.xml:tx_commentsplus_domain_model_comment',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Comment.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_commentsplus_domain_model_comment.gif',
	),
);

if(TYPO3_MODE == 'BE') {
	require_once(t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Utility/Reports.php');
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['commentsplus'][] = 'Tx_Commentsplus_Utility_Reports';
}

?>