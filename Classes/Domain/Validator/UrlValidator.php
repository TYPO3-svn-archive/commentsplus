<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Sebastian Michaelsen <michaelsen@t3seo.de>, t3seo.de
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
 * Validates if a given string is a valid URL. Empty strings will also validate.
 *
 * @package commentsplus
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_Commentsplus_Domain_Validator_UrlValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {

    /**
     * @param $value
     * @return bool
     */
    public function isValid($value) {
        $valid = strlen(trim($value)) ? t3lib_div::isValidUrl($value) : TRUE;
        if(!$valid) {
            $this->addError('URL must be valid or empty', 1316031555);
        }
        return $valid;
    }

}
