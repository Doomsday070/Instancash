<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash in</title>
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

        select,
        input[type="text"],
        input[type="password"],
        input[type="submit"],
        input[type="number"] {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 100%;
            box-sizing: border-box; 
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .card-inputs {
            display: none;
        }

        .show-card-inputs {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cash in</h2>
        <form action="cashin.php" method="post">
            <div id="bankInputs" class="bank-inputs">
                <label for="bankName">Select Bank:</label>
                <select id="bankName" name="bankName">
                    <option value="bank1">Brac Bank</option>
                    <option value="bank2">Agrani Bank</option>
                    <option value="bank3">Dhaka Bank</option>
                    <option value="bank4">Bangladesh Bank</option>
                    <option value="bank5">AB Bank</option>
                    <option value="bank6">Sonali Bank</option>
                
                </select>
                <label for="bankAccountNumber">Bank Account Number:</label>
                <input type="text" id="bankAccountNumber" name="bankAccountNumber">
            </div>
            <div id="cardInputs" class="card-inputs">
                <label for="cardNumber">Card Number:</label>
                <input type="text" id="cardNumber" name="cardNumber">
                <label for="cvv">CVV:</label>
                <input type="password" id="cvv" name="cvv">
            </div>
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" min="0.01" step="0.01" required>
            <input type="submit" value="Next">
        </form>
    </div>

    <script>
        function showHideCardInputs() {
            var paymentMethod = document.getElementById("paymentMethod").value;
            var bankInputs = document.getElementById("bankInputs");
            var cardInputs = document.getElementById("cardInputs");

            if (paymentMethod === "bank") {
                bankInputs.style.display = "block";
                cardInputs.style.display = "none";
            } else if (paymentMethod === "card") {
                bankInputs.style.display = "none";
                cardInputs.style.display = "block";
            }
        }
    </script>
</body>
</html>
