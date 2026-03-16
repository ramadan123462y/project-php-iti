<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checks - Cafeteria</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #f5f4f0;
        }

        .page-title-row {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 1.5rem;
        }

        .page-title-icon {
            width: 38px;
            height: 38px;
            background: #c8622a;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        h2.fw-bold {
            font-size: 1.6rem;
            letter-spacing: -0.02em;
        }

        .filter-section label {
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b6860;
            margin-bottom: 0.35rem;
            display: block;
        }

        .filter-section .form-control,
        .filter-section .form-select {
            border: 1px solid #dedad2;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
            box-shadow: none;
        }

        .filter-section .form-control:focus,
        .filter-section .form-select:focus {
            border-color: #c8622a;
            box-shadow: 0 0 0 3px rgba(200, 98, 42, 0.12);
            outline: none;
        }

        .btn-filter-primary {
            background: #c8622a;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.15s;
        }

        .btn-filter-primary:hover { background: #a34e20; color: #fff; }

        .btn-filter-secondary {
            background: #fff;
            color: #6b6860;
            border: 1px solid #dedad2;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            font-size: 0.9rem;
            transition: border-color 0.15s, color 0.15s;
        }

        .btn-filter-secondary:hover {
            border-color: #1a1916;
            color: #1a1916;
        }

        .accordion-button {
            padding: 0.75rem 1rem;
            background-color: transparent;
            box-shadow: none;
            font-family: 'DM Sans', sans-serif;
        }

        .accordion-button:not(.collapsed) {
            background-color: #fdf8f5;
            box-shadow: none;
            color: #c8622a;
        }

        .accordion-button::after { display: none; }

        .accordion-button .chevron {
            font-size: 0.8rem;
            color: #aaa;
            transition: transform 0.2s;
            flex-shrink: 0;
        }

        .accordion-button:not(.collapsed) .chevron {
            transform: rotate(90deg);
            color: #c8622a;
        }

        .user-accordion-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f5ede6;
            color: #c8622a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.78rem;
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .user-name-text {
            flex: 1;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .amount-badge {
            background: #1a1916;
            color: #fff;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 0.22rem 0.65rem;
            border-radius: 20px;
        }

        .table {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
        }

        .table-secondary th {
            background: #ebe9e3;
            color: #6b6860;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            border-color: #dedad2;
        }

        .table-light th {
            background: #f5f3ee;
            color: #6b6860;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            border-color: #dedad2;
        }

        .table-bordered { border-color: #dedad2; }
        .table-bordered td, .table-bordered th { border-color: #dedad2; }

        .order-accordion-btn {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .order-date-text {
            flex: 1;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .order-date-text i { color: #c8622a; font-size: 0.82rem; }

        .order-amount-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6b6860;
        }

        .bg-light-custom { background-color: #f5f3ee; }

        .product-card {
            background: #fff;
            border: 1px solid #dedad2;
            border-radius: 10px;
            padding: 0.6rem 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: border-color 0.15s;
        }

        .product-card:hover { border-color: #c8622a; }

        .product-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .product-card-name {
            font-size: 0.83rem;
            font-weight: 600;
            color: #1a1916;
            line-height: 1.2;
        }

        .product-card-meta {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 0.15rem;
        }

        .product-price-tag {
            font-size: 0.75rem;
            font-weight: 700;
            color: #c8622a;
        }

        .product-qty-tag {
            font-size: 0.72rem;
            color: #8a8780;
            background: #f5f3ee;
            padding: 0.05rem 0.4rem;
            border-radius: 4px;
            border: 1px solid #dedad2;
        }

        .container.border {
            border-color: #dedad2 !important;
            border-radius: 12px;
            background: #fff;
        }

        .accordion-item {
            border: none;
            background: transparent;
        }

        /* pagination info */
        .pagination-info {
            font-size: 0.82rem;
            color: #6b6860;
        }

        .page-link {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem;
            color: #1a1916;
            border-color: #dedad2;
        }

        .page-link:hover {
            color: #c8622a;
            border-color: #c8622a;
            background: #fdf8f5;
        }

        .page-item.active .page-link {
            background-color: #c8622a;
            border-color: #c8622a;
            color: #fff;
        }

        .page-item.disabled .page-link {
            color: #ccc;
            border-color: #dedad2;
        }
    </style>
</head>

<body>

    <?php require __DIR__ . '../../components/AdminNavbar.php';
    @require __DIR__ . "/../components/bootstrap.php";
 ?>

    <div class="container border p-4 mt-5 pt-4">

        <div class="page-title-row">
            <div class="page-title-icon"><i class="bi bi-receipt"></i></div>
            <h2 class="fw-bold mb-0">Checks</h2>
        </div>

        <!-- ========== FILTER FORM ========== -->
        <form method="GET" class="row mb-4 g-3 align-items-end filter-section">

            <div class="col-md-3">
                <label>Date from</label>
                <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($from ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label>Date to</label>
                <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($to ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label>User</label>
                <select name="user" class="form-select">
                    <option value="">All Users</option>
                    <?php foreach ($usersList as $u): ?>
                        <option value="<?= $u['id'] ?>" <?= (isset($user) && $user == $u['id']) ? 'selected' : '' ?>>
                            <?= $u['name'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-filter-primary w-100">
                    <i class="bi bi-search me-2"></i>Filter
                </button>
                <a href="<?php url("check") ?>" class="btn btn-filter-secondary w-100">
                    <i class="bi bi-x-circle me-2"></i>Clear
                </a>
            </div>

        </form>

        <div class="accordion" id="usersAccordion">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th style="width:60%">Name</th>
                            <th>Total amount</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($users as $userId => $user): ?>
                            <?php
                            $total = 0;
                            foreach ($user['orders'] as $order) {
                                $total += $order['total'];
                            }
                            $initials = strtoupper(substr($user['name'], 0, 2));
                            ?>
                            <tr>
                                <td colspan="2" class="p-0 border-0">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed user-accordion-btn" data-bs-toggle="collapse" data-bs-target="#user<?= $userId ?>">
                                                <span class="user-avatar"><?= $initials ?></span>
                                                <span class="user-name-text"><?= $user['name'] ?></span>
                                                <span class="amount-badge"><?= $total ?> EGP</span>
                                                <i class="bi bi-chevron-right chevron ms-2"></i>
                                            </button>
                                        </h2>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>
            </div>

            <!-- USER ORDERS -->
            <?php foreach ($users as $userId => $user): ?>
                <div id="user<?= $userId ?>" class="accordion-collapse collapse" data-bs-parent="#usersAccordion">
                    <div class="accordion-body p-3 bg-light-custom border">
                        <div class="accordion" id="orders<?= $userId ?>">

                            <div class="table-responsive">
                                <table class="table table-bordered bg-white mb-0 align-middle shadow-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:60%">Order Date</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($user['orders'] as $orderId => $order): ?>
                                            <tr>
                                                <td colspan="2" class="p-0 border-0">
                                                    <div class="accordion-item">
                                                        <button class="accordion-button collapsed order-accordion-btn" data-bs-toggle="collapse" data-bs-target="#order<?= $orderId ?>">
                                                            <span class="order-date-text">
                                                                <i class="bi bi-calendar3"></i>
                                                                <?= $order['date'] ?>
                                                            </span>
                                                            <span class="order-amount-text"><?= $order['total'] ?> EGP</span>
                                                            <i class="bi bi-chevron-right chevron ms-2"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php foreach ($user['orders'] as $orderId => $order): ?>
                                <div id="order<?= $orderId ?>" class="accordion-collapse collapse" data-bs-parent="#orders<?= $userId ?>">
                                    <div class="accordion-body p-3 bg-white border rounded mt-3">
                                        <div class="row g-3">
                                            <?php foreach ($order['products'] as $product): ?>
                                                <div class="col-3">
                                                    <div class="product-card">
                                                        <img src="../assets/images/products/<?= $product['image'] ?>" class="product-img" alt="<?= $product['name'] ?>">
                                                        <div>
                                                            <div class="product-card-name"><?= $product['name'] ?></div>
                                                            <div class="product-card-meta">
                                                                <span class="product-price-tag"><?= $product['price'] ?> LE</span>
                                                                <span class="product-qty-tag">x<?= $product['quantity'] ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>

                        </div>
                    </div>
                </div>
            <?php endforeach ?>

        </div>

        <!-- ========== PAGINATION ========== -->
        <?php if ($totalPages > 1): ?>
            <?php $start = max(1, $page - 2); $end = min($totalPages, $page + 2); ?>

            <div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top">

                <span class="pagination-info">
                    Page <?= $page ?> of <?= $totalPages ?> &mdash; <?= $totalUsers ?> users
                </span>

                <nav>
                    <ul class="pagination pagination-sm mb-0">

                        <li class="page-item <?= $page === 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= $buildPageUrl(1) ?>">
                                <i class="bi bi-chevron-double-left"></i>
                            </a>
                        </li>

                        <li class="page-item <?= $page === 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= $buildPageUrl($page - 1) ?>">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>

                        <?php for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                <a class="page-link" href="<?= $buildPageUrl($i) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor ?>

                        <li class="page-item <?= $page === $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= $buildPageUrl($page + 1) ?>">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>

                        <li class="page-item <?= $page === $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= $buildPageUrl($totalPages) ?>">
                                <i class="bi bi-chevron-double-right"></i>
                            </a>
                        </li>

                    </ul>
                </nav>

            </div>
        <?php endif ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>