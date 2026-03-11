<?
session_start();

if (!isset($_SESSION['unique_id']) || !isset($_SESSION['is_approved']) || !isset($_SESSION['role']) || $_SESSION['is_approved'] == 0) {
    header("location: logIn.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./CSS/utility.css">
    <link rel="stylesheet" href="./CSS/home.css">
    <style>
        .advertisement {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .adList {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .ad {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.8s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease;
        }

        .ad.active {
            pointer-events: auto;
            opacity: 1;
            z-index: 1;
        }

        .ad:nth-child(1).active {
            background: url('./Image/home/background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .ad:nth-child(2) {
            background-color: black;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .bgVideo {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 16px;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.1);
            z-index: -1;
        }

        .volume-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            z-index: 2;
            font-size: 24px;
            padding: 10px 16px;
            border: none;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .volume-btn:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .arrows {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
            transform: translateY(-50%);
            z-index: 10;
        }

        .arrows button {
            font-size: 32px;
            width: 60px;
            height: 60px;
            color: white;
            background-color: rgba(0, 0, 0, 0.4);
            border: none;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .arrows button:hover {
            background-color: rgba(0, 0, 0, 0.6);
        }
    </style>
</head>

<body>
    <section class="advertisement">
        <div class="adList">
            <!-- Page1: Welcome -->
            <div class="ad active">
                <div class="imgLogo">
                    <img src="./Image/main/logo.png">
                </div>

                <div class="header">
                    <h1 class="clip">Welcome to MEDICARE+</h1>
                </div>

                <div class="description">
                    <p>MEDICARE+ is a gentle wellness app that helps you easily practice daily mind and body healing.</p>
                </div>

                <div class="date">
                    <?php echo date("j F Y") . "<br>"; ?>
                </div>

                <div class="btnArea">

                    <a href="HomePage2.php">
                        <button class="btn">Check In</button>
                    </a>
                </div>
            </div>

            <!-- Page2:Video-->
            <div class="ad">
                <video id="bgVideo" autoplay muted loop class="bgVideo">
                    <source src="./Video/medicare.mp4" type="video/mp4">
                    Your browser does not support the video tag
                </video>
                <button id="volumeToggle" class="volume-btn">🔇</button>
            </div>
        </div>

        <div class="arrows">
            <button id="prev" class="hover">&lt;</button>
            <button id="next" class="hover">&gt;</button>
        </div>
    </section>

    <script>
        let ads = document.querySelectorAll('.advertisement .adList .ad');
        let next = document.getElementById('next');
        let prev = document.getElementById('prev');
        let countAd = ads.length;
        let adActive = 0;

        function showAdvertisement() {
            document.querySelector('.advertisement .ad.active').classList.remove('active');
            ads[adActive].classList.add('active');
        }

        next.onclick = () => {
            adActive = (adActive + 1) % countAd;
            showAdvertisement();
        };

        prev.onclick = () => {
            adActive = (adActive - 1 + countAd) % countAd;
            showAdvertisement();
        };

        const video = document.getElementById('bgVideo');
        const volumeToggle = document.getElementById('volumeToggle');

        volumeToggle.textContent = video.muted ? '🔇' : '🔊';

        volumeToggle.addEventListener('click', () => {
            video.muted = !video.muted;
            volumeToggle.textContent = video.muted ? '🔇' : '🔊';
        });
    </script>

</body>

</html>