<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Website</title>
    <style>
        .nav {
            background-color: #f2f2f2;
            padding: 10px;
            width: 100%;
            font-family: Times New Roman;
        }
        .nav a {
            margin: 0 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="nav">
        <a href="index.php">Home</a>
        <a href="list_photo.php">List Photo</a>
        <?php
        if (isset($_SESSION['username'])) {
            echo '<a href="logout.php">Logout</a>';
        } else {
            echo '<a href="login.php">Login</a>';
            echo '<a href="register.php">Register</a>';
        }
        ?>
    </div>
