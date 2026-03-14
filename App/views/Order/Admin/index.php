<?php require __DIR__ . '/../Components/head.php'; ?>

<body>

    <?php require __DIR__ . '/../Components/navbar.php'; ?>

    <div class="container">
        <div class="row g-4">

           <?php require __DIR__ . '/../Components/cart_sidebar.php'; ?>

            <div class="col-lg-8">
                <div class="mb-4">
                    <h6 class="text-uppercase fw-bold text-muted mb-2">Add to user</h6>
                    <select class="form-select border-2" onchange="window.location.href='<?= url('/Order/admin') ?>?user=' + this.value">
                        <option value="">Select User...</option>
                        <?php foreach ($users as $user) : ?>
                            <option value="<?= $user['id'] ?>" <?= (($_GET['user'] ?? '') == $user['id']) ? 'selected' : '' ?> required>
                                <?= e($user['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php require __DIR__ . '/../Components/FullMenu.php'; ?>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
