<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Please Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at top right, #e9ecef, #f8f9fa);
            font-family: 'Inter', sans-serif;
            margin: 0;
            overflow: hidden;
        }

        .hero-container {
            text-align: center;
            animation: fadeIn 0.8s ease-out;
        }

        .welcome-text {
            font-weight: 900;
            letter-spacing: -2px;
            color: #1a1d20;
            text-transform: uppercase;
            margin-bottom: 0;
            line-height: 1;
        }

        .subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin-top: 1rem;
            margin-bottom: 2.5rem;
            letter-spacing: 1px;
        }

        .btn-portal {
            padding: 14px 40px;
            font-weight: 700;
            border-radius: 50px;
            text-transform: uppercase;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            letter-spacing: 1px;
        }

        .btn-login {
            background-color: #212529;
            color: white;
            border: none;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-login:hover {
            background-color: #000;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="container hero-container">
        <h1 class="display-1 welcome-text">Welcome</h1>
        <p class="subtitle">Please sign in to access your dashboard</p>

        <div class="d-flex justify-content-center gap-3">
            <a href="<?= url('/authuser/index') ?>" class="btn btn-portal btn-login">Login to Account</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>