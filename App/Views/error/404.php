<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('libs/bootstrap-icons/bootstrap-icons.css') ?>">
    <script src="<?= base_url('libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <style>
        body {
            background-color: #121212;
            color: #f8f9fa;
            font-family: 'Courier New', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            flex-direction: column;
            overflow: hidden;
            opacity: 0;
            animation: fadeIn 1.5s ease-in-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #dc3545;
            animation: bounce 1.5s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .typewriter {
            display: inline-block;
            border-right: 3px solid #f8f9fa;
            white-space: nowrap;
            overflow: hidden;
            width: 0;
            animation: typing 3s steps(30, end) forwards, blink 0.8s infinite;
        }
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        @keyframes blink {
            0%, 50% { border-color: transparent }
            51%, 100% { border-color: #f8f9fa }
        }
        a.btn-home {
            margin-top: 20px;
            background: #dc3545;
            border: none;
            font-weight: bold;
            transition: 0.3s;
        }
        a.btn-home:hover {
            background: #bb2d3b;
        }
    </style>
</head>
<body>
    <div>
        <div class="error-code"><i class="bi bi-exclamation-triangle-fill"></i> 404</div>
        <h2 class="typewriter">Oops! Page Not Found</h2>
        <p class="mt-3">The page you are looking for does not exist or has been moved.</p>
        <a href="http://localhost/EPMPDRSUNN/" class="btn btn-home btn-lg text-white"><i class="bi bi-house-door-fill"></i> Go Home</a>
    </div>
</body>
</html>
