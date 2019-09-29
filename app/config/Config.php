<?php

namespace app\config;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

/**
 * Configuration class for App
 */
class Config 
{
    public static 
        $router = [
            'defaultController' => '\app\controllers\Main',
            'defaultMethod' => 'index',
            'routes' => [
                ['GET', '/', []],
                [['GET', 'POST'], '/create_task', ["\app\controllers\Main", "add_task"]],
                [['GET', 'POST'], '/login', ["\app\controllers\Main", "login"]],
                [['GET', 'POST'], '/edit/{id:\d+}', ["\app\controllers\Main", "edit_task"]],
                ['GET', '/logout', ["\app\controllers\Main", "logout"]],
            ],
        ],
        $templates = [
            'pathToViews' => 'app/views/'
        ],
        $db = [
            'connect' => [
                'database_type' => 'mysql',
                'database_name' => 'bj',
                'server' => 'localhost',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
                'collat' => 'utf8_general_ci',
            ]
        ],
        $auth = [
            'username' => 'admin',
            'password' => '123'
        ];
}
