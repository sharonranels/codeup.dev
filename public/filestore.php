<?php

class Filestore {

    
    public $filename = '';

    function __construct($filename = '') 
    {
        $this->filename = $filename; 

        //Sets $this->filename
    }

    /**
     * Returns array of lines in $this->filename
     */
    function read_file()
    {
        $handle = fopen($this->filename, "r+");
        $contents = fread($handle, filesize($this->filename));
        fclose($handle);
        return explode("\n", $contents);
    }

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    function save_file($array)
    {
        $itemStr = implode("\n", $this->items);
        $handle = fopen($this->filename, "w+");
        fwrite($handle, $itemStr);
        fclose($handle);
    }

    /**
     * Reads contents of csv $this->filename, returns an array
     */
    function read_csv()
    {
        $address_book = [];
        if(empty($this->filename)) {
            $address_book = [];
        } else {
            $handle = fopen($this->filename, "r+");
            while(($data = fgetcsv($handle)) !== FALSE) {
                $address_book[] = $data;
            }   
            fclose($handle);
        }

        return $address_book;
    }

    /**
     * Writes contents of $array to csv $this->filename
     */
    function write_csv($array)
    {
        $handle = fopen($this->filename, 'w');
        foreach ($array as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }

}