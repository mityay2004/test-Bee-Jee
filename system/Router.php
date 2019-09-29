<?php

namespace system;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

use \FastRoute\Dispatcher,
        \FastRoute\simpleDispatcher,
        \FastRoute\RouteCollector;
use \app\config\Config,
        \system\Uri;

/**
 * Central Router in App
 * Here come all requests
 */
class Router 
{
    private $baseUrl,
            $pathUrl,
            $fullUrl,
            $parsedUri;
    
    private $dispatcher;
    
    public $server;
    public $post;
    public $cookies;
    
    public function __construct(\GUMP $gump, Uri $uriHandler) 
    {
        $this->dispatcher = \FastRoute\simpleDispatcher(function(RouteCollector $r) {
            foreach (Config::$router['routes'] as $route) {
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        });

        $this->server = $gump->sanitize($_SERVER);
        $this->cookies = $gump->sanitize($_COOKIE);
        
        $this->baseUrl = $uriHandler->getBaseUrl($this->server);
        $tmp = $this->server['REQUEST_URI'];
        $this->fullUrl = $this->baseUrl . $tmp;
        $parsedUri = $uriHandler->parseUri($this->fullUrl);
        
        $this->parsedUri = $gump->sanitize($parsedUri);
        
        $this->pathUrl = $this->parsedUri['path'];
        
        if (isset($_POST)) {
            $this->post = $gump->sanitize($_POST);
        }
    }
    
    /**
     * Handle request
     * @throws \Exception
     */
    public function routeRequest()
    {
        $httpMethod = $this->server['REQUEST_METHOD'];
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $this->pathUrl);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new \Exception("Page not found", 404);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                throw new \Exception("Method not allowed", 405);
                break;
        }
        return $routeInfo;
    }
    
    public function handle(array &$routeInfo)
    {
        if (is_array($routeInfo[1])) {
            switch (count($routeInfo[1])) {
                case 0:
                    $routeInfo[1] = [
                        Config::$router['defaultController'],
                        Config::$router['defaultMethod']];
                    break;;
                case 1:
                    $routeInfo[1][1] = Config::$router['defaultMethod'];
                    break;
            }
            
            $controller = new $routeInfo[1][0];
            return $controller;
        } else {
            call_user_func($routeInfo[1], [$routeInfo[2]]);
        }
    }

    /**
     * Getter
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
    
    /**
     * Getter
     * @return string
     */
    public function getPathUrl(): string
    {
        return $this->pathUrl;
    }
    
    /**
     * Getter
     * @return string
     */
    public function getFullUrl(): string
    {
        return $this->fullUrl;
    }
    /**
     * Getter
     * @return array
     */
    public function getParsedUrl(): array
    {
        return $this->parsedUri;
    }
    
    /**
     * Getter
     */
    public function getQueryUrl()
    {
        return isset($this->parsedUri['query']) ? $this->parsedUri['query'] : null;
    }
}
