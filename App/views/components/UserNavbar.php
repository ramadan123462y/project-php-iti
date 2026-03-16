<?php

use App\Core\Auth;

$authUser = Auth::currentUser();

$requestUri  = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$scriptDir   = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$currentUri  = '/' . ltrim(substr($requestUri, strlen($scriptDir)), '/');
$currentUri  = rtrim($currentUri, '/') ?: '/';

$displayName = $authUser['name'] ?? 'Admin';
$avatarUrl   = 'https://ui-avatars.com/api/?name=' . urlencode($displayName) . '&background=0d6efd&color=fff';

function active($uri, $paths)
{
    return in_array($uri, $paths) ? 'active text-primary' : 'text-dark';
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNavbar">

            <ul class="navbar-nav me-auto gap-lg-3">

                <li class="nav-item">
                    <a class="nav-link fw-semibold <?= active($currentUri, ['/', '/Home', '/Home/index', '/order/index']) ?>"
                       href="<?= url('/order/index') ?>">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-semibold <?= active($currentUri, ['/Orders', '/Orders/index']) ?>"
                       href="<?= url('/Orders/index') ?>">My Orders</a>
                </li>

            </ul>

           <div class="d-flex align-items-center">

    <img src="<?= url('/assets/images/users/' . (!empty($authUser['image']) && file_exists(__DIR__ . '/../../../public/assets/images/users/' . $authUser['image']) ? $authUser['image'] : 'default.jpg')) ?>"
         width="35"
         height="35"
         class="rounded-circle me-2">

    <strong class="me-3"><?= e($displayName) ?></strong>

    <a class="btn btn-sm btn-outline-danger" href="<?= url('/AuthUser/logout') ?>">
        Logout
    </a>

</div>

        </div>
    </div>
</nav>