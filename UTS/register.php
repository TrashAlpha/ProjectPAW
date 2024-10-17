<?php
include 'header.php';
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RegisterPage</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $sql->bind_param("ss", $username, $password);

        if ($sql->execute()) {
            echo "<script>alert('Pendaftaran berhasil!')</script>";
            header("Location: login.php");
        } else {
            echo "Error: " . $sql->error;
        }
        
        $sql->close();
        $conn->close();
    }
    ?>

    <div class="container">
        <h2>Register</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username <br> 
                    <input type="text" name="username" required>
                </label> <br>
                <label for="password"> Password <br> 
                    <input type="password" name="password" required>
                </label> <br>
                <input type="submit" value="Register">
            </div>
        </form>
    </div>  
</body>
</html>

<?php include 'footer.php'; ?>
