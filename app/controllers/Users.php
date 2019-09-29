<?php

namespace app\controllers;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

use system\MController;

class Users extends MController
{
    public function get()
    {
        echo "controllers users";
    }
    
    public function index()
    {
        $tmpl = $this->lazy->getTemplates();
//        $dd = $this->db->query("select * from users")->fetchAll(\PDO::FETCH_ASSOC);
//        echo '<pre>' . var_export($dd, true) . '</pre>';
        echo $tmpl->render('tasks/blog', ['name' => 'Jonathan']);        
    }
}
