<?php

class AddressDataStore {

	public $filename = '';

	function __construct($filename = '')
	{
		$this->filename = $filename;
	}

    function read_address_book()
    {
        if(empty($this->filename)) {
    	$address_book = [];
    } else {
    	$handle = fopen($this->filename, "r+");
    	while(($data = fgetcsv($handle)) !==FALSE) {
    		$address_book[] = $data;
		}	
    	fclose($handle);
	}
    	return $address_book;
    }

    function writeCSV($addresses_array) 
    {
        $handle = fopen($this->filename, 'w');
	foreach ($addresses_array as $row) {
		fputcsv($handle, $row);
	}
	fclose($handle);
	}
}
?>