<?php require __DIR__ . '/../Order/Components/head.php'; ?>
<body class="bg-light">

<?php 
use App\Core\Auth;
$navbar = Auth::isAuth('admin') ? 'AdminNavbar.php' : 'UserNavbar.php';
require __DIR__ . '/../components/' . $navbar;
?>

    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Order #<?php echo $order['id']; ?></h2>
            <a href="<?= url("orders/show/" . $order['id']) ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Order
            </a>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= url("orders/update/" . $order['id']) ?>">

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-gear me-2"></i>Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Order Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="pending" <?php echo ($order['status'] ?? '') === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="processing" <?php echo ($order['status'] ?? '') === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="completed" <?php echo ($order['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="cancelled" <?php echo ($order['status'] ?? '') === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="room_id" class="form-label">Room</label>
                            <select name="room_id" id="room_id" class="form-select">
                                <option value="">Select Room</option>
                                <?php foreach ($rooms as $room): ?>
                                    <option value="<?php echo $room['id']; ?>" <?php echo (($order['room_id'] ?? null) == $room['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($room['name']); ?> (<?php echo $room['room_number']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="notes" class="form-label">Order Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control"><?php echo htmlspecialchars($order['notes'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-cart me-2"></i>Order Items <small class="text-muted">(Read-only)</small></h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
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
                                        <td><?php echo htmlspecialchars($item['product_name'] ?? 'Unknown'); ?></td>
                                        <td><?php echo $item['quantity'] ?? 0; ?></td>
                                        <td><?php echo $item['price'] ?? 0; ?> LE</td>
                                        <td><?php echo ($item['price'] ?? 0) * ($item['quantity'] ?? 0); ?> LE</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-check-circle me-1"></i> Update Order
                </button>
            </div>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
