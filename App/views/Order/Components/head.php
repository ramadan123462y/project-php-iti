<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Cafe Ordering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --cafe-primary: #1a4d2e;
            --cafe-secondary: #e8dfca;
        }

        body {
            background-color: #fcfaf5;
        }

        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }

        .card-drink {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: #fff;
        }

        .card-drink:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        .sticky-sidebar {
            position: sticky;
            top: 20px;
        }

        .btn-confirm {
            background-color: var(--cafe-primary);
            color: white;
            border-radius: 8px;
        }

        .btn-confirm:hover {
            background-color: #143a22;
            color: white;
        }

        .badge-price {
            background-color: #6f4e37;
        }
    </style>
</head>