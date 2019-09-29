<?php

namespace app\models;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

use \system\MModel,
        \app\config\Config;

/**
 * Model for authorization
 */
class Auth extends MModel {

    public function validateLogin(\GUMP $gump, array $post) {
        $res = $gump->validation_rules([
            'username' => 'required',
            'password' => 'required|valid_password',
        ]);

        $gump::add_validator("valid_password",
                function($field, $input, $param = NULL) use ($post){
                    if ($post[$field] === Config::$auth['password']
                            && $post['username'] === Config::$auth['username']
                    ) {
                        return true;
                    }
                    return false;
                },
                "Ошибка в имени пользователя или пароле.");

        \GUMP::set_error_messages([
            'validate_required' => 'Поле %{field} обязательно для заполнения.',
        ]);

        return $gump->run($post);
    }

}
