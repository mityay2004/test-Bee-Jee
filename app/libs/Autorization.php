<?php

namespace app\libs;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

use \app\libs\Security,
    \system\Router,
    \app\config\Config;

class Autorization {

    const TIME_TO_LIVE = 60 * 60 * 2;
    const NAME_AUTH_COOKIE = "auth";

    private $security,
            $isAuthorized;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public function login(string $username, string $password) {
        $newCookie = $this->security->encrypt($username . $password);
        setcookie(self::NAME_AUTH_COOKIE, $newCookie, time() + self::TIME_TO_LIVE);
        $this->isAuthorized = true;
    }

    public function logout() {
        setcookie(self::NAME_AUTH_COOKIE, "", time() - 3600);
        $this->isAuthorized = false;
    }

    public function init(Router $router) {
        if (!isset($router->cookies[self::NAME_AUTH_COOKIE])) {
            $this->isAuthorized = false;
            return;
        }
        $cookie = $router->cookies[self::NAME_AUTH_COOKIE];
        if (md5(Config::$auth['username'] . Config::$auth['password']) !== $cookie) {
            $this->isAuthorized = false;
            return;
        }
        $this->isAuthorized = true;
    }
    
    public function isAuthorized()
    {
        return $this->isAuthorized;
    }

}
