<?php
include './PHP/menu.php';

$uniqueId = $_SESSION['unique_id'];

// Get user_id
$getUserSql = "SELECT unique_id FROM users WHERE unique_id = ?";
$getUserStmt = $conn->prepare($getUserSql);
$getUserStmt->bind_param("i", $uniqueId);
$getUserStmt->execute();
$getUserStmt->bind_result($user_id);
$getUserStmt->fetch();
$getUserStmt->close();

$sql = "SELECT mood, comment FROM mood_log WHERE created_at = ? AND user_id = ?";

// Date context
$year = (int)($_GET['year'] ?? date('Y'));
$month = (int)($_GET['month'] ?? date('n'));
$selectedDate = $_GET['date'] ?? date('Y-m-d');

// Month navigation
$prevMonth = $month == 1 ? 12 : $month - 1;
$prevYear  = $month == 1 ? $year - 1 : $year;
$nextMonth = $month == 12 ? 1 : $month + 1;
$nextYear  = $month == 12 ? $year + 1 : $year;

// Calendar metadata
$firstDay      = mktime(0, 0, 0, $month, 1, $year);
$daysInMonth   = date('t', $firstDay);
$monthName     = date('F', $firstDay);
$startDayIndex = date('w', $firstDay);

$selectedMood = '';
$selectedNote = 'No note for this date.';

$sql = "SELECT mood, comment FROM mood_log WHERE created_at = ? AND user_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("si", $selectedDate, $user_id); // "s" = string (date is a string like '2025-07-16')
    $stmt->execute();
    $stmt->bind_result($mood, $note);

    if ($stmt->fetch()) {
        $selectedMood = $mood;
        $selectedNote = $note;
    }

    $stmt->close();
} else {
    die("Prepare failed: " . $conn->error);
}

$conn->close();
/*
// Mood and note display
$selectedMood = $moodData[$selectedDate]['mood'] ?? '';
$selectedNote = $moodData[$selectedDate]['note'] ?? 'No note for this date.';
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/utility.css">
    <link rel="stylesheet" href="./CSS/history.css">
</head>

<body>


    <div class="container">
        <!-- Calendar Panel -->
        <div class="calendar">
            <h2 class="calendar-header">
                <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>" class="nav-arrow">&laquo;</a>
                <span class="month-label"><?= "$monthName $year" ?></span>
                <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="nav-arrow">&raquo;</a>
            </h2>

            <table>
                <tr>
                    <?php foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName): ?>
                        <th><?= $dayName ?></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php
                    $day = 1;
                    $cellCount = 0;

                    // Empty cells before 1st
                    for (; $cellCount < $startDayIndex; $cellCount++) {
                        echo "<td></td>";
                    }

                    // Days of the month
                    while ($day <= $daysInMonth) {
                        $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                        $classes = [];

                        if ($dateStr === date('Y-m-d')) $classes[] = 'today';
                        if ($dateStr === $selectedDate) $classes[] = 'selected';

                        echo "<td class='" . implode(' ', $classes) . "'>
                            <a href='?month=$month&year=$year&date=$dateStr'>$day</a>
                          </td>";

                        $day++;
                        $cellCount++;

                        if ($cellCount % 7 == 0 && $day <= $daysInMonth) {
                            echo "</tr><tr>";
                        }
                    }

                    // Fill remaining cells
                    while ($cellCount % 7 != 0) {
                        echo "<td></td>";
                        $cellCount++;
                    }
                    ?>
                </tr>
            </table>
        </div>

        <!-- Mood/Note Description -->
        <div class="description">
            <h3><?= date('F j, Y', strtotime($selectedDate)) ?></h3>
            <p><strong>Mood:</strong> <span class="mood"><?= $selectedMood ?: 'None' ?></span></p>
            <p><strong>Note:</strong><br><?= $selectedNote ?></p>
        </div>
    </div>

</body>

</html>