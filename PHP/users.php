<?php
session_start();

include_once "config.php";

$outgoing_id = $_SESSION['unique_id'];
$role = $_SESSION['role'];
$sql = "SELECT * FROM users WHERE unique_id != {$outgoing_id} AND role != '{$role}' AND is_approved = 1";

$mainQuery = mysqli_query($conn, $sql);
$output = "";

if (mysqli_num_rows($mainQuery) == 0) {
    $output .= "No users are available to chat";
} elseif (mysqli_num_rows($mainQuery) > 0) {
    include "data.php";
}
echo $output;

?>
<!---->