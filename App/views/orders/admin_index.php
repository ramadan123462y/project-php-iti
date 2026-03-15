<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php require __DIR__ . '/../components/AdminNavbar.php';?>
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="bi bi-clipboard-data me-2"></i>Order Management
                <span class="badge bg-danger fs-6 ms-2">ADMIN</span>
            </h2>
            <a href="<?= url("") ?>" class="btn btn-outline-secondary">
                <i class="bi bi-house me-1"></i> Home
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
                <h5 class="card-title mb-0"><i class="bi bi-funnel me-2"></i>Filter Orders</h5>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" class="form-control" name="date_from" id="date_from" value="<?php echo htmlspecialchars($filters['date_from'] ?? ''); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" class="form-control" name="date_to" id="date_to" value="<?php echo htmlspecialchars($filters['date_to'] ?? ''); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" <?php echo ($filters['status'] ?? '') === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="processing" <?php echo ($filters['status'] ?? '') === 'processing' ? 'selected' : ''; ?>>Processing</option>
                            <option value="completed" <?php echo ($filters['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="cancelled" <?php echo ($filters['status'] ?? '') === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary me-2"><i class="bi bi-search me-1"></i> Filter</button>
                        <a href="<?= url("orders") ?>" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Room</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Items</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        No orders found
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td>#<?php echo $order['id']; ?></td>
                                        <td>
                                            <?php echo htmlspecialchars($order['user_name'] ?? 'Unknown User'); ?>
                                            <?php if (!empty($order['items'])): ?>
                                                <div class="text-muted small">
                                                    <?php foreach ($order['items'] as $item): ?>
                                                        <?php echo htmlspecialchars($item['product_name'] ?? 'Unknown'); ?> (<?php echo $item['quantity'] ?? 0; ?>)<br>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($order['room_name'] ?? 'N/A'); ?></td>
                                        <td><?php echo date('M j, Y H:i', strtotime($order['created_at'] ?? 'now')); ?></td>
                                        <td>
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
                                        </td>
                                        <td><strong><?php echo $order['total_price'] ?? 0; ?> LE</strong></td>
                                        <td><span class="badge bg-info"><?php echo count($order['items'] ?? []); ?> items</span></td>
                                        <td>
                                            <a href="<?= url("orders/adminShow/" . $order['id']) ?>" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye me-1"></i>View
                                            </a>
                                            <a href="<?= url("orders/delete/" . $order['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body d-flex gap-4">
                <div>
                    <strong>Total Orders:</strong>
                    <span class="badge bg-info fs-6"><?php echo count($orders); ?></span>
                </div>
                <div>
                    <strong>Total Revenue:</strong>
                    <span class="badge bg-success fs-6">
                        <?php echo array_sum(array_column($orders, 'total_price')); ?> LE
                    </span>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
