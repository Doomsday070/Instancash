<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "instantcash";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql_members = "SELECT COUNT(*) as total_members FROM user";
$result_members = $conn->query($sql_members);
$row_members = $result_members->fetch_assoc();


$sql_cash_in = "SELECT SUM(amount) as total_cash_in FROM cash_in";
$result_cash_in = $conn->query($sql_cash_in);
$row_cash_in = $result_cash_in->fetch_assoc();

$sql_cash_out = "SELECT SUM(amount) as total_cash_out FROM cash_out";
$result_cash_out = $conn->query($sql_cash_out);
$row_cash_out = $result_cash_out->fetch_assoc();

$sql_history = "SELECT SUM(Amount) as total_history FROM history";
$result_history = $conn->query($sql_history);
$row_history = $result_history->fetch_assoc();

$total_transactions = $row_cash_in['total_cash_in'] + $row_cash_out['total_cash_out'] + $row_history['total_history'];


$sql_existing_users = "SELECT userid, phone, firstname, lastname, nid, email FROM user";
$result_existing_users = $conn->query($sql_existing_users);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #125A66;
            margin: 0;
            padding: 0;
            color: black;
        }

        .navbar {
            background-color: white;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .navbar a {
            margin: 0 15px;
            color: black;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
            margin: 10px auto;
            padding: 20px;
        }

        .box {
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .box img {
            max-width: 100%;
            margin-bottom: 15px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        .box-title {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="logout.php" class="logout-btn">Logout</a>
        <span class="ml-auto"><?php echo date("l, F j, Y, g:i a"); ?></span>
    </nav>

    <div class="container">
        <div class="row">
            <!-- Total Users Box -->
            <div class="col-md-3">
                <div class="box">
                    <img src="Assets/agent.jpg" alt="Total Users">
                    <h3 class="box-title">Total Users</h3>
                    <p><?php echo $row_members['total_members']; ?></p>
                </div>
            </div>

            <!-- Total Transactions Box -->
            <div class="col-md-3">
                <div class="box">
                    <img src="Assets/transaction.jpg" alt="Total Transactions">
                    <h3 class="box-title">Total Transactions</h3>
                    <p><?php echo $total_transactions; ?></p>
                </div>
            </div>

            <!-- Total Cash In Box -->
            <div class="col-md-3">
                <div class="box">
                    <img src="Assets/cashin.jpg" alt="Total Cash In">
                    <h3 class="box-title">Total Cash In</h3>
                    <p><?php echo $row_cash_in['total_cash_in']; ?></p>
                </div>
            </div>

            <!-- Total Cash Out Box -->
            <div class="col-md-3">
                <div class="box">
                    <img src="Assets/cashout.jpg" alt="Total Cash Out">
                    <h3 class="box-title">Total Cash Out</h3>
                    <p><?php echo $row_cash_out['total_cash_out']; ?></p>
                </div>
            </div>
        </div>

        <!-- User Description -->
        <div class="box">
            <h3 class="box-title">User Description</h3>
            <ul>
                <?php
                if ($result_existing_users && $result_existing_users->num_rows > 0) {
                    while ($row = $result_existing_users->fetch_assoc()) {
                        echo "<li>User ID: {$row['userid']}</li>";
                        echo "<li>Phone: {$row['phone']}</li>";
                        echo "<li>First Name: {$row['firstname']}</li>";
                        echo "<li>Last Name: {$row['lastname']}</li>";
                        echo "<li>NID: {$row['nid']}</li>";
                        echo "<li>Email: {$row['email']}</li>";
                        echo "<hr>"; // Adding a separator
                    }
                } else {
                    echo "<li>No existing users</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>
