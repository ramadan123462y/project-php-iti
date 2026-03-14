<?php require __DIR__ . '/../Components/head.php'; ?>

<body>

    <?php require __DIR__ . '/../Components/navbar.php'; ?>

    <div class="container">
        <div class="row g-4">

           <?php require __DIR__ . '/../Components/cart_sidebar.php'; ?>

            <div class="col-lg-8">
                <h6 class="text-uppercase ls-wide fw-bold text-muted mb-3">Latest Order</h6>
                <div class="row row-cols-2 row-cols-md-4 g-3 mb-5">
                    <?php foreach ($latestOrders as $order) : ?>
                        <div class="col">
                            <div class="card-drink p-3 text-center border">
                                <?= $order['image'] ?> <p class="mb-0 small fw-bold"><?= e($order['name']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php require __DIR__ . '/../Components/FullMenu.php'; ?>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>