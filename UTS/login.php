<?php
include 'header.php';
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoginPage</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = $conn->prepare("SELECT * FROM users WHERE username=?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                header("Location: index.php");
            } else {
                echo "<script>alert('Password salah!')</script>";
            }
        } else {
            echo "<script>alert('Username tidak ditemukan!')</script>";
        }
        
        $sql->close();
        $conn->close();
    }
    ?>

    <div class="container">
        <h2>Login</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username <br> 
                    <input type="text" name="username" required>
                </label> <br>
                <label for="password"> Password <br> 
                    <input type="password" name="password" required>
                </label> <br>
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>