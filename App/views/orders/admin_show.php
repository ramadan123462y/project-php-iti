<?php require __DIR__ . '/../Order/Components/head.php'; ?>

<body>

    <?php require __DIR__ . '/../Order/Components/navbar.php'; ?>

    <div class="container py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                Order #<?php echo $order['id']; ?>
                <span class="badge bg-danger fs-6 ms-2">ADMIN</span>
            </h2>
            <a href="<?= url("orders/adminIndex") ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Orders
            </a>
        </div>

        <!-- Alerts -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Update Status -->
        <div class="card border-warning mb-4">
            <div class="card-header bg-warning bg-opacity-25">
                <h5 class="card-title mb-0"><i class="bi bi-pencil-square me-2"></i>Update Order Status</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= url("orders/updateStatus/" . $order['id']) ?>" class="d-flex align-items-center gap-3">
                    <select name="status" class="form-select w-auto" required>
                        <option value="pending" <?php echo ($order['status'] ?? '') === 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="processing" <?php echo ($order['status'] ?? '') === 'processing' ? 'selected' : ''; ?>>Processing</option>
                        <option value="completed" <?php echo ($order['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="cancelled" <?php echo ($order['status'] ?? '') === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-arrow-repeat me-1"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-info-circle me-2"></i>Order Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
                        <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['user_name'] ?? 'Unknown'); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['user_email'] ?? 'N/A'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Room:</strong> <?php echo htmlspecialchars($order['room_name'] ?? 'N/A'); ?> <?php echo ($order['room_number'] ?? '') ? '(' . $order['room_number'] . ')' : ''; ?></p>
                        <p><strong>Order Date:</strong> <?php echo date('M j, Y H:i', strtotime($order['created_at'] ?? 'now')); ?></p>
                        <p>
                            <strong>Status:</strong>
                            <?php
                                $statusClasses = [
                                    'pending'    => 'bg-warning text-dark',
                                    'processing' => 'bg-primary',
                                    'completed'  => 'bg-success',
                                    'cancelled'  => 'bg-danger',
                                ];
                                $badgeClass = $statusClasses[$order['status'] ?? ''] ?? 'bg-secondary';
                            ?>
                            <span class="badge <?php echo $badgeClass; ?>"><?php echo ucfirst($order['status'] ?? 'unknown'); ?></span>
                        </p>
                    </div>
                </div>
                <?php if ($order['notes'] ?? null): ?>
                    <div class="mt-2">
                        <strong>Notes:</strong>
                        <p class="text-muted mb-0"><?php echo htmlspecialchars($order['notes']); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-cart me-2"></i>Order Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] ?? [] as $item): ?>
                                <tr>
                                    <td class="d-flex align-items-center gap-2">
                                        <?php if (!empty($item['product_image'])): ?>
                                            <img src="<?= url("images/products/" . $item['product_image']) ?>"
                                                 alt="<?php echo htmlspecialchars($item['product_name'] ?? 'Unknown'); ?>"
                                                 class="rounded"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                            <span class="bg-secondary bg-opacity-25 rounded d-flex align-items-center justify-content-center"
                                                  style="width: 40px; height: 40px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </span>
                                        <?php endif; ?>
                                        <?php echo htmlspecialchars($item['product_name'] ?? 'Unknown'); ?>
                                    </td>
                                    <td><?php echo $item['quantity'] ?? 0; ?></td>
                                    <td><?php echo $item['price'] ?? 0; ?> LE</td>
                                    <td><?php echo (($item['price'] ?? 0) * ($item['quantity'] ?? 0)); ?> LE</td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="table-light fw-bold">
                                <td colspan="3" class="text-end">Total Amount:</td>
                                <td><?php echo $order['total_price'] ?? 0; ?> LE</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex gap-2">
            <a href="<?= url("orders/delete/" . $order['id']) ?>"
               class="btn btn-danger"
               onclick="return confirm('Are you sure you want to delete this order? This action cannot be undone.')">
                <i class="bi bi-trash me-1"></i> Delete Order
            </a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
