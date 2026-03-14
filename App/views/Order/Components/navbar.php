  <nav class="navbar navbar-expand-lg px-4 mb-4">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <a class="nav-link fw-bold me-3" href="#">Home</a>
                <a class="nav-link text-muted" href="#">My Orders</a>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-md-flex" style="width:260px;">
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
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none text-dark fw-semibold">
                        <span class="me-2"><?= e($authUser['name']) ?></span>
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($authUser['name']) ?>&background=1a4d2e&color=fff" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                </div>
            </div>
        </div>
    </nav>
