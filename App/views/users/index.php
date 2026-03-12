<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>All Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .user-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="page-box bg-white rounded p-4 mt-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">All Users</h2>
                <a href="<?= url('users/create') ?>" class="btn btn-primary">Add User</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Room Id</th>
                            <th>Role</th>
                            <th>Image</th>
                            <th>Ext</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
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
                                    <?php if (!empty($user["image"])): ?>
                                        <img src="<?= url("images/" . $user["image"]) ?>" alt="user" class="user-img">
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td><?= $user["ext"] ?></td>
                                <td>
                                    <a href="<?= url("users/show/{$user['id']}") ?>" class="btn btn-info btn-sm">View</a>
                                </td>
                                <td>
                                    <a href="<?= url("users/edit/{$user['id']}") ?>" class="btn btn-warning btn-sm">Edit</a>
                                </td>
                                <td>
                                    <form action="<?= url("users/delete/{$user['id']}") ?>" method="POST" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>