<?php

namespace App\Controllers;

use App\Core\QueryBuilder;

class ProductsController extends Controller
{
    public function index()
    {
        $perPage = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        $totalProducts = QueryBuilder::table('products')->get();
        $totalPages = ceil(count($totalProducts) / $perPage);

        $products = QueryBuilder::table('products')->raw(
            "SELECT products.*, product_category.name AS category_name
         FROM products
         LEFT JOIN product_category
         ON products.category_id = product_category.id
         LIMIT $perPage OFFSET $offset"
        );
        $this->view('products/index', [
            'products' => $products,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }

    public function show($id)
    {
        $product = QueryBuilder::table('products')->raw(
            "SELECT products.*, product_category.name AS category_name
     FROM products
     LEFT JOIN product_category
     ON products.category_id = product_category.id
     WHERE products.id = $id
     LIMIT 1"
        );

        $product = $product[0] ?? null;

        $this->view('products/show', [
            'product' => $product
        ]);
    }

    public function create()
    {
        $categories = QueryBuilder::table('product_category')->get();

        $this->view('products/create', [
            'categories' => $categories
        ]);
    }



    public function delete($id)
    {
        QueryBuilder::table(table: "products")
            ->where("id", $id)
            ->delete();
        $page = $_REQUEST['page'] ?? 1;
        $productImg = $_POST["image"] ?? null;
        $uploadDir = __DIR__ . '/../../public/assets/images/products/';

        if ($productImg && file_exists($uploadDir . $productImg)) {
            unlink($uploadDir . $productImg);
        }

        redirect("/products?page=" . $page);
    }

    public function store()
    {
        session_start();
        $errors = [];

        $name = trim($_POST['name']);
        $price = $_POST['price'];
        $category = $_POST['category_id'];
        $image = $_FILES['image'] ?? null;

        if (!$name) {
            $errors['name'] = "Name is required";
        }

        if (strlen($name) < 3) {
            $errors['name'] = "Name must be at least 3 characters";
        }

        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors['name'] = "Name can only contain letters and spaces";
        }

        $existing = QueryBuilder::table('products')->where('name', $name)->first();
        if ($existing) {
            $errors['name'] = "Product name already exists";
        }


        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = "Price must be a valid positive number";
        }

        if (!$category) {
            $errors['category'] = "Category is required";
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($image['type'], $allowedTypes)) {
            $errors['image'] = "Invalid image type. Allowed: JPG, PNG, GIF, WEBP";
        }

        $maxSize = 2 * 1024 * 1024;
        if ($image['size'] > $maxSize) {
            $errors['image'] = "Image size must be less than 2MB";
        }


        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            redirect('/products/create');
        } else {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileNameArray = explode('.', $_FILES['image']['name']);
            $extension = strtolower($fileNameArray[count($fileNameArray) - 1]);
            $uploadDir = __DIR__ . '/../../public/assets/images/products/';
            $destPath = $uploadDir . $name . '.' . $extension;
            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                $errors['image'] = $_FILES['image']['error'];
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;

                redirect('/products/create');
            } else {
                QueryBuilder::table('products')->insert([
                    'name' => $name,
                    'price' => $price,
                    'category_id' => $category,
                    'image' => $name . '.' . $extension
                ]);
                redirect('/products');
            }
        }
    }

    public function edit($id)
    {
        $categories = QueryBuilder::table('product_category')->get();
        $product = QueryBuilder::table('products')->raw(
            "SELECT products.*, product_category.name AS category_name
        FROM products
        LEFT JOIN product_category
        ON products.category_id = product_category.id
        WHERE products.id = $id
        LIMIT 1"
        );
        $product = $product[0] ?? null;

        $this->view('products/edit', [
            'categories' => $categories,
            'product' => $product
        ]);
    }

    public function toggle($id): void
    {
        $product = QueryBuilder::table(table: 'products')->where('id', $id)->first();

        if ($product) {
            $newValue = $product['is_available'] ? 0 : 1;

            QueryBuilder::table('products')
                ->where('id', $id)
                ->update([
                    'is_available' => $newValue
                ]);
        }

        $page = $_REQUEST['page'] ?? 1;
        redirect("/products?page=" . $page);
    }

    public function update($id)
    {
        session_start();
        $errors = [];

        $productImg = $_POST["productImg"] ?? null;
        $name = trim($_POST['name']);
        $price = $_POST['price'];
        $category = $_POST['category_id'];
        $image = $_FILES['image'] ?? null;

        if (!$name) {
            $errors['name'] = "Name is required";
        }

        if (strlen($name) < 3) {
            $errors['name'] = "Name must be at least 3 characters";
        }

        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors['name'] = "Name can only contain letters and spaces";
        }

        $existing = QueryBuilder::table('products')->where('name', $name)->first();
        if ($existing && $existing['id'] != $id) {
            $errors['name'] = "Product name already exists";
        }


        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = "Price must be a valid positive number";
        }

        if (!$category) {
            $errors['category'] = "Category is required";
        }


        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (isset($image) && !empty($image['tmp_name']) && !in_array($image['type'], $allowedTypes)) {
            $errors['image'] = "Invalid image type. Allowed: JPG, PNG, GIF, WEBP";
        }

        $maxSize = 2 * 1024 * 1024;
        if ($image && $image['size'] > $maxSize) {
            $errors['image'] = "Image size must be less than 2MB";
        }


        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            redirect('/products/edit/' . $id);
        } else {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileNameArray = explode('.', $_FILES['image']['name']);
            $extension = strtolower($fileNameArray[count($fileNameArray) - 1]);
            $uploadDir = __DIR__ . '/../../public/assets/images/products/';
            $destPath = $uploadDir . $name . '.' . $extension;
            if (isset($image) && !empty($image['tmp_name']) && $productImg && file_exists($uploadDir . $productImg)) {
                unlink($uploadDir . $productImg);
            }
            if (isset($image) && !empty($image['tmp_name']) && !move_uploaded_file($fileTmpPath, $destPath)) {
                $errors['image'] = $_FILES['image']['error'];
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;

                redirect('/products/edit/' . $id);
            } else {

                if (isset($image) && !empty($image['tmp_name'])) {
                    QueryBuilder::table('products')
                        ->where('id', $id)
                        ->update([
                            'name' => $name,
                            'price' => $price,
                            'category_id' => $category,
                            'image' => $name . '.' . $extension
                        ]);
                } else {
                    QueryBuilder::table('products')
                        ->where('id', $id)
                        ->update([
                            'name' => $name,
                            'price' => $price,
                            'category_id' => $category,
                        ]);
                }
                redirect('/products/show/' . $id);
            }
        }
    }
}
