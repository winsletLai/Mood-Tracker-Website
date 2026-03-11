<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !isset($_SESSION['admin_username'])) {
    header("location: adminLogIn.php");
}

include_once "./PHP/config.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./CSS/support.css">
    <link rel="stylesheet" href="./CSS/utility.css">
    <style>
        #number {
            color: var(--DARKCO);
            font-size: 150px;
            margin-top: 60px;
        }

        form {
            width: 100%;
            display: grid;
            justify-items: center;
            padding-bottom: 10px;
        }

        #logOut {
            padding: 0.5em;
            padding-left: 1.1em;
            padding-right: 1.1em;
            border-radius: 15px;
            font-size: 40px;
            border: none;
            outline: none;
            transition: .4s ease-in-out;
            background-color: red;
            color: white;
        }

        #logOut:hover {
            background-color: black;
            color: white;
            cursor: pointer;
        }
    </style>


</head>

<body>
    <header>
        <h1 class="clip">Admin Dashboard</h1>
        <h2 style="color:var(--BTNDARKCO)">Welcome, <?php echo $_SESSION['admin_username']; ?>!</h2>
    </header>

    <div class=" card">
        <div class="txt">
            <h1 class="clip">Pending Consultant</h1>
            <?php
            $sql = "SELECT COUNT('unique_id') AS 'number' FROM users WHERE is_approved = false";
            $query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($query);
            (mysqli_num_rows($query) > 0) ? $number = $row['number'] : $number = "No message availble";
            ?>
            <p id="number"><?= $number ?></p>

        </div>
        <img src="./Image/admin/time.png" class="img">
        <div class="btnArea">
            <a href="consultant_list.php" target="_blank">
                <button class="hover btn">
                    <img src="./Image/admin/confirmation.png">
                    <p>Approve Now</p>
                </button>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="txt">
            <h1 class="clip">View user's data</h1>
            <?php
            $sql = "SELECT COUNT('unique_id') AS 'number' FROM users";
            $query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($query);
            (mysqli_num_rows($query) > 0) ? $number = $row['number'] : $number = "No message availble";
            ?>
            <p id="number"><?= $number ?></p>

        </div>
        <img src="./Image/admin/user.png" class="img">
        <div class="btnArea">
            <a href="users_list.php" target="_blank">
                <button class="hover btn">
                    <img src="./Image/admin/docs.png" height="40px">
                    <p>View Users</p>
                </button>
            </a>
        </div>
    </div>

    <form method="POST">
        <button type="submit" name="logout" id="logOut">Log Out</button>
    </form>
    <?php

    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("Location: adminLogIn.php");
        exit();
    }
    ?>



</body>

</html>