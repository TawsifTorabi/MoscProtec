<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .error-container {
            text-align: center;
            max-width: 600px;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .error-header {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #e74c3c;
        }
        .error-message {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        .btn-home {
            padding: 10px 20px;
            background-color: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .btn-home:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-header">Access Denied</h1>
        <p class="error-message"><?= esc($message) ?></p>
        <a href="<?= site_url('/'); ?>" class="btn-home">Go to MoscProtec Homepage</a>
    </div>
</body>
</html>
