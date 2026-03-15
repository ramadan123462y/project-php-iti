<?php

use App\Core\Auth;
use App\Core\Request;


$admin = Auth::currentUser("admin");
$adminName = $admin['name'] ?? "Admin";
$adminImage = $admin['image'] ?? null;

$currentUri = Request::uri();
?>

<nav class="main-navbar mb-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <div class="nav-links-wrapper">
            <a href="<?= url('order/index') ?>" class="nav-item-link <?= $currentUri === '/order/index' ? 'active' : '' ?>">Home</a>
            <span class="separator">|</span>
            <a href="<?= url('products/index') ?>" class="nav-item-link <?= $currentUri === '/products/index' ? 'active' : '' ?>">Products</a>
            <span class="separator">|</span>
            <a href="<?= url('users/index') ?>" class="nav-item-link <?= $currentUri === '/users/index' ? 'active' : '' ?>">Users</a>
            <span class="separator">|</span>
        
            <a href="<?= url('check') ?>" class="nav-item-link <?= $currentUri === '/check' ? 'active' : '' ?>">Checks</a>
        </div>

        <a href="<?= url('profile') ?>" class="admin-profile d-flex align-items-center gap-2">
            <div class="admin-avatar">
                <?php if ($adminImage): ?>
                    <img src="<?= url('assets/images/admins/' . $adminImage) ?>" alt="Admin" class="rounded-circle" width="35" height="35">
                <?php else: ?>
                    <i class="bi bi-person-circle fs-3 text-secondary"></i>
                <?php endif; ?>
            </div>
            <span class="admin-name fw-bold"><?= htmlspecialchars($adminName) ?></span>
        </a>

    </div>
</nav>