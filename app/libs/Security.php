<?php 

namespace app\libs;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

/**
 * Simple class imitate security class for using in Authorization library.
 * Can be simple replaced by any other with stronger encryption
 */
class Security 
{
    private $key;
    
    public function encrypt(string $str): string
    {
        return md5($str);
    }
    
    public function decrypt(string $str): string
    {
        return $str;
    }
    
    public function setKey(string $key) 
    {
        $this->key = $key;
    }
}