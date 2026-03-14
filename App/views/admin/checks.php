<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checks - Cafeteria</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .accordion-button {
            padding: 0.5rem 1rem;
            background-color: transparent;
            box-shadow: none;
        }

        .accordion-button:not(.collapsed) {
            background-color: transparent;
            box-shadow: none;
        }

        .bg-light-custom {
            background-color: #f8f9fa;
        }

        .product-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>


    <link rel="stylesheet" href="assets/css/navbar.css">


</head>

<body class="bg-white p-4">

    <?php
    require __DIR__ . "/../components/navbar.php";
    ?>

    <div class="container border p-4">

        <h2 class="fw-bold mb-4">Checks</h2>

        <!-- ========== FILTER FORM ========== -->
        <form method="GET" class="row mb-4 g-3 align-items-end">

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
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-2"></i>Filter
                </button>

                <a href="/checks" class="btn btn-secondary w-100">
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
                            ?>

                            <tr>
                                <td colspan="2" class="p-0 border-0">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#user<?= $userId ?>">
                                                <span class="flex-grow-1"><?= $user['name'] ?></span>
                                                <span class="fw-normal"><?= $total ?> EGP</span>
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
                                                        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#order<?= $orderId ?>">
                                                            <span class="flex-grow-1 text-start"><?= $order['date'] ?></span>
                                                            <span class="fw-normal"><?= $order['total'] ?> EGP</span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php endforeach ?>

                                    </tbody>

                                </table>
                            </div>

                            <!-- ORDER PRODUCTS -->
                            <?php foreach ($user['orders'] as $orderId => $order): ?>

                                <div id="order<?= $orderId ?>" class="accordion-collapse collapse" data-bs-parent="#orders<?= $userId ?>">

                                    <div class="accordion-body p-3 bg-white border rounded mt-3">

                                        <div class="row text-center g-3">

                                            <?php foreach ($order['products'] as $product): ?>

                                                <div class="col-3">

                                                    <div class="position-relative d-inline-block">

                                                        <img src="assets/images/products/<?= $product['image'] ?>" class="product-img">

                                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-white text-dark border small">
                                                            <?= $product['price'] ?> LE
                                                        </span>

                                                    </div>

                                                    <div class="small fw-bold mt-1"><?= $product['name'] ?></div>

                                                    <div class="small text-muted"><?= $product['quantity'] ?></div>

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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>