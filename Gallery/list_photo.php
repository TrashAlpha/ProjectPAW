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

<div class="content">
    <h2>Daftar Foto</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li>
                <img class='img' src ="  .$row['address'] . " alt=" . $row['title'] . ">
                <a href='detail_photo.php?id=" . $row["id"] . "'>" . $row["title"] . "</a>
                </li>";
            }
        } else {
            echo "Tidak ada foto.";
        }
        ?>
    </ul>
</div>

<style>
    .img {
        width: 200px; 
        height: 150px; 
        object-fit: cover; /* Menjaga aspect ratio dan memotong gambar bila perlu */
        display: block;
        margin: 10px 0;  
    }
</style>

<?php
$conn->close();
include 'footer.php';
?>
