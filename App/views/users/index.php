<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>All Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .user-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
        }
        .pagination .page-item.active .page-link {
            /* background-color:black; */
            /* border-color: #ffc10700; */
            /* color: white; */
        }

        .pagination .page-link {
            /* color: #000; */
        }
</style>
    </style>
</head>
<body>
    <?php require __DIR__ . '/../components/AdminNavbar.php'; @require __DIR__ . "/../components/bootstrap.php";
?>
    <div class="container">
        <div class="page-box bg-white rounded p-4 mt-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">All Users</h2>
                <a href="<?= url('users/create') ?>" class="btn btn-primary">Add User</a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle ">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Room Id</th>
                            <th>Role</th>
                            <th>Image</th>
                            <th>Ext</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user["id"] ?></td>
                                <td><?= $user["name"] ?></td>
                                <td><?= $user["email"] ?></td>
                                <td><?= $user["room_id"] ?? "N/A" ?></td>
                                <td><?= $user["role"] ?></td>
                                <td>
                                    <img src="<?= url('/assets/images/users/' . (!empty($user['image']) && file_exists(__DIR__ . '/../../../public/assets/images/users/' . $user['image']) ? $user['image'] : 'default.jpg')) ?>" alt="user" class="user-img">
                                </td>
                                <td><?= $user["ext"] ?></td>
                                <td>
                                    <a href="<?= url("users/show/{$user['id']}") ?>" class="btn btn-primary-subtle btn-sm">View</a>
                                    <a href="<?= url("users/edit/{$user['id']}") ?>" class="btn btn-dark-subtle btn-sm">Edit</a>
                                    <button
                                        type="button"
                                        class="btn btn-danger-subtle btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?= $user['id'] ?>">
                                        Delete
                                    </button>
                                    <div class="modal fade" id="deleteModal<?= $user['id'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    Are you sure you want to delete
                                                    <strong><?= htmlspecialchars($user['name']) ?></strong>?
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                                    <form action="<?= url("users/delete/{$user['id']}") ?>" method="POST" class="d-inline">
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (($totalPages ?? 1) > 1): ?>

                        <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="<?= url('users?page=1') ?>"><i class="fa-solid fa-angles-left"></i>
</a></li>
    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="<?= url('users?page='.$page - 1) ?>"><i class="fa-solid fa-angle-left"></i></a></li>

    <?php if($page > 2): ?>
    <li class="page-item"><a class="page-link" href="<?= url('users?page='.$page - 2) ?>"><?= $page - 2 ?></a></li>
    <?php endif; ?>

    <?php if($page > 1): ?>
    <li class="page-item"><a class="page-link" href="<?= url('users?page='.$page - 1) ?>"><?= $page - 1 ?></a></li>
    <?php endif; ?>

    <li class="page-item active"><a class="page-link" href="<?= url('users?page='.$page) ?>"><?= $page ?></a></li>

    <?php if($page < $totalPages): ?>
    <li class="page-item"><a class="page-link" href="<?= url('users?page='.$page + 1) ?>"><?= $page + 1 ?></a></li>
    <?php endif; ?>

    <?php if($page + 1 < $totalPages): ?>
    <li class="page-item"><a class="page-link" href="<?= url('users?page='.$page + 2) ?>"><?= $page + 2 ?></a></li>
    <?php endif; ?>


    <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>"><a class="page-link" href="<?= url('users?page='.$page + 1) ?>"><i class="fa-solid fa-angle-right"></i></a></li>
    <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>"><a class="page-link" href="<?= url('users?page='.$totalPages) ?>"><i class="fa-solid fa-angles-right"></i></a></li>

  </ul>
</nav>

                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>