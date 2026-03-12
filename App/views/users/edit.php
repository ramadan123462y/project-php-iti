<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <div class="page-box bg-white rounded p-4 mt-4 shadow-sm">
            <h2 class="mb-4">Edit User</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= url("users/update/{$user['id']}") ?>" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="<?= isset($user['name']) ? htmlspecialchars($user['name']) : '' ?>"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : '' ?>"
                            required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter new password">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <input
                            type="password"
                            name="confirm_password"
                            class="form-control"
                            placeholder="Confirm new password">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">Choose role</option>
                            <option value="user" <?= isset($user['role']) && $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= isset($user['role']) && $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Room No.</label>
                        <select name="room_id" class="form-select">
                            <option value="">No room</option>
                            <?php foreach (($rooms ?? []) as $room): ?>
                                <option value="<?= htmlspecialchars($room['id']) ?>" <?= (string) ($user['room_id'] ?? '') === (string) $room['id'] ? 'selected' : '' ?>>
                                    Room <?= htmlspecialchars($room['id']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Ext.</label>
                        <input
                            type="text"
                            name="ext"
                            class="form-control"
                            value="<?= isset($user['ext']) ? htmlspecialchars($user['ext']) : '' ?>"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Profile Picture</label>
                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">Allowed formats: JPG, JPEG, PNG, WEBP</small>
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-center">
                    <a href="<?= url('users') ?>" class="btn btn-secondary">Back</a>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>