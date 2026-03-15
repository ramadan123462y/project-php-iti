<?php

namespace App\Core;

class Auth
{
    public static function login(array $user, $role = "user"): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION[$role] = $user;
    }

    public static function logout($role = "user"): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION[$role])) {
            unset($_SESSION[$role]);
        }
    }

    public static function currentUser($role = "user"): ?array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION[$role])) {
            return null;
        }

        $user = $_SESSION[$role];
        return $user;
    }
    public static function isAuth($role = "user"): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return isset($_SESSION[$role]);
    }

    public static function validateIsAdmin()
    {
        if (!Auth::isAuth('admin')) {

            redirect('/home/guest');
        }
    }

    public static function validateIsUser()
    {
        if (!Auth::isAuth('user')) {

            redirect('/home/guest');
        }
    }
}
