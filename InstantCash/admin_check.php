<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "instantcash";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is admin
$phone = "01727618944"; // Example phone number
$password = "232323";  // Example password

$sql = "SELECT * FROM admin WHERE role_id = (SELECT login_id FROM role WHERE first_name = 'Admin' AND last_name = 'User')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    if ($admin['role_id'] == 1 && $admin['admin_role'] == 'Super Admin' && $phone == "01727618944" && $password == "232323") {
        // Redirect to admin panel
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
