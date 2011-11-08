<?php

class Tx_Commentsplus_Domain_Validator_NameNotEmptyValidator extends Tx_Extbase_Validation_Validator_NotEmptyValidator {

    /**
	 * Checks if the given property ($propertyValue) is not empty (NULL or empty string).
	 *
	 * If at least one error occurred, the result is FALSE.
	 *
	 * @param mixed $value The value that should be validated
	 * @return boolean TRUE if the value is valid, FALSE if an error occured
	 */
	public function isValid($value) {
        $value = trim($value);
		if ($value === NULL || $value === '') {
			$this->addError('No Name provided.', 1316247780);
			return FALSE;
		}
		return TRUE;
	}

}
