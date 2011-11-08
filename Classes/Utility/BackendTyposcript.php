<?php
require_once (PATH_t3lib.'class.t3lib_page.php');
require_once (PATH_t3lib.'class.t3lib_tstemplate.php');
require_once (PATH_t3lib.'class.t3lib_tsparser_ext.php');

class Tx_Commentsplus_Utility_BackendTyposcript {

	/**
	 * @var array
	 */
	protected static $TScache = array();

	/**
	 * @var t3lib_pageSelect
	 */
	protected static $sysPageObj = NULL;

	/**
	 * @var t3lib_tsparser_ext
	 */
	protected static $TSParser = NULL;

	/**
	 * Gets you the TS setup for a given FE page. Intended to be used in the Backend
	 *
	 * @static
	 * @param $pageId
	 * @return array
	 */
	public static function getTyposcriptSetup($pageId) {
		if(!self::$TScache[$pageId]) {
			self::init();
			$rootline = self::$sysPageObj->getRootLine($pageId);
			self::$TSParser->runThroughTemplates($rootline);
			self::$TSParser->generateConfig();
			self::$TScache[$pageId] = self::$TSParser->setup;
		}
		return self::$TScache[$pageId];
	}

	/**
	 * @static
	 * @return void
	 */
	protected static function init() {
		if(self::$sysPageObj === NULL) {
			self::$sysPageObj = t3lib_div::makeInstance('t3lib_pageSelect');
		}
		if(self::$TSParser === NULL) {
			self::$TSParser = t3lib_div::makeInstance('t3lib_tsparser_ext');
			self::$TSParser->tt_track = 0;
			self::$TSParser->init();
		}
	}

}
