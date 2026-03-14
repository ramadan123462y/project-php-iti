<?php

namespace App\Controllers;

use App\Core\QueryBuilder;

class CategoriesController extends Controller
{
    public function index()
    {
        $perPage = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        $totalCategories = QueryBuilder::table('product_category')->get();
        $totalPages = ceil(count($totalCategories) / $perPage);

        $categories = QueryBuilder::table('product_category')->raw(
            "SELECT id, product_category.name AS name
         FROM product_category
         LIMIT $perPage OFFSET $offset"
        );
        $this->view('categories/index', [
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function show($id)
    {
        $category = QueryBuilder::table('product_category')->raw(
            "SELECT id, name
FROM product_category
WHERE id = $id
LIMIT 1"
        );

        $category = $category[0] ?? null;

        $this->view('categories/show', [
            'category' => $category
        ]);
    }

    public function create(): void
    {
        $this->view('categories/create');
    }



    public function delete($id)
    {
        QueryBuilder::table(table: "product_category")
            ->where("id", $id)
            ->delete();
        $page = $_REQUEST['page'] ?? 1;
        redirect("/categories?page=" . $page);
    }

    public function store()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $errors = [];

        $name = trim($_POST['name']);

        if (!$name) {
            $errors['name'] = "Name is required";
        }

        if (strlen($name) < 3) {
            $errors['name'] = "Name must be at least 3 characters";
        }

        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors['name'] = "Name can only contain letters and spaces";
        }

        $existing = QueryBuilder::table('product_category')->where('name', $name)->first();
        if ($existing) {
            $errors['name'] = "Category name already exists";
        }


        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            redirect('/categories/create');
        } else {
            QueryBuilder::table('product_category')->insert([
                'name' => $name,
            ]);
            redirect('/categories');
        }
    }

    public function edit($id)
    {
        $category = QueryBuilder::table('product_category')->raw(
            "SELECT id, name
            FROM product_category
            WHERE id = $id
            LIMIT 1"
        );

        $category = $category[0] ?? null;


        $this->view('categories/edit', [
            'category' => $category,
        ]);
    }


    public function update($id)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $errors = [];

        $name = trim($_POST['name']);

        if (!$name) {
            $errors['name'] = "Name is required";
        }

        if (strlen($name) < 3) {
            $errors['name'] = "Name must be at least 3 characters";
        }

        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors['name'] = "Name can only contain letters and spaces";
        }

        $existing = QueryBuilder::table('product_category')->where('name', $name)->first();
        if ($existing && $existing['id'] != $id) {
            $errors['name'] = "Category name already exists";
        }



        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            redirect('/categories/edit/' . $id);
        } else {

            QueryBuilder::table('product_category')
                ->where('id', $id)
                ->update([
                    'name' => $name,
                ]);
            redirect('/categories/show/' . $id);
        }
    }
}
