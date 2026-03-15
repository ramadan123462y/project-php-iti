<?php require __DIR__ . '/../Order/Components/head.php'; ?>

<body>

<?php 
use App\Core\Auth;
$navbar = Auth::isAuth('admin') ? 'AdminNavbar.php' : 'UserNavbar.php';
require __DIR__ . '/../components/' . $navbar;
?>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-receipt me-2"></i>My Orders
                    </h1>
                    <div>
                        <a href="<?= url("orders/create") ?>" class="btn btn-success me-2">
                            <i class="bi bi-plus-circle me-1"></i>New Order
                        </a>
                        <a href="<?= url("order/index") ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-house me-1"></i>Home
                        </a>
                    </div>
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
                        <h5 class="card-title mb-0">
                            <i class="bi bi-funnel me-2"></i>Filter Orders
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="date_from" class="form-label">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                       value="<?php echo htmlspecialchars($filters['date_from'] ?? ''); ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="date_to" class="form-label">Date To</label>
                                <input type="date" class="form-control" id="date_to" name="date_to"
                                       value="<?php echo htmlspecialchars($filters['date_to'] ?? ''); ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">All Status</option>
                                    <option value="pending" <?php echo ($filters['status'] ?? '') === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="processing" <?php echo ($filters['status'] ?? '') === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                    <option value="completed" <?php echo ($filters['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                    <option value="cancelled" <?php echo ($filters['status'] ?? '') === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bi bi-search me-1"></i>Filter
                                </button>
                                <a href="<?= url("orders") ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Clear
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-list-ul me-2"></i>Orders List
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Order Date</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Room</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($orders)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="bi bi-receipt-x fs-1 d-block mb-2"></i>
                                                No orders found
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td>
                                                    <div class="fw-bold">
                                                        <?php echo date('M j, Y H:i', strtotime($order['created_at'] ?? '1970-01-01 00:00:00')); ?>
                                                    </div>
                                                    <?php if (!empty($order['items'] ?? [])): ?>
                                                        <div class="small text-muted mt-1">
                                                            <strong>Items:</strong>
                                                            <?php foreach (($order['items'] ?? []) as $item): ?>
                                                                <div><?php echo ($item['product_name'] ?? 'Unknown'); ?> (<?php echo ($item['quantity'] ?? 0); ?>) - <?php echo ($item['price'] ?? 0); ?> LE</div>
                                                            <?php endforeach; ?>
                                                            <div class="fw-bold mt-1">Total: <?php echo ($order['total_price'] ?? 0); ?> LE</div>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge
                                                        <?php
                                                        $status = $order['status'] ?? 'unknown';
                                                        switch($status) {
                                                            case 'pending': echo 'bg-warning text-dark'; break;
                                                            case 'processing': echo 'bg-primary'; break;
                                                            case 'completed': echo 'bg-success'; break;
                                                            case 'cancelled': echo 'bg-danger'; break;
                                                            default: echo 'bg-secondary';
                                                        }
                                                        ?>">
                                                        <i class="bi bi-circle-fill me-1"></i><?php echo ucfirst($status); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold"><?php echo ($order['total_price'] ?? 0); ?> LE</span>
                                                </td>
                                                <td><?php echo ($order['room_name'] ?? 'N/A'); ?></td>
                                                <td>
                                                    <a href="<?= url("orders/show/{$order['id']}") ?>" class="btn btn-sm btn-outline-primary me-1">
                                                        <i class="bi bi-eye me-1"></i>View
                                                    </a>
                                                    <?php if (in_array($order['status'] ?? '', ['pending', 'processing'])): ?>
                                                        <a href="<?= url("orders/cancel/{$order['id']}") ?>" class="btn btn-sm btn-outline-danger"
                                                           onclick="return confirm('Are you sure you want to cancel this order?')">
                                                            <i class="bi bi-x-circle me-1"></i>Cancel
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
