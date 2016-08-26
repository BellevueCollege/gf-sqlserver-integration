<?php

class Utility {

    public static function check_encoding ($_input_array) {
        foreach ( $_input_array as $key => $value ) {
            if ( mb_detect_encoding($value) == "UTF-8" ) {
                //then encode it for UTF-16
                $encoded_val = iconv("UTF-8", "UTF-16", $value);
                echo "Key " . $key . " has UTF-8 encoding";
                $_input_array[$key] = $encoded_val;
            } else if ( mb_detect_encoding($value) == "ASCII" && preg_match("/\r\n|\r|\n/", $value) ) {
                //has newline characters so convert encoding
                $encoded_val = iconv("ASCII", "UTF-16", $value);
                echo "Key " . $key . " has ASCII encoding and new lines";
                $_input_array[$key] = $encoded_val;
            }
            
        }
        return $_input_array;
    }
}