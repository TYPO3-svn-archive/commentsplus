<?php
 
class Tx_Commentsplus_Domain_Validator_MessageNotEmptyValidator extends Tx_Extbase_Validation_Validator_NotEmptyValidator {

    /**
	 * Checks if the given property ($propertyValue) is not empty (NULL or empty string).
	 *
	 * If at least one error occurred, the result is FALSE.
	 *
	 * @param mixed $value The value that should be validated
	 * @return boolean TRUE if the value is valid, FALSE if an error occured
	 */
	public function isValid($value) {
		$this->errors = array();
        $value = trim($value);
		if ($value === NULL || $value === '') {
			$this->addError('No Message provided.', 1317025849);
			return FALSE;
		}
		return TRUE;
	}

}
