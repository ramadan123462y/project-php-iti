<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php require __DIR__ . '/../components/AdminNavbar.php';?>

    <div class="container">
        <div class="page-box bg-white rounded p-4 mt-4 shadow-sm">
            <h2 class="mb-4 text-primary">Add User</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= url('users/store') ?>" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input
                            name="name"
                            type="text"
                            class="form-control"
                            placeholder="Enter name"
                            value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input
                            name="email"
                            type="email"
                            class="form-control"
                            placeholder="Enter email"
                            value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input
                            name="password"
                            type="password"
                            class="form-control"
                            placeholder="Enter password">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <input
                            name="confirm_password"
                            type="password"
                            class="form-control"
                            placeholder="Confirm password">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">Choose role</option>
                            <option value="user" <?= ($old['role'] ?? '') === 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= ($old['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Room No.</label>
                        <select name="room_id" class="form-select">
                            <option value="">No room</option>
                            <?php foreach (($rooms ?? []) as $room): ?>
                                <option value="<?= htmlspecialchars($room['id']) ?>" <?= (string)($old['room_id'] ?? '') === (string)$room['id'] ? 'selected' : '' ?>>
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
                            name="ext"
                            type="text"
                            class="form-control"
                            placeholder="Enter extension"
                            value="<?= htmlspecialchars($old['ext'] ?? '') ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Profile Picture</label>
                        <input
                            name="image"
                            type="file"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">Allowed formats: JPG, JPEG, PNG, WEBP must be less than 2MB.</small>
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-center">
                    <a href="<?= url('users') ?>" class="btn btn-secondary">Back</a>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>