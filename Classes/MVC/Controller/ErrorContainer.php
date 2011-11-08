<?php

class Tx_Commentsplus_MVC_Controller_ErrorContainer implements t3lib_Singleton {

    protected $errors = array();

    public function addError(Tx_Extbase_Error_Error $error) {
        $this->errors[] = $error;
    }

    public function getErrors() {
        return $this->errors;
    }

}
