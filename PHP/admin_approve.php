<?php
session_start();
include_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../adminLogIn.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];

    if ($action === 'A') {
        // Approve consultant
        $stmt = $conn->prepare("UPDATE users SET is_approved = 1 WHERE unique_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } elseif ($action === 'D') {
        // Delete or reject consultant
        $stmt = $conn->prepare("DELETE FROM users WHERE unique_id = ? AND role = 'consultant' AND is_approved = 0");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
header("Location: ../admin_dashboard.php");
exit();
