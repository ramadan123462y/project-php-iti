<?php

namespace App\Controllers;

use App\Core\QueryBuilder;
use App\Core\Auth;


class UsersController extends Controller
{
    public function __construct()
{
    if (!Auth::isAuth('admin')) {
        redirect('/authUser');
        exit;
    }
}
    private function getRooms()
    {
        return QueryBuilder::table("rooms")->get();
    }

    private function findUser($id)
    {
        return QueryBuilder::table("users")->where("id", $id)->first();
    }

    private function deleteImage($image)
    {
        if (!$image) return;

        $path = __DIR__ . '/../../public/assets/images/users/' . $image;

        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function index()
    {
        $allUsers = QueryBuilder::table("users")->get();

        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $page = max($page, 1);

        $perPage = 5;
        $totalUsers = count($allUsers);
        $totalPages = (int) ceil($totalUsers / $perPage);

        $offset = ($page - 1) * $perPage;
        $users = array_slice($allUsers, $offset, $perPage);

        $this->view("users/index", [
            "users" => $users,
            "page" => $page,
            "totalPages" => $totalPages
        ]);
    }
    public function show($id)
    {
        $this->view("users/show", [
            "user" => $this->findUser($id)
        ]);
    }

    public function create()
    {
        $this->view("users/create", [
            "errors" => [],
            "old" => [],
            "rooms" => $this->getRooms()
        ]);
    }

    public function store()
    {
        $errors = $this->validateUser();

        if ($errors) {
            $this->view("users/create", [
                "errors" => $errors,
                "old" => $_POST,
                "rooms" => $this->getRooms()
            ]);
            return;
        }

        $image = $this->uploadImage();
        $role = trim($_POST["role"]);

        QueryBuilder::table("users")->insert([
            "name" => trim($_POST["name"]),
            "email" => trim($_POST["email"]),
            "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
            "room_id" => $role === "admin" ? null : trim($_POST["room_id"]),
            "ext" => trim($_POST["ext"]),
            "role" => $role,
            "image" => $image
        ]);

        redirect("/users");
    }

    public function edit($id)
    {
        $user = $this->findUser($id);

        if (!$user) {
            die("User not found");
        }

        $this->view("users/edit", [
            "user" => $user,
            "errors" => [],
            "rooms" => $this->getRooms()
        ]);
    }

    public function update($id)
    {
        $user = $this->findUser($id);

        if (!$user) {
            die("User not found");
        }

        $errors = $this->validateUser(true, $id);

        if ($errors) {
            $this->view("users/edit", [
                "user" => array_merge($user, $_POST),
                "errors" => $errors,
                "rooms" => $this->getRooms()
            ]);
            return;
        }

        $role = trim($_POST["role"]);

        $data = [
            "name" => trim($_POST["name"]),
            "email" => trim($_POST["email"]),
            "room_id" => $role === "admin" ? null : trim($_POST["room_id"]),
            "ext" => trim($_POST["ext"]),
            "role" => $role
        ];

        if (!empty($_POST["password"])) {
            $data["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
        }

        $image = $this->uploadImage();

        if ($image) {
            $this->deleteImage($user["image"] ?? null);
            $data["image"] = $image;
        }

        QueryBuilder::table("users")->where("id", $id)->update($data);

        redirect("/users");
    }

    public function delete($id)
    {
        $user = $this->findUser($id);

        if ($user) {
            $this->deleteImage($user["image"] ?? null);
            QueryBuilder::table("users")->where("id", $id)->delete();
        }

        redirect("/users");
    }

    private function validateUser($isUpdate = false, $userId = null)
    {
        $errors = [];

        $name = trim($_POST["name"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $password = $_POST["password"] ?? "";
        $confirmPassword = $_POST["confirm_password"] ?? "";
        $roomId = trim($_POST["room_id"] ?? "");
        $ext = trim($_POST["ext"] ?? "");
        $role = trim($_POST["role"] ?? "");

        if ($name === "") {
            $errors["name"] = "Name is required.";
        } elseif (strlen($name) < 3) {
            $errors["name"] = "Name must be at least 3 characters.";
        }

        if ($email === "") {
            $errors["email"] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Invalid email format.";
        } else {
            $user = QueryBuilder::table("users")->where("email", $email)->first();
            if ($user && (!$userId || $user["id"] != $userId)) {
                $errors["email"] = "Email already exists.";
            }
        }

        if (!$isUpdate || $password !== "" || $confirmPassword !== "") {
            if ($password === "") {
                $errors["password"] = "Password is required.";
            } elseif (strlen($password) < 6) {
                $errors["password"] = "Password must be at least 6 characters.";
            }

            if ($confirmPassword === "") {
                $errors["confirm_password"] = "Confirm password is required.";
            } elseif ($password !== $confirmPassword) {
                $errors["confirm_password"] = "Passwords do not match.";
            }
        }

        if ($role === "") {
            $errors["role"] = "Role is required.";
        } elseif (!in_array($role, ["admin", "user"])) {
            $errors["role"] = "Invalid role.";
        }

        if ($role === "admin") {
            if ($roomId !== "") {
                $errors["room_id"] = "Room assignment is not allowed for admin users.";
            }
        } elseif ($role === "user") {
            if ($roomId === "") {
                $errors["room_id"] = "User must assign to a room.";
            } elseif (!QueryBuilder::table("rooms")->where("id", $roomId)->first()) {
                $errors["room_id"] = "Selected room does not exist.";
            }
        }

        if ($ext === "") {
            $errors["ext"] = "Extension is required.";
        } elseif (!preg_match('/^[0-9]{1,10}$/', $ext)) {
            $errors["ext"] = "Extension must be numbers only.";
        }

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] !== 4) {
            $allowedExt = ["jpg", "jpeg", "png", "webp"];
            $allowedMime = ["image/jpeg", "image/png", "image/webp"];

            if ($_FILES["image"]["error"] !== 0) {
                $errors["image"] = "Image upload failed.";
            } else {
                $extName = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                $mime = mime_content_type($_FILES["image"]["tmp_name"]);
                $size = $_FILES["image"]["size"];

                if (!in_array($extName, $allowedExt)) {
                    $errors["image"] = "Allowed image types: jpg, jpeg, png, webp.";
                } elseif (!in_array($mime, $allowedMime)) {
                    $errors["image"] = "Invalid image file.";
                } elseif ($size > 2 * 1024 * 1024) {
                    $errors["image"] = "Image must be less than 2MB.";
                }
            }
        }

        return $errors;
    }

    private function uploadImage()
    {
        if (!isset($_FILES["image"]) || $_FILES["image"]["error"] === 4) {
            return null;
        }

        if ($_FILES["image"]["error"] !== 0) {
            return null;
        }

        $imageName = time() . '_' . preg_replace('/\s+/', '_', basename($_FILES["image"]["name"]));
        $path = __DIR__ . '/../../public/assets/images/users/' . $imageName;

        move_uploaded_file($_FILES["image"]["tmp_name"], $path);

        return $imageName;
    }
}
