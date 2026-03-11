<?php

session_start();

$unique_id = $_SESSION['unique_id'];
include_once 'config.php';

$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$unique_id}");

if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
} else {
    echo "User not found.";
    exit();
}

$action = $_POST['action'] ?? '';

if ($action === 'save_about') {
    $aboutme = $_POST['aboutme'] ?? '';
    $sql = mysqli_query($conn, "UPDATE users SET about_me = '{$aboutme}' WHERE unique_id = {$unique_id}");
    if ($sql) {
        header("Location: ../Profile.php");
        exit();
    }
}
if ($action === 'save_note') {
    $note = $_POST['note'] ?? '';
    $sql = mysqli_query($conn, "UPDATE users SET note = '{$note}' WHERE unique_id = {$unique_id}");
    if ($sql) {
        header("Location: ../Profile.php");
        exit();
    }
}

if ($action === 'save_account') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email)) {
        die("Username and email cannot be empty.");
    }

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE unique_id = ?");
        $stmt->bind_param("sssi", $username, $email, $hashedPassword, $unique_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE unique_id = ?");
        $stmt->bind_param("ssi", $username, $email, $unique_id);
    }

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        header("Location: ../Profile.php");
        exit();
    } else {
        echo "Update failed: " . $stmt->error;
    }
}
