<?php

session_start();
if (!isset($_SESSION['admin_logged_in']) || !isset($_SESSION['admin_username'])) {
    header("location: adminLogIn.php");
    exit();
}

include_once "./PHP/config.php";

$users_query = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All users</title>
    <link rel="stylesheet" href="./CSS/utility.css">
    <link rel="stylesheet" href="./CSS/support.css">
    <link rel="stylesheet" href="./CSS/adminEdit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>

    </style>
</head>

<body>
    <header>
        <a href="admin_dashboard.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <h1 class="clip">All users</h1>
    </header>
    <table>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Approved</th>
            <th>Edit</th>
        </tr>
        <?php while ($user = mysqli_fetch_assoc($users_query)): ?>
            <tr>
                <td><?= $user['unique_id'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['role'] ?></td>
                <td><?= $user['is_approved'] ? 'Yes' : 'No' ?></td>
                <td><a class="button" href="./PHP/admin_edit_user.php?id=<?= $user['unique_id'] ?>&action=E"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a class="button" id="Decline" href="./PHP/admin_edit_user.php?id=<?= $user['unique_id'] ?>&action=D"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>