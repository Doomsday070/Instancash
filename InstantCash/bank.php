<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_phone"]) || !isset($_SESSION["user_password"])) {
    header("Location: login.php");
    exit;
}

// Define database connection parameters
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "InstantCash";

// Create a database connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to hold form data
$amount = $bankName = $accountNumber = "";
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form data
    $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
    $bankName = mysqli_real_escape_string($conn, $_POST["bankName"]);
    $accountNumber = mysqli_real_escape_string($conn, $_POST["accountNumber"]);

    // Generate a unique transaction_ids
    $transaction_ids = uniqid();

    // Validate the amount
    if ($amount <= 0) {
        $error_message = "Invalid Amount";
    } else {
        // Get the user's phone number
        $user_phone = $_SESSION["user_phone"];

        // Update user's balance
        $update_user_balance_sql = "UPDATE account SET balance = balance + '$amount' WHERE phone = '$user_phone'";
        if ($conn->query($update_user_balance_sql) === TRUE) {
            echo "<div class='message text-success'>Deposit Successful!</div>";
        } else {
            $error_message = "Error updating user's balance: " . $conn->error;
        }

        // Insert into cash_in table
        $insert_cash_in_sql = "INSERT INTO cash_in (transaction_ids, phone_number, amount, b_id) VALUES ('$transaction_ids', '$user_phone', '$amount', 1)";
        if ($conn->query($insert_cash_in_sql) === TRUE) {
            echo "Deposit Successful!";
        } else {
            echo "Error inserting into cash_in table: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Deposit - Bank</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        main {
            padding: 20px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="number"],
        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #125A66;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }

        button[type="submit"]:hover {
            background-color: #0E4760;
        }

        .message {
            font-size: 18px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <main>
        <h2>Cash Deposit - Bank</h2>
        <?php if (!empty($error_message)) { ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php } ?>
        <form action="bank.php" method="POST">
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" required><br><br>
            <label for="bankName">Choose Bank:</label>
            <select id="bankName" name="bankName">
                <option value="Brac Bank">Brac Bank</option>
                <option value="Agrani Bank">Agrani Bank</option>
                <option value="Dhaka Bank">Dhaka Bank</option>
                <option value="Bangladesh Bank">Bangladesh Bank</option>
                <option value="AB Bank">AB Bank</option>
                <option value="Sonali Bank">Sonali Bank</option>
            </select><br><br>
            <label for="accountNumber">Account Number:</label>
            <input type="text" id="accountNumber" name="accountNumber" required><br><br>
            <button type="submit">Deposit</button>
        </form>
    </main>
</body>
</html>