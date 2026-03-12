<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
    <script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <style>
        body {
            background: #121212;
            color: #f8f9fa;
            font-family: 'Courier New', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .error-container {
            text-align: center;
        }
        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #ff4757;
            text-shadow: 0 0 20px rgba(255, 71, 87, 0.8);
        }
        .typewriter {
            display: inline-block;
            border-right: 3px solid #f8f9fa;
            white-space: nowrap;
            overflow: hidden;
            animation: typing 3s steps(30, end), blink .75s step-end infinite;
            font-size: 1.5rem;
        }
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        @keyframes blink {
            from, to { border-color: transparent }
            50% { border-color: #f8f9fa }
        }
        .btn-home {
            margin-top: 20px;
            padding: 10px 25px;
            font-size: 1rem;
            border-radius: 50px;
            background: #ff4757;
            color: #fff;
            border: none;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-home:hover {
            background: #ff6b81;
            box-shadow: 0 0 15px rgba(255, 71, 87, 0.8);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code"><?= http_response_code() ?></div>
        <div class="typewriter">Oops! Something went wrong.</div>
        <br>
        <a href="http://localhost/EPMPDRSUNN/" class="btn-home">
            <i class="bi bi-house-door"></i> Go Home
        </a>
    </div>
</body>
</html>
