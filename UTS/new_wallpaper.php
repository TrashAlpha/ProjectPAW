<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $size = $_POST['size'];
    $resolution = $_POST['resolution'];
    $file_size = $_POST['file_size'];
    $uploader = $_POST['uploader'];
    
    $wallpaper_image = null; // untuk menyimpan address dari gambar
    
    // dikeluarkan pesan apabila upload error
    if (isset($_FILES['uploadedfile']) && $_FILES['uploadedfile']['error'] !== UPLOAD_ERR_NO_FILE) {
        $target_path = "photos/";
        $target_path = $target_path . basename($_FILES['uploadedfile']['name']); 

        if ($_FILES['uploadedfile']['error'] !== UPLOAD_ERR_OK) {
            echo "<script>alert('File upload error: " . $_FILES['uploadedfile']['error'] . "');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
            exit();
        }

        if (!move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
            echo "<script>alert('There was an error uploading the file, please try again!');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
            exit();
        }

        $wallpaper_image = $target_path;
    }

    // update
    if (isset($_POST['id'])) {
        $wallpaper_id = $_POST['id'];

        if ($wallpaper_image) {
            $sql = "UPDATE storphoto SET address=?, title=?, author=?, size=?, resolution=?, file_size=?, uploader=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssi", $wallpaper_image, $title, $author, $size, $resolution, $file_size, $uploader, $wallpaper_id);
        } else {
            $sql = "UPDATE storphoto SET title=?, author=?, size=?, resolution=?, file_size=?, uploader=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $title, $author, $size, $resolution, $file_size, $uploader, $wallpaper_id);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Wallpaper berhasil di-update');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        }
    
    // create new
    } else {
        // Jika tidak ada file yang diunggah, jangan biarkan insert dilakukan
        if (!$wallpaper_image) {
            echo "<script>alert('Silakan unggah gambar sebelum menambahkan wallpaper.');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
            exit();
        }

        $sql = "INSERT INTO storphoto (address, title, author, size, resolution, file_size, uploader) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $wallpaper_image, $title, $author, $size, $resolution, $file_size, $uploader);

        if ($stmt->execute()) {
            echo "<script>alert('Wallpaper berhasil ditambahkan');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Insert Error: " . $stmt->error . "');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        }
    }

    $stmt->close();
}

$wallpaper_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$wallpaper = null;

if ($wallpaper_id) {
    $sql = "SELECT * FROM storphoto WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $wallpaper_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $wallpaper = $result->fetch_assoc();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Wallpaper</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="insert-wallpaper-container">
        <h2><?php echo $wallpaper ? 'Edit Wallpaper' : 'Tambah Wallpaper Baru'; ?></h2>
        <form enctype="multipart/form-data" action="" method="POST">
            <?php if ($wallpaper): ?>
                <input type="hidden" name="id" value="<?php echo $wallpaper['id']; ?>">
            <?php endif; ?>

            <label for="title">Judul Wallpaper:</label>
            <input type="text" id="title" name="title" value="<?php echo $wallpaper['title'] ?? ''; ?>" required>

            <label for="author">Author:</label>
            <input type="text" id="author" name="author" value="<?php echo $wallpaper['author'] ?? ''; ?>" required>

            <label for="size">Ukuran Gambar (format [n x m]):</label>
            <input type="text" id="size" name="size" value="<?php echo $wallpaper['size'] ?? ''; ?>" required>
            
            <label for="resolution">Resolusi Gambar:</label>
            <select name="resolution" id="resolution" required>
                <option value="144p" <?php if (isset($wallpaper) && $wallpaper['resolution'] == '144p') echo 'selected'; ?>>144p</option>
                <option value="240p" <?php if (isset($wallpaper) && $wallpaper['resolution'] == '240p') echo 'selected'; ?>>240p</option>
                <option value="360p" <?php if (isset($wallpaper) && $wallpaper['resolution'] == '360p') echo 'selected'; ?>>360p</option>
                <option value="480p" <?php if (isset($wallpaper) && $wallpaper['resolution'] == '480p') echo 'selected'; ?>>480p</option>
                <option value="720p" <?php if (isset($wallpaper) && $wallpaper['resolution'] == '720p') echo 'selected'; ?>>720p</option>
                <option value="1080p" <?php if (isset($wallpaper) && $wallpaper['resolution'] == '1080p') echo 'selected'; ?>>1080p</option>
                <option value="2k" <?php if (isset($wallpaper) && $wallpaper['resolution'] == '2k') echo 'selected'; ?>>2k</option>
                <option value="4k" <?php if (isset($wallpaper) && $wallpaper['resolution'] == '4k') echo 'selected'; ?>>4k</option>
                <option value="8k" <?php if (isset($wallpaper) && $wallpaper['resolution'] == '8k') echo 'selected'; ?>>8k</option>
            </select>

            <label for="file_size">Ukuran File:</label>
            <input type="text" id="file_size" name="file_size" value="<?php echo $wallpaper['file_size'] ?? ''; ?>" required>

            <label for="uploader">Nama Uploader:</label>
            <input type="text" id="uploader" name="uploader" value="<?php echo $wallpaper['uploader'] ?? ''; ?>" required>

            <label for="wallpaper_image">Upload Gambar:</label>
            <input name="uploadedfile" type="file" /> <br>

            <?php if ($wallpaper): ?>
                <label>Gambar:</label>
                <?php if (!empty($wallpaper['address'])): ?>
                    <img src="<?php echo $wallpaper['address']; ?>" alt="Gambar Wallpaper" style="width: 200px; height: auto;">
                <?php else: ?>
                    <p>Tidak ada gambar wallpaper tersedia.</p>
                <?php endif; ?>
            <?php endif; ?>

            <input type="submit" value="<?php echo $wallpaper ? 'Update Wallpaper' : 'Tambah Wallpaper'; ?>">
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
include 'footer.php';
?>