<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\QueryBuilder;


class OrdersController extends Controller
{

    public function __construct()
    {
        if (!Auth::isAuth('admin') && !Auth::isAuth('user')) {
            redirect('/home/guest');
        }
    }

    private function requireAuth($role = 'user')
    {
        $currentUser = Auth::currentUser('user') ?? Auth::currentUser('admin');

        if (!$currentUser) {
            redirect("authuser/index");
            return null;
        }

        if ($role === 'admin' && $currentUser['role'] !== 'admin') {
            $_SESSION['error'] = "Admin access required!";
            redirect("orders");
            return null;
        }

        return $currentUser;
    }

    private function checkOrderOwnership($order, $currentUser)
    {
        if ($order['user_id'] !== $currentUser['id'] && $currentUser['role'] !== 'admin') {
            $_SESSION['error'] = "Access denied! You can only access your own orders.";
            redirect("orders");
            return false;
        }
        return true;
    }

    public function index()
    {
        $currentUser = $this->requireAuth();
        if (!$currentUser) return;

        $userId = $currentUser['id'] ?? null;
        $userRole = $currentUser['role'] ?? 'user';

        $status = $_GET['status'] ?? null;
        $dateFrom = $_GET['date_from'] ?? null;
        $dateTo = $_GET['date_to'] ?? null;


        if ($userRole === 'admin') {
            return $this->adminIndex();
        } else {
            $orders = QueryBuilder::table("orders")->where("user_id", $userId)->get();
        }

        if ($status || $dateFrom || $dateTo) {
            $orders = array_filter($orders, function ($order) use ($status, $dateFrom, $dateTo) {
                $match = true;
                if ($status && $order['status'] !== $status) $match = false;
                if ($dateFrom && $order['created_at'] < ($dateFrom . " 00:00:00")) $match = false;
                if ($dateTo && $order['created_at'] > ($dateTo . " 23:59:59")) $match = false;
                return $match;
            });
        }

        if (!is_array($orders)) $orders = [];

        foreach ($orders as &$order) {
            $order['items'] = QueryBuilder::table("order_item")->where("order_id", $order['id'])->get();
            foreach ($order['items'] as &$item) {
                $product = QueryBuilder::table("products")->where("id", $item['product_id'])->first();
                $item['product_name'] = $product['name'] ?? 'Unknown';
                $item['product_image'] = $product['image'] ?? null;
            }
            $room = QueryBuilder::table("rooms")->where("id", $order['room_id'])->first();
            $order['room_name'] = $room['name'] ?? 'N/A';
        }

        $this->view("orders/index", [
            "orders" => $orders,
            "filters" => ["status" => $status, "date_from" => $dateFrom, "date_to" => $dateTo]
        ]);
    }

    public function adminIndex()
    {
        $currentUser = $this->requireAuth('admin');
        if (!$currentUser) return;
        $status = $_GET['status'] ?? null;
        $dateFrom = $_GET['date_from'] ?? null;
        $dateTo = $_GET['date_to'] ?? null;

        $orders = QueryBuilder::table("orders")->get();

        if ($status || $dateFrom || $dateTo) {
            $orders = array_filter($orders, function ($order) use ($status, $dateFrom, $dateTo) {
                $match = true;
                if ($status && $order['status'] !== $status) $match = false;
                if ($dateFrom && $order['created_at'] < ($dateFrom . " 00:00:00")) $match = false;
                if ($dateTo && $order['created_at'] > ($dateTo . " 23:59:59")) $match = false;
                return $match;
            });
        }

        if (!is_array($orders)) $orders = [];

        foreach ($orders as &$order) {
            $order['items'] = QueryBuilder::table("order_item")->where("order_id", $order['id'])->get();
            foreach ($order['items'] as &$item) {
                $product = QueryBuilder::table("products")->where("id", $item['product_id'])->first();
                $item['product_name'] = $product['name'] ?? 'Unknown';
            }
            $user = QueryBuilder::table("users")->where("id", $order['user_id'])->first();
            $order['user_name'] = $user['name'] ?? 'Unknown';
            $room = QueryBuilder::table("rooms")->where("id", $order['room_id'])->first();
            $order['room_name'] = $room['name'] ?? 'N/A';
        }

        $this->view("orders/admin_index", [
            "orders" => $orders,
            "filters" => ["status" => $status, "date_from" => $dateFrom, "date_to" => $dateTo]
        ]);
    }

    public function show($id)
    {
        $currentUser = $this->requireAuth();
        if (!$currentUser) return;

        $order = QueryBuilder::table("orders")
            ->where("id", $id)
            ->first();

        if (!empty($order)) {
            if (!$this->checkOrderOwnership($order, $currentUser)) return;

            $order['items'] = QueryBuilder::table("order_item")
                ->where("order_id", $id)
                ->get();

            foreach ($order['items'] as &$item) {
                $product = QueryBuilder::table("products")->where("id", $item['product_id'])->first();
                $item['product_name'] = $product['name'] ?? 'Unknown';
                $item['product_image'] = $product['image'] ?? null;
            }

            $room = QueryBuilder::table("rooms")->where("id", $order['room_id'])->first();
            $order['room_name'] = $room['name'] ?? 'N/A';
            $order['room_number'] = $room['room_number'] ?? '';
        }

        $this->view("orders/show", [
            "order" => $order
        ]);
    }

    public function adminShow($id)
    {
        $currentUser = $this->requireAuth('admin');
        if (!$currentUser) return;

        $order = QueryBuilder::table("orders")
            ->where("id", $id)
            ->first();

        if (!empty($order)) {
            $order['items'] = QueryBuilder::table("order_item")
                ->where("order_id", $id)
                ->get();

            foreach ($order['items'] as &$item) {
                $product = QueryBuilder::table("products")->where("id", $item['product_id'])->first();
                $item['product_name'] = $product['name'] ?? 'Unknown';
                $item['product_image'] = $product['image'] ?? null;
            }

            // Get user info
            $user = QueryBuilder::table("users")->where("id", $order['user_id'])->first();
            $order['user_name'] = $user['name'] ?? 'Unknown';
            $order['user_email'] = $user['email'] ?? 'N/A';

            $room = QueryBuilder::table("rooms")->where("id", $order['room_id'])->first();
            $order['room_name'] = $room['name'] ?? 'N/A';
            $order['room_number'] = $room['room_number'] ?? '';
        }

        $this->view("orders/admin_show", [
            "order" => $order
        ]);
    }

    public function updateStatus($id)
    {
        $currentUser = $this->requireAuth('admin');
        if (!$currentUser) return;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? 'pending';
            QueryBuilder::table("orders")->where("id", $id)->update(["status" => $status]);
            $_SESSION['success'] = "Order status updated to " . ucfirst($status);
        }
        redirect("orders/adminShow/" . $id);
    }

    public function cancel($id)
    {
        $currentUser = $this->requireAuth();
        if (!$currentUser) return;

        $order = QueryBuilder::table("orders")->where("id", $id)->first();
        if (!$order || !$this->checkOrderOwnership($order, $currentUser)) return;

        QueryBuilder::table("orders")->where("id", $id)->update(["status" => "cancelled"]);
        $_SESSION['success'] = "Order #$id has been cancelled.";
        redirect("orders");
    }


    public function edit($id)
    {
        $currentUser = $this->requireAuth();
        if (!$currentUser) return;

        $order = QueryBuilder::table("orders")
            ->where("id", $id)
            ->first();

        if (!empty($order)) {
            if (!$this->checkOrderOwnership($order, $currentUser)) return;

            $order['items'] = QueryBuilder::table("order_item")
                ->where("order_id", $id)
                ->get();

            // For items, we might want to join with products to get names
            foreach ($order['items'] as &$item) {
                $product = QueryBuilder::table("products")->where("id", $item['product_id'])->first();
                $item['product_name'] = $product['name'] ?? 'Unknown';
            }
        }

        $rooms = QueryBuilder::table("rooms")->get();

        $this->view("orders/edit", [
            "order" => $order,
            "rooms" => $rooms
        ]);
    }

    public function update($id)
    {
        $currentUser = $this->requireAuth();
        if (!$currentUser) return;

        $order = QueryBuilder::table("orders")->where("id", $id)->first();
        if (!$order || !$this->checkOrderOwnership($order, $currentUser)) return;

        QueryBuilder::table("orders")
            ->where("id", $id)
            ->update([
                "status" => $_POST["status"],
                "room_id" => $_POST["room_id"],
                "notes" => $_POST["notes"]
            ]);

        redirect("/orders");
    }

    public function delete($id)
    {
        $currentUser = $this->requireAuth();
        if (!$currentUser) return;

        $order = QueryBuilder::table("orders")->where("id", $id)->first();
        if (!$order || !$this->checkOrderOwnership($order, $currentUser)) return;

        QueryBuilder::table("orders")
            ->where("id", $id)
            ->delete();

        $_SESSION['success'] = "Order #$id has been deleted.";
        redirect("/orders");
    }
}
