<?php require __DIR__ . '/../Components/head.php'; ?>

<body>

<?php require __DIR__ . '../../../components/AdminNavbar.php'; ?>

<div class="d-flex align-items-center gap-3 ms-auto">

    <div class="ms-auto d-none d-md-flex" style="width:260px;">
        <form method="GET" action="<?= url($currentPagePath ?? '/Order') ?>" class="input-group">

            <span class="input-group-text bg-light border-0">
                <i class="bi bi-search"></i>
            </span>

            <?php if (!empty($selectedUserId)) : ?>
                <input type="hidden" name="user" value="<?= e($selectedUserId) ?>">
            <?php endif; ?>

            <input
                type="text"
                name="search"
                class="form-control bg-light border-0"
                placeholder="Search..."
                value="<?= e($_GET['search'] ?? '') ?>">

            <?php if (!empty($_GET['search'])) : ?>
                <a href="<?= url($redirectTo ?? ($currentPagePath ?? '/Order')) ?>" class="btn btn-outline-secondary">
                    Clear
                </a>
            <?php endif; ?>

        </form>
    </div>

   

</div>

<div class="container">
    <div class="row g-4">

        <?php require __DIR__ . '/../Components/cart_sidebar.php'; ?>

        <div class="col-lg-8">

            <div class="mb-4">
                <h6 class="text-uppercase fw-bold text-muted mb-2">Add to user</h6>

                <select
                    class="form-select border-2"
                    onchange="window.location.href='<?= url('/Order/admin') ?>?user=' + this.value">

                    <option value="">Select User...</option>

                    <?php foreach ($users as $user) : ?>

                        <option
                            value="<?= $user['id'] ?>"
                            <?= (($_GET['user'] ?? '') == $user['id']) ? 'selected' : '' ?>>

                            <?= e($user['name']) ?>

                        </option>

                    <?php endforeach; ?>

                </select>
            </div>

            <?php require __DIR__ . '/../Components/FullMenu.php'; ?>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>