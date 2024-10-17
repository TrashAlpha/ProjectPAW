<?php
include 'db.php';

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM storphoto WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        header("Location: index.php");
    }

    $stmt->close();
}

$conn->close();