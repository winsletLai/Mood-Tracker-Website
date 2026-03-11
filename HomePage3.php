<?php
include './PHP/menu.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self-Care</title>
    <link rel="stylesheet" href="./CSS/utility.css">
    <link rel="stylesheet" href="./CSS/home.css">
</head>

<body>

    <?php
    $endOfDay = strtotime('today 23:59:59');
    $tasks = [
        "task_drink" => "Drink Water",
        "task_journal" => "Write Journal",
        "task_sleep" => "Sleep Early",
        "task_read" => "Read a Chapter",
        "task_walk" => "Take a Short Walk"
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        foreach ($tasks as $key => $label) {
            $isChecked = isset($_POST[$key]);
            setcookie($key, $isChecked ? '1' : '', $endOfDay);
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    ?>
    <div class="txtTitle">
        <div class="header">
            <h1 class="clip">Self-Care</h1>
        </div>
    </div>

    <div class="selfcareContent">
        <div class="selfcareGrid">
            <div class="selfcareBox1">
                <h2>Take a breather</h2>
                <div class="left_subbox">
                    <a class="list" href="https://www.youtube.com/watch?v=inpok4MKVLM&t=1s" target="_blank">
                        <img src="./Image/home/meditation.png" alt="Meditation" class="icon">
                        <div class="card-title">Meditation-5min</div>
                        <span class="desc">Calm your mind and breathe deeply.</span>
                    </a>
                    <a class="list" href="https://www.youtube.com/watch?v=kpSkoXRrZnE" target="_blank">
                        <img src="./Image/home/breathing.png" alt="breathing" class="icon">
                        <div class="card-title">Breathing Exercise</div>
                        <span class="desc">A quick breathing reset for relaxation.</span>
                    </a>
                    <a class="list" href="https://www.youtube.com/watch?v=--MkR05FlII" target="_blank">
                        <img src="./Image/home/hand.png" alt="hand" class="icon">
                        <div class="card-title">Finger Stretching</div>
                        <span class="desc">Loosen up tension in your hands.</span>
                    </a>
                    <a class="list" href="https://www.youtube.com/watch?v=5D86b45yJzU" target="_blank">
                        <img src="./Image/home/foot.png" alt="foot" class="icon">
                        <div class="card-title">Foot & Leg Exercise</div>
                        <span class="desc">Move your lower body gently.</span>
                    </a>
                    <a class="list" href="https://www.youtube.com/watch?v=cI4ryatVkKw&list=RDcI4ryatVkKw&start_radio=1" target="_blank">
                        <img src="./Image/home/music.png" alt="music" class="icon">
                        <div class="card-title">Calming Muisc-3min</div>
                        <span class="desc">Let soothing sounds relax your nerves.</span>
                    </a>
                    <a class="list" href="https://www.youtube.com/watch?v=mLYm4ItAuro" target="_blank">
                        <img src="./Image/home/smile.png" alt="smile" class="icon">
                        <div class="card-title">Smile Fish Face</div>
                        <span class="desc">Lift your mood with silly stretches.</span>
                    </a>
                </div>
            </div>

            <div class="selfcareBox2">
                <h2>Daily Checklist</h2>

                <form method="post" onchange="this.submit()">
                    <?php foreach ($tasks as $key => $label) : ?>
                        <div class="list">
                            <label>
                                <input type="checkbox" id="<?= $key ?>" name="<?= $key ?>" <?= (isset($_COOKIE[$key]) && $_COOKIE[$key] === '1') ? 'checked' : '' ?>>
                                <label for="<?= $key ?>"><?= htmlspecialchars($label) ?></label>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
        </div>

</body>

</html>