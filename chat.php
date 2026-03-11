<?php
include './PHP/menu.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./CSS/user.css">
    <link rel="stylesheet" href="./CSS/chats.css">
    <title>Chat</title>
</head>

<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>

                <?php
                $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

                $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");

                if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_assoc($sql);
                } else {
                    header("location: users.php");
                }
                ?>

                <a href="user.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="./PHP/images/<?php echo $row['image']; ?>" alt="">
                <div class="details">
                    <span><?php echo $row['username']; ?></span>
                    <p><?php echo $row['status']; ?></p>
                </div>
            </header>
            <div class="chat-box">

            </div>
            <form action="#" class="typing-area">
                <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id ?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                <button><i class="fa-solid fa-paper-plane"></i></button>


            </form>
        </section>
    </div>

    <script src="./JS/chat.js"></script>
</body>

</html>