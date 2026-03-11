<?php
session_start();

include_once "config.php";

$outgoing_id = $_SESSION['unique_id'];
$role = $_SESSION['role'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

$sql = "SELECT * FROM users WHERE unique_id != {$outgoing_id} AND (username LIKE '%{$searchTerm}%') AND role != '{$role}'";

$output = "";
$mainQuery = mysqli_query($conn, $sql);
if (mysqli_num_rows($mainQuery) > 0) {
    include_once "data.php";
} else {
    $output .= 'No user found related to your search term';
}

echo $output;

?>
<!---->