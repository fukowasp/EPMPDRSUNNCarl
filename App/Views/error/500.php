<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>500 Internal Server Error</title>
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
        }
        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #fd7e14;
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
            background: #fd7e14;
            border: none;
            font-weight: bold;
            transition: 0.3s;
        }
        a.btn-home:hover {
            background: #e36209;
        }
    </style>
</head>
<body>
    <div>
        <div class="error-code"><i class="bi bi-bug-fill"></i> 500</div>
        <h2 class="typewriter">Internal Server Error</h2>
        <p class="mt-3">Sorry! Something went wrong on our end.</p>
        <a href="http://localhost/EPMPDRSUNN/" class="btn btn-home btn-lg text-white"><i class="bi bi-arrow-clockwise"></i> Try Again</a>
    </div>
</body>
</html>
