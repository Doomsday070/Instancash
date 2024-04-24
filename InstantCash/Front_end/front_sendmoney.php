<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Money</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"],
        input[type="submit"] {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 100%;
            box-sizing: border-box; /* Include padding and border in the element's total width */
        }

        input[type="submit"] {
            margin-top: 10px; /* Add some space between input fields and the submit button */
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Send Money</h2>
        <form action="send_money.php" method="post">
            <label for="account_number">Account Number:</label>
            <input type="text" id="account_number" name="account_number" required>
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" min="0.01" step="0.01" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Send Money">
        </form>
    </div>
</body>
</html>
