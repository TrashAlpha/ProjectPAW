<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Gallery Website. All rights reserved.</p>
    </footer>

    <style>
        html, body {
            margin: 0;
            padding: 0
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1;
            padding: 10px;
        }

        footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            font-family: Times New Roman;
        }

        footer p {
            margin: 0;
            color: #555;
        }
    </style>
</body>
</html>
