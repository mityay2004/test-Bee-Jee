<?php

namespace system;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

class MController 
{
    protected static $instance;
    protected $lazy;
    protected $db;
    protected $alerts;

    public function __construct() 
    {
        session_start();
        self::$instance = $this;
        $this->_getAlerts();
    }
    
    public static function getInstance() 
    {
        return self::$instance;
    }
    
    public function setLazy(Lazy $lazy)
    {
        $this->lazy = $lazy;
    }
    
    private function _getAlerts()
    {
        if (isset($_SESSION['alertSuccess'])) {
            $this->alerts['success'] = $_SESSION['alertSuccess'];
            unset($_SESSION['alertSuccess']);
        }
        if (isset($_SESSION['alertWarning'])) {
            $this->alerts['warning'] = $_SESSION['alertWarning'];
            unset($_SESSION['alertWarning']);
        }
    }
}
