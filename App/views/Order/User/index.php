<?php require __DIR__ . '/../Components/head.php'; ?>

<body>

    <?php require __DIR__ . '/../../components/UserNavbar.php';

?>

    <div class="d-flex align-items-center gap-3 ms-auto">
        <?php require __DIR__ . '/../Components/search_bar.php'; ?>
    </div>

    <div class="container mt-4">
        <div class="row g-4">

            <?php require __DIR__ . '/../Components/cart_sidebar.php'; ?>

            <div class="col-lg-8">
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="text-uppercase fw-bold text-muted mb-0 me-3">Latest Order</h6>
                        <hr class="flex-grow-1 opacity-25">
                    </div>

                    <div class="row row-cols-2 row-cols-md-4 g-3">
                        <?php if (empty($latestOrder)) : ?>

                            <div class="col-12">
                                <div class="text-center py-5 px-3">
                                    <div class="mb-4">
                                        <i class="bi bi-cup-hot-fill display-1 text-muted opacity-25"></i>
                                    </div>
                                    <h4 class="fw-bold text-secondary mb-2">No orders yet</h4>
                                    <p class="text-muted mb-4">Your order history will appear here</p>
                                    <p class="text-muted mb-0">
                                        <span class="badge bg-light text-dark p-3 rounded-pill">
                                            <i class="bi bi-arrow-down me-2"></i>
                                            Start by adding items from the menu
                                        </span>
                                    </p>
                                </div>
                            </div>
                        <?php else : ?>
                            <?php foreach ($latestOrder as $order) : ?>
                                <div class="col">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="position-relative" style="padding-top: 100%;">
                                            <img src="<?= url('/assets/images/products/' . e($order['image'])) ?>"
                                                class="position-absolute top-0 start-0 w-100 h-100"
                                                style="object-fit: contain; padding: 1rem;"
                                                alt="<?= e($order['name']) ?>">

                                            <!-- Quantity Badge (if available) -->
                                            <?php if (!empty($order['quantity'])) : ?>
                                                <span class="position-absolute top-0 start-0 m-2 badge bg-secondary rounded-pill">
                                                    <i class="bi bi-cart me-1"></i>x<?= e($order['quantity']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="card-body text-center p-2">
                                            <h6 class="fw-bold mb-1 small text-truncate" title="<?= e($order['name']) ?>">
                                                <?= e($order['name']) ?>
                                            </h6>

                                            <!-- Price and Quantity Row -->
                                            <div class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                                <span class="fw-bold text-primary">
                                                    <?= e($order['price']) ?> EGP
                                                </span>

                                                <?php if (!empty($order['quantity'])) : ?>
                                                    <span class="badge bg-light text-dark border">
                                                        Quantity: <?= e($order['quantity']) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>


                                            <span class="badge w-100 py-2 rounded-pill fw-semibold
                            <?php
                                // Just change the background color based on status
                                echo match (strtolower($order['status'])) {
                                    'pending' => 'bg-warning text-dark',
                                    'processing' => 'bg-info',
                                    'completed' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    'delivered' => 'bg-primary',
                                    default => 'bg-secondary'
                                };
                            ?>">
                                                <?= e($order['status']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Full Menu Section -->
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <h6 class="text-uppercase fw-bold text-muted mb-0 me-3">Full Menu</h6>
                            <hr class="flex-grow-1 opacity-25">
                        </div>

                        <?php require __DIR__ . '/../Components/FullMenu.php'; ?>
                    </div>
                </div>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>