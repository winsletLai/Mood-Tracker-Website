<?php
session_start();

include_once './PHP/config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Use MySQLi prepared statements properly
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result(); // <-- fetch result from stmt
    $admin = $result->fetch_assoc(); // <-- then get associative array

    if ($admin && $password === $admin['password']) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./CSS/adminLogIn.css">
    <title>Admin Login</title>

</head>

<body>

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form class="stackedForm" method="POST">
        <ul class="wrapper">
            <li style="--i:3;">
                <input required placeholder="UserID" type="text" name="username" class="input" />
            </li>
            <li style="--i:2;">
                <input name="password" required placeholder="Password" type="password" class="input" />
            </li>
            <button type="submit" style="--i:1;"><span>Submit</span></button>
        </ul>
    </form>

</body>

</html>