<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !isset($_SESSION['admin_username'])) {
    header("location: adminLogIn.php");
    exit();
}

include_once "./PHP/config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/utility.css">
    <link rel="stylesheet" href="./CSS/support.css">
    <link rel="stylesheet" href="./CSS/adminEdit.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>List</title>
</head>

<body>
    <header>
        <a href="admin_dashboard.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <h1 class="clip">Pending Consultant</h1>
    </header>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Approve</th>
        </tr>
        <?php
        $pending_query = mysqli_query($conn, "SELECT * FROM users WHERE role = 'consultant' AND is_approved = 0");
        while ($row = mysqli_fetch_assoc($pending_query)): ?>
            <tr>
                <td><?= $row['username'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><a class="button" id="Approve" href="./PHP/admin_approve.php?id=<?= $row['unique_id'] ?>&action=A"><i class="fa-regular fa-circle-check"></i></a>
                    <a class="button" id="Decline" href="./PHP/admin_approve.php?id=<?= $row['unique_id'] ?>&action=D"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>