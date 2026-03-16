<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\QueryBuilder;
use App\Core\Validator;


class OrderController extends Controller
{

    public function __construct()
    {
        if (!Auth::isAuth('admin') && !Auth::isAuth('user')) {
            redirect('/home/guest');
        }
    }

    public function index()
    {

        $authUser = Auth::currentUser('user');


        $userId = $authUser["id"];

        $data = $this->orderPageData($userId, "/Order/index");

        $this->view("Order/User/index", $data);
    }

    public function admin()
    {


        $user = Auth::currentUser('admin');

        if ($user["role"] != "admin") {
            redirect("/Order/index");
        }



        $userId = $_GET["user"] ?? null;

        $data = $this->orderPageData($userId, "/Order/admin");

        $data["users"] = QueryBuilder::table("users")->where("role", "user")->get();

        $this->view("Order/Admin/index", $data);
    }

    private function orderPageData($userId, $currentPagePath)
    {
        $authUser = Auth::currentUser();

        $products = $this->getProducts();
        $rooms = $this->getRooms();
        $latestOrder = $this->getLatestOrder($userId);

        $cart = $_SESSION["cart"] ?? [];

        $total = $this->calculateCartTotal($cart);
        $redirectTo = $this->buildRedirectTarget($currentPagePath, $userId);

        return [
            "latestOrder" => $latestOrder,
            "products" => $products,
            "rooms" => $rooms,
            "cart" => $cart,
            "total" => $total,
            "authUser" => $authUser,
            "currentPagePath" => $currentPagePath,
            "selectedUserId" => $userId,
            "redirectTo" => $redirectTo
        ];
    }

    private function buildRedirectTarget($path, $userId)
    {
        if ($path === "/Order/admin" && $userId) {
            return $path . "?" . http_build_query(["user" => $userId]);
        }

        return $path;
    }

    private function getProducts()
    {
        $search = $_GET["search"] ?? null;

        if ($search) {
            return QueryBuilder::table("products")->raw(
                "SELECT products.*, product_category.name AS category_name
             FROM products
             JOIN product_category ON products.category_id = product_category.id
             WHERE (products.name LIKE ? OR product_category.name LIKE ?)
             AND products.is_available = 1",
                ["%$search%", "%$search%"]
            );
        }

        return QueryBuilder::table("products")->raw(
            "SELECT products.*, product_category.name AS category_name
         FROM products
         JOIN product_category ON products.category_id = product_category.id
         WHERE products.is_available = 1"
        );
    }

    private function getRooms()
    {
        return QueryBuilder::table("rooms")->get();
    }

    private function getLatestOrder($userId)
    {
        if (!$userId) {
            return [];
        }

        $latestOrder = QueryBuilder::table("orders")->raw(
            "SELECT *
         FROM orders
         WHERE user_id = ?
         ORDER BY created_at DESC
         LIMIT 1",
            [$userId]
        );

        if (!$latestOrder) {
            return [];
        }

        $orderId = $latestOrder[0]["id"];
        return QueryBuilder::table("order_item")->raw(
            "SELECT oi.*, p.name, p.image, o.status
         FROM order_item oi
         JOIN products p ON p.id = oi.product_id
         JOIN orders o ON o.id = oi.order_id
         WHERE oi.order_id = ?",
            [$orderId]
        );
    }

    private function calculateCartTotal($cart)
    {
        $total = 0;

        foreach ($cart as $product) {
            $total += $product["price"] * $product["quantity"];
        }

        return $total;
    }

    public function addToCart()
    {

        $productId = $_POST["product_id"];
        $quantity  = $_POST["quantity"] ?? null;

        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }

        if (!isset($_SESSION["cart"][$productId])) {

            $product = QueryBuilder::table("products")
                ->where("id", $productId)
                ->first();
            if (!$product) {
                $validator = new Validator([]);
                $validator->addError('product', 'Product not found');

                $_SESSION['errors'] = $validator->errors();
                redirect($this->redirectTarget());
            }

            $_SESSION["cart"][$productId] = [
                "id" => $product["id"],
                "name" => $product["name"],
                "image" => $product["image"],
                "price" => $product["price"],
                "quantity" => 0
            ];
        }

        if ($quantity !== null) {
            $_SESSION["cart"][$productId]["quantity"] = max(1, (int)$quantity);
        } else {
            $_SESSION["cart"][$productId]["quantity"]++;
        }

        redirect($this->redirectTarget());
    }

    public function store()
    {
        $validator = new Validator($_POST);

        $validator->validate([
            'room' => ['required', 'numeric'],
        ]);

        $cart = $_SESSION["cart"] ?? [];

        if (empty($cart)) {
            $validator->addError('cart', 'Cart is empty.');
        }

        $authUser = Auth::currentUser('admin') ?: Auth::currentUser('user');


        if (!$authUser) {
            $validator->addError('user', 'User not found.');
        }


        if ($authUser && $authUser["role"] === "admin") {

            if (empty($_POST["user_id"])) {
                $validator->addError('user', 'Please select a user.');
            }

            $userId = $_POST["user_id"] ?? null;
        } else {

            $userId = $authUser["id"] ?? null;
        }

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            redirect($this->redirectTarget());
        }

        $data = $validator->validated();

        $totalPrice = $this->calculateCartTotal($cart);

        QueryBuilder::table("orders")->insert([
            "user_id" => $userId,
            "room_id" => $data["room"],
            "notes" => $_POST["notes"] ?? null,
            "total_price" => $totalPrice
        ]);

        $orderId = QueryBuilder::table("orders")->lastInsertedId();

        if ($orderId) {

            $values = [];
            $placeholders = [];

            foreach ($cart as $item) {

                $placeholders[] = "(?,?,?,?)";

                array_push(
                    $values,
                    $orderId,
                    $item["id"],
                    $item["quantity"],
                    $item["price"]
                );
            }

            $sql = "INSERT INTO order_item(order_id,product_id,quantity,price) VALUES "
                . implode(",", $placeholders);

            QueryBuilder::table("order_item")->raw($sql, $values);
        }

        unset($_SESSION["cart"]);

        $_SESSION['success'] = "Order submitted successfully.";

        redirect($this->redirectTarget());
    }

    public function remove()
    {
        $productId = $_POST["product_id"];

        unset($_SESSION["cart"][$productId]);

        redirect($this->redirectTarget());
    }

    private function redirectTarget()
    {
        return $_POST["redirect_to"] ?? "/Order";
    }
}
