<?php

namespace system;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

use \League\Plates\Engine,
        \Medoo\Medoo,
        \app\config\Config,
        \app\libs\Autorization;
class Lazy 
{
    private $gump,
            $uri,
            $router,
            $templates,
            $auth;
    public $db;
    
    public function __construct() {
        ;
    }

    public function getGumpInstance()
    {
        if (!isset($this->gump)) {
            $this->gump = new \GUMP();
        }
        return $this->gump;
    }
    
    public function getUriInstance()
    {
        if (!isset($this->uri)) {
            $this->uri = new Uri();
        }
        return $this->uri;
    }
    
    public function getRouterInstance()
    {
        if (!isset($this->router)) {
            $this->router = new Router(
                    $this->getGumpInstance(),
                    $this->getUriInstance());
        }
        return $this->router;
    }
    
    public function getTemplatesInstance()
    {
        if (!isset($this->templates)) {
            $this->templates = new Engine(Config::$templates['pathToViews']);
        }
        return $this->templates;
    }
    
    public function getDbInstance()
    {
        if (!isset($this->db)) {
            $this->db = new Medoo(Config::$db['connect']);
        }
        return $this->db;
    }
    
    public function getAuthInstance()
    {
        if (!isset($this->auth)) {
            $this->auth = new Autorization(new \app\libs\Security());
        }
        return $this->auth;
    }
}
