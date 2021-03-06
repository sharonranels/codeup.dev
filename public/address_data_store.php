<?php

class IncorrectInfoException extends Exception {}

require_once('filestore.php');

class AddressDataStore extends Filestore {


    function __construct($filename)
    {
        $filename = strtolower($filename);
        parent::__construct($filename);
    }

    public function validate($name, $string) {
        if(empty($string)) {
            throw new IncorrectInfoException('Please enter data for all lines with a "*".');
        }
        if(strlen($string) > 125) {
            throw new IncorrectInfoException("You must have fewer than 125 characters.");
        }
    
    }

}

?>