<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wpoets_test";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$tab_id = (int)$_GET['tab_id'];
$query = "SELECT image FROM slides WHERE tab_id = $tab_id LIMIT 1";
$result = mysqli_query($conn, $query);
$slide = mysqli_fetch_assoc($result);
header('Content-Type: application/json');
echo json_encode($slide);
mysqli_close($conn);
?>