<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM storphoto";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Wallpaper</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wallpaper-container">
    <div style="display: flex; justify-content: center; align-items: center;">
        <h3><?php echo "Welcome, " . htmlspecialchars($_SESSION['username']); ?></h3>
    </div>
    <h2>Daftar Wallpaper</h2>
    <div class="wallpaper-grid">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='wallpaper-card-list'>";
                echo "<a href='detail_wallpaper.php?id=" . $row["id"] . "'>";
                echo "<img class='img-list' src =" . $row['address'] . " alt=" . $row['title'] . ">";
                echo "<h3>" . htmlspecialchars($row["title"]) . "</h3>";
                echo "</a>";    
                echo "<div class='wallpaper-actions'>";
                echo "<button class='edit-button' onclick=\"window.location.href='new_wallpaper.php?id=" . $row["id"] . "'\" title='Edit wallpaper'>Edit</button>";
                echo "<button class='delete-button' onclick=\"confirm('Are you sure you want to delete this wallpaper?') ? location.href='delete_wallpaper.php?id=" . $row['id'] . "' : ''\" title='Delete wallpaper'>Delete</button>";
                echo "</div>";          
                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada foto.</p>";
        }
        ?>
    </div>
</div>
</body>
</html>

<?php
$conn->close();
include 'footer.php';
?>
