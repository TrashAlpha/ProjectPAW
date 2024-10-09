<?php
include 'header.php';
include 'db.php';
?>

<div class="content">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $sql->bind_param("ss", $username, $password);

        if ($sql->execute()) {
            echo "Pendaftaran berhasil!";
        } else {
            echo "Error: " . $sql->error;
        }
        
        $sql->close();
        $conn->close();
    }
    ?>

    <h2>Register</h2>
    <form method="post" action="">
        Username: <br><input type="text" name="username" required><br>
        Password: <br><input type="password" name="password" required><br>
        <input type="submit" value="Register">
    </form>
</div>

<?php include 'footer.php'; ?>
