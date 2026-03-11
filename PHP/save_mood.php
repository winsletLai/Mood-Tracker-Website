<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uniqueId = $_SESSION['unique_id'];
    $mood = $_POST['mood'] ?? '';
    $comment = trim($_POST['comment'] ?? '');
    if ($comment === '') {
        $comment = 'No note provided.';
    }
    $dateToday = date('Y-m-d');

    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "mind_care");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get user_id from unique_id
    $getUserSql = "SELECT unique_id FROM users WHERE unique_id = ?";
    $getUserStmt = mysqli_prepare($conn, $getUserSql);
    mysqli_stmt_bind_param($getUserStmt, "i", $uniqueId);
    mysqli_stmt_execute($getUserStmt);
    mysqli_stmt_bind_result($getUserStmt, $userId);
    mysqli_stmt_fetch($getUserStmt);
    mysqli_stmt_close($getUserStmt);

    if (empty($userId)) {
        mysqli_close($conn);
        die("User not found.");
    }

    // Check if there's already a mood for today
    $checkSql = "SELECT mood_id FROM mood_log WHERE user_id = ? AND created_at = ?";
    $checkStmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "is", $userId, $dateToday);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_store_result($checkStmt);

    if (mysqli_stmt_num_rows($checkStmt) > 0) {
        // Update existing mood
        $updateSql = "UPDATE mood_log SET mood = ?, comment = ? WHERE user_id = ? AND created_at = ?";
        $updateStmt = mysqli_prepare($conn, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "ssis", $mood, $comment, $userId, $dateToday);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);
    } else {
        // Insert new mood
        $insertSql = "INSERT INTO mood_log (user_id, mood, comment, created_at) VALUES (?, ?, ?, ?)";
        $insertStmt = mysqli_prepare($conn, $insertSql);
        mysqli_stmt_bind_param($insertStmt, "isss", $userId, $mood, $comment, $dateToday);
        mysqli_stmt_execute($insertStmt);
        mysqli_stmt_close($insertStmt);
    }

    mysqli_stmt_close($checkStmt);
    mysqli_close($conn);

    // Redirect after saving
    header("Location: ../HomePage3.php");
    exit();
} else {
    echo "Invalid request.";
}
