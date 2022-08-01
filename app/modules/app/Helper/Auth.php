<?php

namespace App\Helper;

use const yxorP\app\lib\lime\helper;

class auth extends \

helper
{

    public
    string $sessionKey = 'app.auth.user';

    public function authenticate(array $data): mixed
    {

        $data = array_merge([
            'user' => '',
            'email' => '',
            'password' => ''
        ], $data);

        if (!$data['password']) return false;

        $filter = ['active' => true];

        if ($data['email']) {
            $filter['email'] = $data['email'];
        } else {
            $filter['user'] = $data['user'];
        }

        $user = $this->app->dataStorage->findOne('system/users', $filter);

        if ($user && (password_verify($data['password'], $user['password']))) {

            $user = array_merge($data, (array)$user);

            unset($user['password']);

            $this->app->trigger('app.user.authenticate', [&$user]);

            return $user;
        }

        return false;
    }

    public function setUser(array $user, bool $permanent = true): void
    {

        if (isset($user['name'])) {
            $user['name_short'] = explode(' ', $user['name'])[0];
        }

        if ($permanent) {
            // prevent session fixation attacks
            $this->app->helper('session')->regenerateId(true);
            $this->app->helper('session')->write($this->sessionKey, $user);
        }

        $this->app->trigger('app.auth.setuser', [&$user, $permanent]);
        $this->app->set($this->sessionKey, $user);
    }

    public function logout(): void
    {

        $this->app->trigger('app.user.logout', [$this->getUser()]);
        $this->app->helper('session')->delete($this->sessionKey);
        $this->app->set($this->sessionKey, null);

        // prevent session fixation attacks
        $this->app->helper('session')->regenerateId(true);
    }

    public function getUser(?string $prop = null, mixed $default = null): mixed
    {

        $user = $this->app->retrieve($this->sessionKey);

        if (is_null($user)) {
            $user = $this->app->helper('session')->read($this->sessionKey, null);
        }

        if (!is_null($prop)) {
            return $user && isset($user[$prop]) ? $user[$prop] : $default;
        }

        return $user;
    }
}
