<?php require __DIR__ . '/../Order/Components/head.php'; ?>
<body class="bg-light">
    <?php require __DIR__ . '/../Order/Components/navbar.php'; ?>
    <div class="container py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Create New Order</h2>
            <a href="<?= url("orders") ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Orders
            </a>
        </div>

        <!-- Alerts -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- User Info -->
        <?php if ($user): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-person me-2"></i>Your Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Name:</strong> <?php echo htmlspecialchars($user->name); ?></p>
                    <p class="mb-0"><strong>Room:</strong> <?php echo $user->room_name ?? 'Not assigned'; ?> <?php echo $user->room_number ? '(' . $user->room_number . ')' : ''; ?></p>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= url("orders/store") ?>">

            <!-- Room & Notes -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-gear me-2"></i>Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="room_id" class="form-label">Delivery Room (Optional)</label>
                            <select name="room_id" id="room_id" class="form-select">
                                <option value="">Select Room</option>
                                <?php foreach ($rooms as $room): ?>
                                    <option value="<?php echo $room['id']; ?>" <?php echo (($user->room_id ?? null) == $room['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($room['name']); ?> (<?php echo $room['room_number']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="notes" class="form-label">Order Notes (Optional)</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Any special requests or notes..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-box me-2"></i>Select Products</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($groupedProducts as $category => $products): ?>
                        <h5 class="bg-light p-2 rounded mb-3 mt-3"><?php echo htmlspecialchars($category); ?></h5>
                        <?php foreach ($products as $product): ?>
                            <div class="d-flex align-items-center border rounded p-3 mb-2">
                                <div class="form-check me-3">
                                    <input type="checkbox" class="form-check-input" name="product_id[]" value="<?php echo $product['id']; ?>" id="product_<?php echo $product['id']; ?>">
                                </div>
                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?= url("images/products/" . $product['image']) ?>"
                                         alt="<?php echo htmlspecialchars($product['name']); ?>"
                                         class="rounded me-3"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <label for="product_<?php echo $product['id']; ?>" class="form-check-label fw-bold">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </label>
                                    <span class="badge bg-success ms-2"><?php echo $product['price']; ?> LE</span>
                                </div>
                                <input type="number" name="quantity[<?php echo $product['id']; ?>]" min="1" max="10" value="1"
                                       class="form-control ms-3" style="width: 80px;" placeholder="Qty">
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Submit -->
            <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-check-circle me-1"></i> Place Order
                </button>
            </div>
        </form>

    </div>

    <script>
        // Auto-check/uncheck quantity when product is selected
        document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const quantityInput = document.querySelector('input[name="quantity[' + this.value + ']"]');
                if (quantityInput) {
                    quantityInput.disabled = !this.checked;
                    if (!this.checked) {
                        quantityInput.value = 1;
                    }
                }
            });
        });

        // Initially disable quantity inputs
        document.querySelectorAll('input[name^="quantity"]').forEach(function(input) {
            input.disabled = true;
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
