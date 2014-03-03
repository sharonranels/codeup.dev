<?php

class Filestore {

    
    public $filename = '';

    private $is_csv = FALSE;

    //Sets $this->filename
    public function __construct($filename = '') 
    {
        $this->filename = $filename; 

        if (substr($filename, -3) == 'csv') {
            $this->is_csv = TRUE;
        }
    }

    public function read() {
        if ($this->is_csv ==TRUE) {
            return $this->read_csv();
        } else {
            return $this->read_file();
        }
    }

    public function write($array) {
        if ($this->is_csv ==TRUE) {
            return $this->write_csv($array);
        } else {
            return $this->save_file($array);
        }
    }

    // Returns array of lines in $this->filename
    private function read_file()
    {
        $handle = fopen($this->filename, "r+");
        $contents = fread($handle, filesize($this->filename));
        fclose($handle);
        return explode("\n", $contents);
    }

    // Writes each element in $array to a new line in $this->filename
    private function save_file($array)
    {
        $itemStr = implode("\n", $this->items);
        $handle = fopen($this->filename, "w+");
        fwrite($handle, $itemStr);
        fclose($handle);
    }

    // Reads contents of csv $this->filename, returns an array
    private function read_csv()
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

    // Writes contents of $array to csv $this->filename
    private function write_csv($array)
    {
        $handle = fopen($this->filename, 'w');
        foreach ($array as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }

}