<?php
include './PHP/menu.php';

$role = $_SESSION['role'];

$title = " Mental Health Consultant";
$description = "Speak privately with a trained mental wellness consultant anytime you need someone to talk to. All
                conversations are anonymous and confidential, so you can express yourself without fear or judgment.
                Whether you're feeling overwhelmed, anxious, or just need to vent — we're here to listen.";
if ($role === 'consultant') {
    $title = " User";
    $description = "You're connected with a user who may be feeling stressed, anxious, or in need of support. 
Respond with empathy and professionalism. Your role is to listen, guide, and provide a safe space for open conversation.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Support</title>
    <link rel="stylesheet" href="./CSS/support.css">

</head>

<body>
    <header>
        <h1 class="clip">Get Support</h1>
    </header>

    <div class="card">
        <div class="txt">
            <h1 class="clip">Chat with a<?= $title ?></h1>
            <p><?= $description ?></p>
        </div>
        <img src="./Image/support/consultant.png" class="img">
        <div class="btnArea">
            <a href="user.php">
                <button class="hover btn">
                    <img src="./Image/support/chatIcon.png">
                    <p>Chat Now</p>
                </button>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="txt">
            <h1 class="clip">Self-Help & Wellness Resources</h1>
            <p>Browse a curated collection of articles, videos, and tools to help you manage stress, improve sleep,
                build confidence, and take care of your emotional well-being. These resources are easy to understand,
                beginner-friendly, and designed to support your mental health journey — anytime, anywhere.</p>
        </div>
        <img src="./Image/support/selfCare.png" class="img">
        <div class="btnArea">
            <a href="HomePage3.php">
                <button class="hover btn">
                    <img src="./Image/support/chatIcon.png">
                    <p>Find Now</p>
                </button>
            </a>
        </div>
    </div>



</body>

</html>