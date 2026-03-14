<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cafeteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                <div class="text-center mb-4">
                    <h1 class="display-5 fw-bold text-primary">Cafeteria</h1>
                    <p class="text-secondary">Please enter your details to login</p>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <?php showErrors() ?>
                        <form action="<?= url('authuser/login') ?>" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email address</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email"
                                    placeholder="name@example.com" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password"
                                    placeholder="••••••••" required>
                            </div>

                            <div class="mb-4">
                                <label for="role" class="form-label fw-semibold">Login As</label>
                                <select class="form-select form-select-lg" name="role" id="role" required>
                                    <option selected value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Login</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-muted">&copy; 2026 Cafeteria Management System</small>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>