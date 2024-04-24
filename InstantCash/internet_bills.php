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
$organization_id = $amount = $month =  $customer_no = "";
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form data
    $organization_id = mysqli_real_escape_string($conn, $_POST["organization_id"]);
    $organization_name = mysqli_real_escape_string($conn, $_POST["organization_name"]);
    $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
    $customer_no = mysqli_real_escape_string($conn, $_POST["customer_no"]);
    $month = mysqli_real_escape_string($conn, $_POST["month"]);
    $user_password = $_SESSION["user_password"];
    $entered_password = $_POST["password"];

    // Validate the user inputs 
    if (empty($organization_id) || empty($organization_name) || empty($amount) || empty($month) || empty($customer_no)) {
        $error_message = "Please fill in all fields.";
    }elseif ($entered_password != $user_password) {
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
        // Insert transaction record into history table with the organization name
        $transactionFrom = $user_phone;
        $transactionTo = $organization_name; // Use the organization name
        $transactionAmount = $amount;

        $insertTransactionQuery = "INSERT INTO history (transaction_type, transaction_from, transaction_to, amount) 
                                  VALUES ('Internet Bill', '$transactionFrom', '$transactionTo', '$transactionAmount')";

        if ($conn->query($insertTransactionQuery) === TRUE) {
            // Insert internet bill payment record into internet_bills table
            $insertinternetBillQuery = "INSERT INTO internet_bills (organization_id, organization_name, customer_no, amount, month) 
                                   VALUES ('$organization_id', '$organization_name', '$customer_no', '$amount', '$month')";

            if ($conn->query($insertinternetBillQuery) === TRUE) {
                // Update the total_received_amount for the specific organization
                $updateTotalReceivedAmountQuery = "UPDATE organization_bill SET total_received_amount = total_received_amount + '$amount' WHERE organization_id='$organization_id' AND billtype='internet_bills'";
                
                if ($conn->query($updateTotalReceivedAmountQuery) === TRUE) {
                    echo "<div class='message text-success'>Bill Paid Successfully!</div>";
                } else {
                    $error_message = "Error updating total_received_amount: " . $conn->error;
                }
            } else {
                $error_message = "Error inserting internet bill payment record: " . $conn->error;
            }
        } else {
            $error_message = "Error inserting transaction record: " . $conn->error;
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

<?php
include('Front_end/front_internet_bills.php');
?>


