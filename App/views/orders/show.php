<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Order Details #<?php echo $order['id']; ?></h2>
            <a href="<?= url("orders") ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Orders
            </a>
        </div>

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

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-info-circle me-2"></i>Order Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Order Date:</strong> <?php echo date('M j, Y H:i', strtotime($order['created_at'] ?? 'now')); ?></p>
                        <p><strong>Room:</strong> <?php echo htmlspecialchars($order['room_name'] ?? 'N/A'); ?> <?php echo ($order['room_number'] ?? '') ? '(' . $order['room_number'] . ')' : ''; ?></p>
                    </div>
                    <div class="col-md-6">
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
                        <?php if ($order['notes'] ?? null): ?>
                            <p><strong>Notes:</strong> <?php echo htmlspecialchars($order['notes']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
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
                            <?php $items = $order['items'] ?? []; ?>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td class="d-flex align-items-center gap-2">
                                        <?php if (!empty($item['product_image'])): ?>
                                            <img src="<?= url("images/products/" . $item['product_image']) ?>"
                                                 alt="<?php echo htmlspecialchars($item['product_name'] ?? 'Unknown'); ?>"
                                                 class="rounded"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
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
            <?php if (in_array($order['status'] ?? '', ['pending', 'processing'])): ?>
                <a href="<?= url("orders/cancel/" . $order['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this order?')">
                    <i class="bi bi-x-circle me-1"></i> Cancel Order
                </a>
            <?php endif; ?>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
