<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "instantcash";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$phone = "01727618944"; 
$password = "232323";  

$sql = "SELECT * FROM admin WHERE role_id = (SELECT login_id FROM role WHERE first_name = 'Admin' AND last_name = 'User')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    if ($admin['role_id'] == 1 && $admin['admin_role'] == 'Super Admin' && $phone == "01727618944" && $password == "232323") {

        header("Location: admin_panel.php");
        exit();
    } else {
        echo "<h1>Access Denied</h1>";
    }
} else {
    echo "<h1>Admin not found</h1>";
}

$conn->close();
?>
