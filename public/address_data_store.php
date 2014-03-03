<?php

require_once('filestore.php');

class AddressDataStore extends Filestore {


    function __construct($filename)
    {
        $filename = strtolower($filename);
        parent::__construct($filename);
    }

    public function validate($name, $string) {
        if(empty($string)) {
            throw new Exception("Please enter data.");
        }
        if(strlen($string) > 125) {
            throw new Exception("You must have fewer than 125 characters.");
        }
    
    }

}

?>