<?php
include './PHP/menu.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./CSS/user.css">

</head>


<body>

    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    <?php
                    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']} ");
                    if (mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    }
                    ?>
                    <img src="./PHP/images/<?php echo $row['image']; ?>" alt="">
                    <div class="details">
                        <span><?php echo $row['username']; ?></span>
                        <p><?php echo $row['status']; ?></p>
                    </div>
                </div>
            </header>
            <div class="search">
                <?php $current_role = $_SESSION['role'];
                if ($current_role === 'user') {
                    $interacter = 'consultant';
                } else {
                    $interacter = 'user';
                }
                ?>
                <span class="text">Select an <?php echo $interacter ?> to start chat</span>
                <input type="text" placeholder="Enter name to search...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">

            </div>
        </section>
        <script type="text/javascript" src="./JS/users.js"></script>
    </div>

</body>

</html>