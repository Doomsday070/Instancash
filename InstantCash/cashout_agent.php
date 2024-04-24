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
$Agent_number = $amount = "";
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form data
    $Agent_number = mysqli_real_escape_string($conn, $_POST["Agent_number"]);
    $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
    $user_password = $_SESSION["user_password"];
    $entered_password = $_POST["password"];

    // Validate the user inputs 
    if (empty($Agent_number) || empty($amount)) {
        $error_message = "Please fill in all fields.";
    } elseif ($entered_password != $user_password) {
        $error_message = "Invalid password";
    } elseif ($amount <= 0) {
        $error_message = "Invalid Amount";
    } else {
        // Check user's balance
        $user_phone = $_SESSION["user_phone"];
        $user_balance_sql = "SELECT balance FROM account WHERE phone='$user_phone'";
        $user_balance_result = $conn->query($user_balance_sql);

        if ($user_balance_result->num_rows > 0) {
            $user_row = $user_balance_result->fetch_assoc();
            $user_balance = $user_row["balance"];

            // Check if user has enough balance for the payment
            if ($user_balance >= $amount) {
                // Update user's balance
                $new_user_balance = $user_balance - $amount;
                $update_user_balance_sql = "UPDATE account SET balance='$new_user_balance' WHERE phone='$user_phone'";
                
                if ($conn->query($update_user_balance_sql) === TRUE) {
                    // Generate a random unique transaction ID
                    $transaction_id = uniqid();

                    // Insert transaction record into cash_out table
                    $insertCashOutQuery = "INSERT INTO cash_out (transaction_id, transaction_time, amount, b_id) 
                                           VALUES ('$transaction_id', current_timestamp(), '$amount', (SELECT phone FROM account WHERE phone='$user_phone'))";

                    if ($conn->query($insertCashOutQuery) === TRUE) {
                        echo "<div class='message text-success'>Cash-out successful!</div>";
                    } else {
                        $error_message = "Error inserting cash-out record: " . $conn->error;
                    }
                } else {
                    $error_message = "Error updating user's balance: " . $conn->error;
                }
            } else {
                $error_message = "Insufficient balance.";
            }
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
    <title>Cash Out</title>
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

        input[type="text"],
        input[type="password"],
        input[type="number"],
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

        /* Additional styles from Gas Bill Payment code */
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

        .long-press-button {
            background-color: #125A66;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
            transition: background-color 0.3s ease-in-out; /* Add a transition effect */
        }

        /* Add a class for the animation effect */
        .animated {
            animation: pulse 0.5s infinite alternate; /* Define the animation properties */
        }

        /* Define the keyframes for the animation */
        @keyframes pulse {
            0% {
                transform: scale(1); /* Initial scale */
            }
            100% {
                transform: scale(1.1); /* Scale up */
            }
        }
    </style>
</head>
<body>
    <main>
        <h2>Cash Out - Agent</h2>
        <?php if (!empty($error_message)) { ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="Agent_number">Agent Number:</label>
            <input type="text" id="agent_number" name="Agent_number" required><br><br>
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" step="0.01" min="0.01" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Cash Out</button>
        </form>
    </main>
</body>
</html>
</html>

