<?php
include './PHP/menu.php';


$unique_id = $_SESSION['unique_id'];

$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$unique_id}");

if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
} else {
    echo "User not found.";
    exit();
}

$username = $row['username'];
$email = $row['email'];
$password = $row['password'];
$aboutMe = file_exists('./data/aboutme.txt') ? file_get_contents('./data/aboutme.txt') : '';
$note = file_exists('./data/note.txt') ? file_get_contents('./data/note.txt') : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self-Care</title>
    <link rel="stylesheet" href="./CSS/utility.css">
    <link rel="stylesheet" href="./CSS/profile.css">
</head>

<body>


    <div class="profileBox1">
        <div class="profileText">
            <h1>Hi, <span><?php echo $row['username']; ?></span>!</h1>
            <p class="description">You seem even cuter today than you were yesterday</p>
        </div>
        <div class="profileImgContainer">
            <form id="uploadForm" method="post" enctype="multipart/form-data" action="./PHP/upload_avatar.php">
                <label for="avatarInput">
                    <img src="./PHP/images/<?php echo $row['image']; ?>" alt="avatar" class="avatarPreview" />
                </label>
                <input type="file" name="avatar" id="avatarInput" accept="image/*" onchange="submitUpload()" hidden />
            </form>
        </div>
    </div>

    <form method="post" action="./PHP/save_profile.php">
        <div class="content">
            <div class="profileBox2_left">
                <label>About ME: </label><br />
                <div class="inputWithSave">
                    <textarea name="aboutme" placeholder="Enter About Me"><?= htmlspecialchars($aboutMe) ?><?php if ($row['about_me'] != null) {
                                                                                                                echo $row['about_me'];
                                                                                                            } ?></textarea><br />
                    <button class="saveBtnMini" name="action" value="save_about" title="Save About Me">💾</button>
                </div>

                <label>Note: </label><br />
                <div class="inputWithSave">
                    <textarea name="note" placeholder="Enter Note"><?= htmlspecialchars($note) ?><?php if ($row['note'] != null) {
                                                                                                        echo $row['note'];
                                                                                                    } ?></textarea>
                    <button class="saveBtnMini" name="action" value="save_note" title="Save Note">💾</button>
                </div>
            </div>

            <div class="profileBox2_right">
                <label>Username: </label>
                <div class="inputWithSave">
                    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
                </div>


                <label>Password: </label>
                <div class="inputWithSave">
                    <input type="password" name="password" placeholder="Enter new password">
                </div>

                <label>Email: </label>
                <div class="inputWithSave">
                    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
                </div>

                <button class="saveBtnMini" name="action" value="save_account">Save All 💾</button>
            </div>
        </div>
    </form>

    <script>
        function submitUpload() {
            document.getElementById('uploadForm').submit();
        }
    </script>

</body>

</html>