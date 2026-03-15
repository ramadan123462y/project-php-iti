<?php

use App\Core\Auth;

$authUser = Auth::currentUser() ?? [];


$currentUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$currentUri = rtrim($currentUri, '/') ?: '/';

$displayName = $authUser['name'] ?? 'Admin';
$avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($displayName) . '&background=0d6efd&color=fff';

function active($uri, $paths)
{
    return in_array($uri, $paths) ? 'active text-primary' : 'text-dark';
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold text-primary" href="<?= url('/Home/index') ?>">Cafeteria</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNavbar">

            <ul class="navbar-nav me-auto gap-lg-3">

                <li class="nav-item">
                    <a class="nav-link fw-semibold <?= active($currentUri, ['/','/Home','/Home/index']) ?>"
                       href="<?= url('/Orders/adminIndex') ?>">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-semibold <?= active($currentUri, ['/Products','/Products/index']) ?>"
                       href="<?= url('/Products/index') ?>">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-semibold <?= active($currentUri, ['/Users','/Users/index']) ?>"
                       href="<?= url('/Users/index') ?>">Users</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-semibold <?= active($currentUri, ['/Order/admin']) ?>"
                       href="<?= url('/Order/admin') ?>">Manual Order</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-semibold <?= active($currentUri, ['/Check','/Check/index']) ?>"
                       href="<?= url('/Check/index') ?>">Checks</a>
                </li>

            </ul>

            <div class="dropdown">
                <a class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark"
                   href="#"
                   data-bs-toggle="dropdown">

                    <img src="<?= e($avatarUrl) ?>"
                         width="35"
                         height="35"
                         class="rounded-circle me-2">

                    <strong><?= e($displayName) ?></strong>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow">

                    <?php if (!empty($authUser['id'])): ?>
                        <li>
                            <a class="dropdown-item"
                               href="<?= url('/Users/edit/' . $authUser['id']) ?>">
                               Profile
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>
                    <?php endif; ?>

                    <li>
                        <a class="dropdown-item text-danger" href="<?= url('/AuthUser/logout') ?>">
                            Logout
                        </a>
                    </li>

                </ul>
            </div>

        </div>
    </div>
</nav>