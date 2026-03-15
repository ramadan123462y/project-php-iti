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

        $from    = isset($request->from)  && $request->from  !== '' ? (string)$request->from  : null;
        $to      = isset($request->to)    && $request->to    !== '' ? (string)$request->to    : null;
        $user    = isset($request->user)  && $request->user  !== '' ? (int)$request->user     : null;
        $page    = max(1, (int)($request->page ?? 1));
        $perPage = 3;

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

        $sql .= " ORDER BY users.id, orders.id";

        $qb     = QueryBuilder::table("orders");
        $checks = $qb->raw($sql, $bindings);

        $allUsers = $this->groupByUsers($checks);

        $totalUsers = count($allUsers);
        $totalPages = max(1, (int)ceil($totalUsers / $perPage));
        $page       = min($page, $totalPages);
        $offset     = ($page - 1) * $perPage;

        $users = array_slice($allUsers, $offset, $perPage, true);

        $usersList = QueryBuilder::table("users")
            ->select(["id", "name"])
            ->where("role", "user")
            ->get();

        $filterParams = array_filter([
            'from' => $from,
            'to'   => $to,
            'user' => $user,
        ], fn($v) => $v !== null && $v !== '');

        $buildPageUrl = fn(int $p) => '?' . http_build_query(array_merge($filterParams, ['page' => $p]));

        $this->view("admin/checks", compact(
            "users", "usersList",
            "from", "to", "user",
            "page", "totalPages", "totalUsers",
            "buildPageUrl"
        ));
    }

    private function groupByUsers(array $checks): array
    {
        $users = [];

        foreach ($checks as $row) {
            $userId  = $row['user_id'];
            $orderId = $row['order_id'];

            if (!isset($users[$userId])) {
                $users[$userId] = [
                    'name'   => $row['user_name'],
                    'orders' => []
                ];
            }

            if (!isset($users[$userId]['orders'][$orderId])) {
                $users[$userId]['orders'][$orderId] = [
                    'date'     => $row['created_at'],
                    'total'    => $row['total_price'],
                    'products' => []
                ];
            }

            $users[$userId]['orders'][$orderId]['products'][] = [
                'name'     => $row['product_name'],
                'price'    => $row['price'],
                'quantity' => $row['quantity'],
                'image'    => $row['product_image']
            ];
        }

        return $users;
    }
}