<?php

namespace system;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

class Loader 
{
    static function loadClass($_class) {
        $file = str_replace('\\', '/', $_class) . '.php';
        if (file_exists($file)) {
            include_once $file;
            return true;
        }
        return false;
    }
}
