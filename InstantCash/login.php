<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST["Phone"];
    $password = $_POST["Password"];
    $loginType = $_POST["loginType"]; // Add this line to get the loginType from POST

    $servername = "localhost"; 
    $username_db = "root"; 
    $password_db = ""; 
    $dbname = "InstantCash"; 
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($loginType === "user") {
        $query = "SELECT * FROM user WHERE phone='$phone' AND password='$password'";
    } elseif ($loginType === "admin") {
        $query = "SELECT * FROM admin WHERE phone='$phone' AND password='$password'";
    }

    if (isset($query)) { // Check if $query is set before executing
        $result = $conn->query($query);
        if ($result && $result->num_rows == 1) {
            $user_data = $result->fetch_assoc();
            if ($loginType === "user") {
                $_SESSION["user_phone"] = $user_data["phone"];
                $_SESSION["user_password"] = $user_data["password"];
                header("Location: account.php");
                exit();
            } elseif ($loginType === "admin") {
                $_SESSION["admin_phone"] = $user_data["phone"];
                $_SESSION["admin_password"] = $user_data["password"];
                header("Location: admin_panel.php");
                exit();
            }
        } else {
            echo "Invalid login information. Try Again";
        }
    } else {
        echo "Invalid login type";
    }

    $conn->close();
}
?>

<?php
include('Front_end/front_login.php');
?>

