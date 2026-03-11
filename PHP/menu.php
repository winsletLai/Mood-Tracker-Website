<?php
session_start();

if (!isset($_SESSION['unique_id']) || !isset($_SESSION['is_approved']) || !isset($_SESSION['role']) || $_SESSION['is_approved'] == 0) {
    header("location: logIn.php");
    exit();
} else {
    include_once "./PHP/config.php";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/utility.css">
    <style>
        /* NAViGATION BAR */
        .menu {
            background-color: var(--DARKCO);
            color: var(--WHITECO);
            display: flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            max-height: 5vh;
            min-height: 80px;
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 5;
            font-family: var(--FF);
            padding: 10px;
        }

        .menu header {
            flex: 1;
            display: flex;
            flex-flow: row nowrap;
            align-items: center;
        }

        .menu header h1 {
            font-size: var(--FS-XL);
            align-self: center;
            display: inline-block;

        }

        .menu nav {
            text-transform: uppercase;
            flex: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu nav ul li a,
        .menu nav ul p {
            color: var(--WHITECO);
            display: inline-block;
            font-size: var(--FS);
            padding: 1rem;
            text-decoration: none;
        }

        .menu nav ul li {
            display: inline-block;
            list-style: none;
        }


        .menu .profile-img {
            width: 50px;
            height: 50px;
            border: whitesmoke 2px solid;
            border-radius: 50%;
            cursor: pointer;
        }

        .menu details {
            position: relative;
        }

        .menu details summary {
            list-style: none;
        }

        .menu details ul {
            list-style-type: none;
            position: absolute;
            left: unset;
            right: 0%;
            top: 80%;
            width: max-content;
            background-color: var(--BTNDARKCO);
            border-radius: 5%;
            overflow: hidden;
        }

        .menu details ul .info {
            color: var(--BTNCO);
            padding: 15px;
        }

        .menu details ul .info:hover {
            color: black;
            background-color: var(--BTNCO);
        }

        #log-out:hover {
            color: whitesmoke;
            background-color: #ff0000;
        }
    </style>
</head>

<body>
    <div class="menu">
        <header><img src="./Image/main/logo.png" alt="Logo" width="60" height="60">
            <h1>Medicare+</h1>
        </header>
        <nav>
            <ul>
                <li><a href="HomePage1.php">Home</a></li>
                <li><a href="History.php">History</a></li>
                <li><a href="Support.php">Support</a></li>
            </ul>
        </nav>
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']} ");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
        }
        ?>

        <details>
            <summary>
                <img src="./PHP/images/<?php echo $row['image']; ?>" class="profile-img" alt="profile"></a>
            </summary>
            <ul>
                <a href="Profile.php">
                    <li class="info">Profile</li>
                </a>
                <a href="./PHP/logOut.php">
                    <li class="info" id="log-out">Log Out</li>
                </a>
            </ul>
        </details>

    </div>
</body>

</html>