<?php
 
class Tx_Commentsplus_Utility_Localization {

    /**
	 * Taken from EXT:blog_example
	 *
	 * @param string $key locallang key
	 * @param string $default the default message to show if key was not found
	 * @return string
	 */
	public static function translate($key, $defaultMessage = '') {
		$message = Tx_Extbase_Utility_Localization::translate($key, 'Commentsplus');
		if ($message === NULL) {
			$message = $defaultMessage;
		}
		return $message;
	}

}
