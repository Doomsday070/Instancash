<?php
session_start();

if (!isset($_SESSION["user_phone"]) || !isset($_SESSION["user_password"])) {
    header("Location: login.php");
    exit;
}

$user_phone = $_SESSION["user_phone"];
$user_password = $_SESSION["user_password"]; 

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "InstantCash";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM account WHERE phone='$user_phone'";
$result = $conn->query($query);

$balance = "N/A"; 
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $balance = $row["balance"];
}

$recharge_success = $recharge_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rechargePhoneNumber = $_POST["rechargePhoneNumber"];
    $operator = $_POST["operator"];
    $rechargeAmount = $_POST["rechargeAmount"];
    $rechargePassword = $_POST["rechargePassword"]; // Get the entered password
    
    // Validate the recharge amount
    if ($rechargeAmount <= 0) {
        $recharge_error = "Recharge amount must be greater than 0 taka.";
    } elseif ($rechargeAmount > 10000) {
        $recharge_error = "Recharge amount cannot exceed 10,000 taka.";
    } else {
        // Validate the password
        if ($rechargePassword === $user_password) {
            if ($balance >= $rechargeAmount) {
                $newBalance = $balance - $rechargeAmount;
                
                $updateQuery = "UPDATE account SET balance = $newBalance WHERE phone = '$user_phone'";
                if ($conn->query($updateQuery) === TRUE) {
                    $balance = $newBalance;
                    
                    // Insert into mobile_recharge table
                    $insertRechargeQuery = "INSERT INTO mobile_recharge (user_phone, operator, phone_no, amount) 
                                            VALUES ('$user_phone', '$operator', '$rechargePhoneNumber', '$rechargeAmount')";
                    if ($conn->query($insertRechargeQuery) === TRUE) {
                        
                        // Insert into history table
                        $transactionType = "Mobile Recharge";
                        $transactionFrom = $user_phone;
                        $transactionTo = $rechargePhoneNumber;
                        $transactionAmount = $rechargeAmount;
                        
                        $insertHistoryQuery = "INSERT INTO history (transaction_type, transaction_from, transaction_to, amount) 
                                              VALUES ('$transactionType', '$transactionFrom', '$transactionTo', '$transactionAmount')";
                        
                        if ($conn->query($insertHistoryQuery) === TRUE) {
                            $recharge_success = "Mobile recharge successful!";
                        } else {
                            $recharge_error = "Error inserting into history table: " . $conn->error;
                        }
                    } else {
                        $recharge_error = "Error inserting recharge record: " . $conn->error;
                    }

                } else {
                    $recharge_error = "Error updating balance: " . $conn->error;
                }
            } else {
                $recharge_error = "Insufficient balance for recharge.";
            }
        } else {
            $recharge_error = "Invalid Password";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InstantCash - Mobile Recharge</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styles remain unchanged from the previous code */
    </style>
</head>
<body>
    <main class="container">
        <h2 class="lgn">Mobile Recharge</h2>
        <form action="mobilerecharge.php" method="post">
            <div class="form-group">
                <label for="rechargePhoneNumber">Phone Number:</label>
                <input type="text" class="form-control" id="rechargePhoneNumber" name="rechargePhoneNumber" required>
            </div>
            <div class="form-group">
                <label for="operator">Operator:</label>
                <select class="form-control" id="operator" name="operator" required>
                    <option value="">Select Operator</option>
                    <option value="Grameenphone">Grameenphone</option>
                    <option value="Robi">Robi</option>
                    <option value="Banglalink">Banglalink</option>
                    <option value="Airtel">Airtel</option>
                    <option value="Teletalk">Teletalk</option>
                </select>
            </div>
            <div class="form-group">
                <label for="rechargeAmount">Amount to Recharge:</label>
                <input type="number" class="form-control" id="rechargeAmount" name="rechargeAmount" required>
            </div>
            <div class="form-group">
                <label for="rechargePassword">Your Password:</label>
                <input type="password" class="form-control" id="rechargePassword" name="rechargePassword" required>
            </div>
            <button type="submit" class="btn btn-primary">Recharge</button>
        </form>

        <?php
        if (!empty($recharge_success)) {
            echo "<p class='message text-success'>$recharge_success</p>";
        } elseif (!empty($recharge_error)) {
            echo "<p class='message text-danger'>$recharge_error</p>";
        }
        ?>
    </main>

    <!-- Scripts remain unchanged from the previous code -->
</body>
</html>
