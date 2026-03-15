<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('welcome');
    }

    public function guest()
    {
        $this->view("guest");
    }
}
