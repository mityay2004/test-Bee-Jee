<?php

//https://github.com/nikic/FastRoute
//https://github.com/Wixel/GUMP
//https://medoo.in/api/query
//https://platesphp.com/v3/simple-example/

define("LOADED_FROM_INDEX", true);

require 'vendor/autoload.php';
require 'system/Loader.php';
spl_autoload_register('\system\Loader::loadClass');



try {
    $lazy = new \system\Lazy();
    
    $router = $lazy->getRouterInstance();
    
    $routeInfo = $router->routeRequest();
    $controller = $router->handle($routeInfo);
    $auth = $lazy->getAuthInstance();
    $auth->init($router);
    $controller->setLazy($lazy);
    call_user_func_array([$controller, $routeInfo[1][1]], $routeInfo[2]);

} catch (\Exception $ex) {
    http_response_code($ex->getCode());
    echo $ex->getMessage();
}

