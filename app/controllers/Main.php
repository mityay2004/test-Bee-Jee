<?php

namespace app\controllers;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

use system\MController,
        \app\models\Tasks,
        \app\libs\Mpagination,
        \app\libs\HelperValidation,
        \app\models\Auth;

class Main extends MController
{
    public function index()
    {
        $tmpl = $this->lazy->getTemplatesInstance();
        
        $taskModel = new Tasks($this->lazy);
        
        $data['router'] = $this->lazy->getRouterInstance();
        $data['uri'] = $this->lazy->getUriInstance();
        $data['auth'] = $this->lazy->getAuthInstance();
        $query = $data['router']->getQueryUrl();
        
        $pageCount = $taskModel->getTasksCountPages();

        $page = 1;
        if (isset($query['page'])) {
            if (!ctype_digit($query['page']) || (int)$query['page'] > $pageCount) {
                $href = $data['uri']->removeGetParam($data['router']->getFullUrl(), ['page']);
                \system\Uri::redirect($href, 302);
            }
            $page = (int)$query['page'];
        }
        
        $paginator = new Mpagination($data['router']);
        $data['paginator'] = $paginator->generate_link([
            'pageCount' => $pageCount,
            'class' => 'pagination justify-content-center',
        ]);

        $data['sortCondition'] = $taskModel->getSortCondition($data['router']);
        $data['tasks'] = $taskModel->getTasksk($page, $data['sortCondition']);
        
        $data['alerts'] = $this->alerts;
        
        echo $tmpl->render('tasks/list/task_list', $data);        
    }
    
    public function add_task()
    {
        $tmpl = $this->lazy->getTemplatesInstance();
        
        $taskModel = new Tasks($this->lazy);
        
        $data['router'] = $this->lazy->getRouterInstance();
        $data['uri'] = $this->lazy->getUriInstance();
        $gump = $this->lazy->getGumpInstance();
        
        if ($data['router']->server['REQUEST_METHOD'] === "POST") {
            $res = $taskModel->validateTask(
                    $gump,
                    $data['router']->post);
            if($res === false) {
                    $data['errors'] = HelperValidation::resolveErrorMessages(
                            $gump->get_errors_array(),
                            [
                                '%Email' => "\"Email адрес\"",
                                '%Task' => "\"Задача\"",
                                '%Username' => "\"Имя пользователя\"",
                            ]);
            } else {
                $res = $taskModel->saveTask($data['router']);
                if ($res === 0) {
                    $_SESSION['alertWarning'] = "Задача не добавлена, что-то пошло не так!";
                } else {
                    $_SESSION['alertSuccess'] = "Задача с ID " . $res . " успешно добавлена!";
                }
                $data['uri']->redirect($data['router']->getBaseUrl(), 302);
            }        
        }
        
        $data['alerts'] = $this->alerts;
        
        echo $tmpl->render('tasks/create/create_task', $data);        
    }
    
    public function login()
    {
        $tmpl = $this->lazy->getTemplatesInstance();
        
        $authModel = new Auth($this->lazy);
        
        $data['router'] = $this->lazy->getRouterInstance();
        $data['uri'] = $this->lazy->getUriInstance();
        $gump = $this->lazy->getGumpInstance();
        
        if ($data['router']->server['REQUEST_METHOD'] === "POST") {
            $res = $authModel->validateLogin(
                    $gump,
                    $data['router']->post);
            if($res === false) {
                    $data['errors'] = HelperValidation::resolveErrorMessages(
                            $gump->get_errors_array(),
                            [
                                '%Password' => "\"Пароль\"",
                                '%Username' => "\"Имя пользователя\"",
                            ]);
            } else {
                $this->lazy->getAuthInstance()->login(
                        $data['router']->post['username'],
                        $data['router']->post['password']);
                $_SESSION['alertSuccess'] = "Вы успешно вошли в систему.";
                $data['uri']->redirect($data['router']->getBaseUrl(), 302);
            }        
        }
        
        $data['alerts'] = $this->alerts;
        
        echo $tmpl->render('auth/login', $data);        
    }
    
    public function logout()
    {
        $this->lazy->getAuthInstance()->logout();
        $_SESSION['alertSuccess'] = "Вы успешно вышли из системы.";
        $this->lazy
                ->getUriInstance()
                ->redirect(
                        $this->lazy->getRouterInstance()->getBaseUrl(),
                        302);
    }
    
    public function edit_task($id) {
        $data['router'] = $this->lazy->getRouterInstance();
        $data['uri'] = $this->lazy->getUriInstance();
        $gump = $this->lazy->getGumpInstance();
        
        if (!$this->lazy->getAuthInstance()->isAuthorized()) {
            $_SESSION['alertWarning'] = "Вы не имеете доступа к запрошенному адресу!";
            $data['uri']->redirect($data['router']->getBaseUrl(), 302);
        }
        
        $tmpl = $this->lazy->getTemplatesInstance();
        
        $taskModel = new Tasks($this->lazy);
        
        
        
        $data['task'] = $taskModel->getTaskForEdit($id);
        if (count($data['task']) === 0) {
            $_SESSION['alertWarning'] = "Задача с таким ID не найдена!";
            $data['uri']->redirect($data['router']->getBaseUrl(), 302);
        }
        
        if ($data['router']->server['REQUEST_METHOD'] === "POST") {
            $res = $taskModel->validateEditTask(
                    $gump,
                    $data['router']->post);
            if($res === false) {
                    $data['errors'] = HelperValidation::resolveErrorMessages(
                            $gump->get_errors_array(),
                            [
                                '%Email' => "\"Email адрес\"",
                                '%Task' => "\"Задача\"",
                                '%Username' => "\"Имя пользователя\"",
                            ]);
            } else {
                $res = $taskModel->updateTask($data['router'], $data['task']);
                if ($res === 0) {
                    $_SESSION['alertWarning'] = "Задача не сохранена, что-то пошло не так!";
                } else {
                    $_SESSION['alertSuccess'] = "Задача с ID " . $data['task']['id'] . " успешно сохранена!";
                }
                $data['uri']->redirect($data['router']->getFullUrl(), 302);
            }        
        }
        
        $data['alerts'] = $this->alerts;
        
        echo $tmpl->render('tasks/edit/edit_task', $data);        
    }
    
}
