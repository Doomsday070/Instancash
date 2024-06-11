<?php
session_start();


if (!isset($_SESSION["user_phone"])) {
    header("Location: login.php");
    exit;
}

$loggedInUserPhone = $_SESSION["user_phone"];

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "InstantCash";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$first_name = "";
$last_name = ""; 


$query = "SELECT firstname FROM user WHERE phone = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $loggedInUserPhone);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error fetching user's first name: " . $conn->error);
}

if ($result->num_rows == 1) {
    $user_data = $result->fetch_assoc();
    $first_name = $user_data["firstname"];
}


$query = "SELECT lastname FROM user WHERE phone = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $loggedInUserPhone);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    die("Error fetching user's last name: " . $conn->error);
}

if ($result->num_rows == 1) {
    $user_data = $result->fetch_assoc();
    $last_name = $user_data["lastname"];
}




$conn->close();
?>

<?php
include('Front_end/front_account.php');
?>
