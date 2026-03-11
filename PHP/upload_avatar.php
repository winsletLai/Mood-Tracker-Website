<?php
session_start();

include 'config.php';

if (!isset($_SESSION['unique_id'])) {
    die("User not logged in.");
}

$userId = $_SESSION['unique_id'];

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
    $uploadDir = 'images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $tmpName = $_FILES['avatar']['tmp_name'];
    $name = basename($_FILES['avatar']['name']);
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($ext, $allowed)) {
        die("Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
    }

    $newName = uniqid('avatar_') . "." . $ext;
    $targetPath = $uploadDir . $newName;

    if (move_uploaded_file($tmpName, $targetPath)) {
        $stmt = $conn->prepare("UPDATE users SET image = ? WHERE unique_id = ?");
        $stmt->bind_param("si", $newName, $userId);
        if ($stmt->execute()) {
            $_SESSION['avatar'] = $targetPath;
        } else {
            echo "Database update failed: " . $stmt->error;
        }

        header("Location: ../Profile.php");
        exit();
    } else {
        echo "Upload failed.";
    }
} else {
    echo "No file uploaded.";
}
