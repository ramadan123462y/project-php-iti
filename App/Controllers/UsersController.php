<?php

namespace App\Controllers;


use App\Core\QueryBuilder;

class UsersController extends Controller
{

    public function index()
    {
        $users = QueryBuilder::table("users")->get();

        $this->view("users/index", [
            "users" => $users
        ]);
    }


    public function show($id)
    {
        $user = QueryBuilder::table("users")
            ->where("id", $id)
            ->first();

        $this->view("users/show", [
            "user" => $user
        ]);
    }
    public function store()
    {
       QueryBuilder::table("users")->insert([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'room_id' => $_POST['room_id'],
            'ext' => $_POST['ext'],
            'role' => $_POST['role']
        ]);

        redirect('/users');
    }
    public function create()
    {
        $this->view("users/create");
    }

    public function edit($id)
    {
        $user = QueryBuilder::table("users")
            ->where("id", $id)
            ->first();
            

        $this->view("users/edit", [
            "user" => $user
        ]);
    }

    public function update($id)
    {
        QueryBuilder::table("users")
            ->where("id", $id)
            ->update([
                "name" => $_POST["name"],
                "email" => $_POST["email"],
                "room_id" => $_POST["room_id"],
                "ext" => $_POST["ext"],
                "role" => $_POST["role"]
            ]);

        redirect("/users");
    }

    public function delete($id)
    {
        QueryBuilder::table("users")
            ->where("id", $id)
            ->delete();

        redirect("/users");
    }
}
