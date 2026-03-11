<?php
include './PHP/menu.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Check-In</title>
    <link rel="stylesheet" href="./CSS/utility.css">
    <link rel="stylesheet" href="./CSS/home.css">
    <link rel="stylesheet" href="./CSS/emoji/angry.css">
    <link rel="stylesheet" href="./CSS/emoji/sad.css">
    <link rel="stylesheet" href="./CSS/emoji/surprise.css">
    <link rel="stylesheet" href="./CSS/emoji/smile.css">
    <link rel="stylesheet" href="./CSS/emoji/happy.css">


</head>

<body>
    <div class="txtTitle">
        <div class="header">
            <h1 class="clip">Mood Check-In</h1>
        </div>
        <p>How are you feeling today</p>
    </div>

    <form method="post" action="./PHP/save_mood.php">
        <input type="hidden" name="mood" id="moodInput" value="">

        <!--emoji row-->
        <div class="emoji-row">
            <button type="button" class="emoji-button" onclick="selectMood('angry', event)">
                <!--angry-->
                <div class="emoji_angry">
                    <div class="face">
                        <div class="eyebrow_angry">
                            <span></span>
                            <span></span>
                        </div>
                        <div class="eye_angry">
                            <span></span>
                            <span></span>
                        </div>
                        <div class="mouth_angry"></div>
                    </div>
                </div>
            </button>

            <!--sad-->
            <button type="button" class="emoji-button" onclick="selectMood('sad', event)">
                <div class="emoji_sad">
                    <div class="face_sad">
                        <div class="eyebrow_sad">
                            <span class="left"></span>
                            <span class="right"></span>
                        </div>
                        <div class="eye_sad"></div>
                        <div class="mouth_sad"></div>
                    </div>
                </div>
            </button>

            <!--surprise-->
            <button type="button" class="emoji-button" onclick="selectMood('surprise', event)">
                <div class="emoji_surprise">
                    <div class="face_surprise">
                        <div class="eyebrow_surprise">
                            <span></span>
                            <span></span>
                        </div>
                        <div class="eye_surprise">
                            <span></span>
                            <span></span>
                        </div>
                        <div class="mouth_surprise"></div>
                    </div>
                </div>
            </button>

            <!--smile-->
            <button type="button" class="emoji-button" onclick="selectMood('smile', event)">
                <div class="emoji_smile">
                    <div class="face_smile">
                        <div class="eyebrow_smile"></div>
                        <div class="mouth_smile"></div>
                        <div class="blush_smile left"></div>
                        <div class="blush_smile right"></div>
                    </div>
                </div>
            </button>

            <!--happy-->
            <button type="button" class="emoji-button" onclick="selectMood('happy', event)">
                <div class="emoji_happy">
                    <div class="face_happy">
                        <div class="eye_happy">
                            <span class="left"></span>
                            <span class="right"></span>
                        </div>
                        <div class="mouth_happy">
                            <div class="tongue_happy"></div>
                        </div>
                    </div>
                </div>
            </button>
        </div>

        <!--textarea-->
        <div class="textbox">
            <textarea name="comment" rows="5" placeholder="Optional Note..."></textarea>
        </div>

        <div class="btnDone">
            <div class="btnArea">
                <button type="submit" class="hover btn">
                    <p>Done</p>
                </button>
            </div>
        </div>
    </form>



    <?php
    $userId = $_SESSION['unique_id'];
    ?>

    <script>
        function selectMood(mood, event) {
            document.getElementById('moodInput').value = mood;

            const buttons = document.querySelectorAll('.emoji-button');
            buttons.forEach(btn => btn.classList.remove('selected'));

            event.currentTarget.classList.add('selected');
        }
    </script>
</body>

</html>