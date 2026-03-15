<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\QueryBuilder;
use App\Core\Request;

class CheckController extends Controller
{

    public function __construct()
    {

        if (!Auth::isAuth('admin')) {
          
            redirect('/home/guest');
            
        }
    }

    public function index()
    {

        $request = Request::all();

        $from = $request->from ?? null;
        $to = $request->to ?? null;
        $user = $request->user ?? null;

        $sql = "
            SELECT
                users.id as user_id,
                users.name as user_name,

                orders.id as order_id,
                orders.total_price,
                orders.created_at,

                products.name as product_name,
                products.image as product_image,

                order_item.quantity,
                order_item.price

            FROM orders
            JOIN users ON users.id = orders.user_id
            JOIN order_item ON order_item.order_id = orders.id
            JOIN products ON products.id = order_item.product_id
            WHERE 1=1
        ";

        $bindings = [];

        if ($from) {
            $sql .= " AND DATE(orders.created_at) >= ?";
            $bindings[] = $from;
        }

        if ($to) {
            $sql .= " AND DATE(orders.created_at) <= ?";
            $bindings[] = $to;
        }

        if ($user) {
            $sql .= " AND users.id = ?";
            $bindings[] = $user;
        }

        $sql .= " ORDER BY users.id , orders.id";

        $qb = QueryBuilder::table("orders");

        $checks = $qb->raw($sql, $bindings);

        $users = [];

        foreach ($checks as $row) {

            $userId = $row['user_id'];
            $orderId = $row['order_id'];

            if (!isset($users[$userId])) {
                $users[$userId] = [
                    'name' => $row['user_name'],
                    'orders' => []
                ];
            }

            if (!isset($users[$userId]['orders'][$orderId])) {
                $users[$userId]['orders'][$orderId] = [
                    'date' => $row['created_at'],
                    'total' => $row['total_price'],
                    'products' => []
                ];
            }

            $users[$userId]['orders'][$orderId]['products'][] = [
                'name' => $row['product_name'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'image' => $row['product_image']
            ];
        }

        $usersList = QueryBuilder::table("users")
            ->select(["id", "name"])
            ->where("role", "user")
            ->get();

        $this->view("admin/checks", compact("users", "usersList", "from", "to", "user"));
    }
}
