<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\QueryBuilder;
use App\Core\Request;

class AuthUserController extends Controller
{
    public function index()
    {
        $this->view('/user-login');
    }
    public function login()
    {
        $request = Request::all();

        if (empty($request->email)) {
            pushError('email', 'Email is required');
        }

        if (empty($request->password)) {
            pushError('password', 'Password is required');
        }

        if (empty($request->role)) {
            pushError('role', 'Role is required');
        }

        if (hasErrors()) {
            redirect("/authuser/index");
        }

        $user = QueryBuilder::table('users')
            ->where('email', $request->email)
            ->where('role', $request->role)
            ->first();

        if (!$user || $request->password != $user['password']) {
            pushError('login', 'Invalid credentials');
            redirect("/authuser/index");
        }

        Auth::login($user, $request->role);

        echo "Login successful!";
    }
}
