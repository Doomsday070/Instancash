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

$query = "SELECT * FROM account WHERE phone=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_phone);
$stmt->execute();
$result = $stmt->get_result();

$balance = "N/A"; 
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $balance = $row["balance"];
}

$send_success = $send_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sendAmount = $_POST["sendAmount"];
    $sendPassword = $_POST["sendPassword"]; // Get the entered password
    
    // Validate the send amount
    if ($sendAmount <= 0) {
        $send_error = "Send amount must be greater than 0 taka.";
    } elseif ($sendAmount > $balance) {
        $send_error = "Insufficient balance for sending.";
    } else {
        // Validate the password
        if ($sendPassword === $user_password) {
            // Update balance for sender
            $newBalanceSender = $balance - $sendAmount;
            $updateSenderQuery = "UPDATE account SET balance = ? WHERE phone = ?";
            $stmt = $conn->prepare($updateSenderQuery);
            $stmt->bind_param("ii", $newBalanceSender, $user_phone);
            
            if ($stmt->execute()) {
                // Get user ID
                $userQuery = "SELECT userid FROM user WHERE phone=?";
                $stmt = $conn->prepare($userQuery);
                $stmt->bind_param("i", $user_phone);
                $stmt->execute();
                $userResult = $stmt->get_result();

                if ($userResult->num_rows == 1) {
                    $userRow = $userResult->fetch_assoc();
                    $user_id = $userRow["userid"];

                    // Insert into send_money table
                    $insertSendMoneyQuery = "INSERT INTO send_money (transaction_time, send_to, amount, transaction_type, a_id) 
                                             VALUES (current_timestamp(), ?, ?, 'Mobile Recharge', ?)";
                    $stmt = $conn->prepare($insertSendMoneyQuery);
                    $stmt->bind_param("sii", $receiverPhone, $sendAmount, $user_id);
                    
                    // Get receiver phone number
                    $receiverPhone = $_POST["receiverPhone"];
                    
                    if ($stmt->execute()) {
                        // Insert transaction record for sender
                        $transactionTypeSender = "Send Money";
                        $transactionFromSender = $user_phone;
                        $transactionToSender = $receiverPhone;
                        $transactionAmountSender = $sendAmount;

                        $insertTransactionSenderQuery = "INSERT INTO history (transaction_type, transaction_from, transaction_to, amount) 
                                                  VALUES (?, ?, ?, ?)";
                        $stmt = $conn->prepare($insertTransactionSenderQuery);
                        $stmt->bind_param("sssi", $transactionTypeSender, $transactionFromSender, $transactionToSender, $transactionAmountSender);

                        if ($stmt->execute()) {
                            // Remaining code for updating receiver balance and inserting transaction record for receiver
                            // ...

                            $send_success = "Money sent successfully!";
                        } else {
                            $send_error = "Error inserting transaction record for sender: " . $stmt->error;
                        }
                    } else {
                        $send_error = "Error inserting into send_money table: " . $stmt->error;
                    }
                } else {
                    $send_error = "User not found.";
                }
            } else {
                $send_error = "Error updating sender balance: " . $stmt->error;
            }
        } else {
            $send_error = "Invalid Password";
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
    <title>InstantCash - Send Money</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styles remain unchanged from the previous code */
    </style>
</head>
<body>
    <main class="container">
        <h2 class="lgn">Send Money</h2>
        <form action="sendmoney.php" method="post">
            <div class="form-group">
                <label for="receiverPhone">Receiver Phone Number:</label>
                <input type="text" class="form-control" id="receiverPhone" name="receiverPhone" required>
            </div>
            <div class="form-group">
                <label for="sendAmount">Amount to Send:</label>
                <input type="number" class="form-control" id="sendAmount" name="sendAmount" required>
            </div>
            <div class="form-group">
                <label for="sendPassword">Your Password:</label>
                <input type="password" class="form-control" id="sendPassword" name="sendPassword" required>
            </div>
            <button type="submit" class="btn btn-primary">Send Money</button>
        </form>

        <?php
        if (!empty($send_success)) {
            echo "<p class='message text-success'>$send_success</p>";
        } elseif (!empty($send_error)) {
            echo "<p class='message text-danger'>$send_error</p>";
        }
        ?>
    </main>

    <!-- Scripts remain unchanged from the previous code -->
</body>
</html>
