<?php
session_start();

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "InstantCash";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_phone = $_SESSION["user_phone"];
$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $select_history_sql = "SELECT * FROM history 
                            WHERE (transaction_from = '$user_phone' OR transaction_to = '$user_phone')
                            AND (transaction_from LIKE '%$search%' OR transaction_to LIKE '%$search%')
                            ORDER BY timestamp DESC";
} else {
    $select_history_sql = "SELECT * FROM history WHERE transaction_from = '$user_phone' OR transaction_to = '$user_phone' ORDER BY timestamp DESC";
}

$history_result = $conn->query($select_history_sql);

function highlightText($text, $search) {
    return str_ireplace($search, '<span class="highlighted">' . $search . '</span>', $text);
}

$amount = $bankName = $accountNumber = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
    $bankName = mysqli_real_escape_string($conn, $_POST["bankName"]);
    $accountNumber = mysqli_real_escape_string($conn, $_POST["accountNumber"]);

    $transaction_id = "";  // This will be auto-generated due to auto-increment

    if ($amount <= 0) {
        $error_message = "Invalid Amount";
    } else {
        $update_user_balance_sql = "UPDATE account SET balance = balance + '$amount' WHERE phone = '$user_phone'";
        
        if ($conn->query($update_user_balance_sql) === TRUE) {
            $insert_cash_in_sql = "INSERT INTO cash_in (transaction_id, phone_number, amount, b_id) VALUES (NULL, '$user_phone', '$amount', 1)";
            
            if ($conn->query($insert_cash_in_sql) === TRUE) {
                $transaction_id = $conn->insert_id; // Get the auto-generated transaction_id
                
                $insert_history_sql = "INSERT INTO history (transaction_id, transaction_from, transaction_to, transaction_type, Amount) 
                                       VALUES ('$transaction_id', 'Bank', '$user_phone', 'Cash In', '$amount')";
                
                if ($conn->query($insert_history_sql) === TRUE) {
                    echo "<div class='message text-success'>Deposit Successful!</div>";
                } else {
                    $error_message = "Error inserting into history table: " . $conn->error;
                }
            } else {
                $error_message = "Error inserting into cash_in table: " . $conn->error;
            }
        } else {
            $error_message = "Error updating user's balance: " . $conn->error;
        }
    }
}

$conn->close();
?>

<?php
include('Front_end/front_history.php');
?>

