<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="mb-4">User Details</h2>

                <div class="row g-4 align-items-start">
                    <div class="col-md-4 text-center">
                            <img
                                src="<?= url('/assets/images/users/' . (!empty($user['image']) && file_exists(__DIR__ . '/../../../public/assets/images/users/' . $user['image']) ? $user['image'] : 'default.jpg')) ?>"
                                alt="User Image"
                                class="img-thumbnail"
                                style="width: 180px; height: 180px; object-fit: cover;"/>
                    </div>

                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Name</label>
                                <div class="form-control bg-light">
                                    <?= htmlspecialchars($user['name'] ?? '') ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <div class="form-control bg-light">
                                    <?= htmlspecialchars($user['email'] ?? '') ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Room No.</label>
                                <div class="form-control bg-light">
                                    <?= htmlspecialchars($user['room_id'] ?? 'N/A') ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Ext.</label>
                                <div class="form-control bg-light">
                                    <?= htmlspecialchars($user['ext'] ?? '') ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Role</label>
                                <div class="form-control bg-light">
                                    <?= htmlspecialchars($user['role'] ?? '') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-center mt-4">
                    <a href="<?= url('users') ?>" class="btn btn-secondary">
                        Back
                    </a>

                    <a href="<?= url("users/edit/{$user['id']}") ?>" class="btn btn-warning">
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>