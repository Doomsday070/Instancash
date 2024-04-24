<!DOCTYPE html>
<html>
<head>
    <title>Water Bill Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
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

        main {
            padding: 20px;
        }

        h2.lgn {
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

        form label {
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="password"],
        form input[type="number"],
        form select {
            width: 100%; /* Match width */
            padding: 10px; /* Match padding */
            margin-bottom: 15px; /* Match margin */
            border: 1px solid #ccc; /* Match border */
            border-radius: 4px; /* Match border-radius */
            box-sizing: border-box; /* Use box-sizing to include padding and border in the width */
        }

        /* Additional styles for the select element for consistency */
        form select {
            -webkit-appearance: none; /* Remove default styling */
            -moz-appearance: none; /* Remove default styling */
            appearance: none; /* Remove default styling */
            background: url('down-arrow-icon.png') no-repeat right; /* Add custom arrow icon */
            background-size: 12px 12px; /* Size of the custom arrow */
            padding-right: 30px; /* Adjust padding to make room for the arrow */
        }


        form button[type="submit"] {
            background-color: #125A66;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }

        form button[type="submit"]:hover {
            background-color: #0E4760;
        }

        .message {
            font-size: 18px;
            margin-top: 20px;
            text-align: center;
        }
        h1 {
        text-align: center; /* Center-align the h1 element */
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
    <script>
        var longPressTimer;

        function startPaybill() {
            // Start a timer for the long-press event
            longPressTimer = setTimeout(PayBill, 1000); // Adjust the duration (in milliseconds) as needed
            // Add the 'animated' class to apply the animation effect
            document.getElementById("Paybill_Button").classList.add("animated");
        }

        function stopPaybill() {
            // Clear the long-press timer when the button is released
            clearTimeout(longPressTimer);
            // Remove the 'animated' class to stop the animation effect
            document.getElementById("Paybill_Button").classList.remove("animated");
        }

        function PayBill() {
            // This function will be called when the button is long-pressed
            document.getElementById("Paybill_Button").disabled = true; // Disable the button to prevent multiple submissions
            document.forms[0].submit(); // Submit the form
        }
        function updateOrganizationName() {
            var select = document.getElementById('organization_id');
            var option = select.options[select.selectedIndex];
            var organizationName = option.text.includes('-') ? option.text.split(' - ')[1] : ''; // Extracts the name part
            document.getElementById('organization_name').value = organizationName;
        }
        function validatePassword(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length > 6) {
            input.value = input.value.slice(0, 6);
        }
        }
    </script>
</head>
<body>
    <h1>Water Bill </h1>
    <?php if (!empty($error_message)) { ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php } ?>
    <form action="water_bills.php" method="POST">
        <label for="organization_id">Organization:</label>
        <select id="organization_id" name="organization_id" onchange="updateOrganizationName()" required>
            <option value="">--Select a Organization--</option>
            <option value="222" <?php echo ($organization_id == '222') ? 'selected' : ''; ?>>222 - Dhaka Wasa</option>
            <option value="223" <?php echo ($organization_id == '223') ? 'selected' : ''; ?>>223 - Chattogram Wasa</option>
            <option value="224" <?php echo ($organization_id == '224') ? 'selected' : ''; ?>>224 - Khulna Wasa</option>
            <option value="225" <?php echo ($organization_id == '225') ? 'selected' : ''; ?>>225 - Rajshahi Wasa</option>
        </select>
        <input type="hidden" id="organization_name" name="organization_name">
        <br><br>

        <label for="customer_no">Customer_No:</label>
        <input type="text" id="customer_no" name="customer_no" value="<?php echo htmlspecialchars($customer_no); ?>" required><br><br>

        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" value="<?php echo htmlspecialchars($amount); ?>" required><br><br>

        <label for="month">Bill_Month:</label>
        <select id="month" name="month" required>
            <option value="">--Select a Month--</option>
            <option value="January" <?php echo ($month == 'January') ? 'selected' : ''; ?>>January 2024</option>
            <option value="February" <?php echo ($month == 'February') ? 'selected' : ''; ?>>February 2024</option>
            <option value="March" <?php echo ($month == 'March') ? 'selected' : ''; ?>>March 2024</option>
            <option value="April" <?php echo ($month == 'April') ? 'selected' : ''; ?>>April 2024</option>
            <option value="May" <?php echo ($month == 'May') ? 'selected' : ''; ?>>May 2024</option>
            <option value="June" <?php echo ($month == 'June') ? 'selected' : ''; ?>>June 2024</option>
            <option value="July" <?php echo ($month == 'July') ? 'selected' : ''; ?>>July 2024</option>
            <option value="August" <?php echo ($month == 'August') ? 'selected' : ''; ?>>August 2024</option>
            <option value="September" <?php echo ($month == 'September') ? 'selected' : ''; ?>>September 2024</option>
            <option value="October" <?php echo ($month == 'October') ? 'selected' : ''; ?>>October 2024</option>
            <option value="November" <?php echo ($month == 'November') ? 'selected' : ''; ?>>November 2024</option>
            <option value="December" <?php echo ($month == 'December') ? 'selected' : ''; ?>>December 2024</option>
        </select><br><br>

        
        <label for="password">Password:</label>
        <div class="form-group position-relative">
        <input type="password" class="form-control" name="password" id="password" pattern="\d{6}" title="6-digit number" maxlength="6" oninput="validatePassword(this)" required>
        </div>

        <button type="button" class="long-press-button" id="Paybill_Button" onmousedown="startPaybill()" onmouseup="stopPaybill()">Tap and Hold For Pay Bill</button>
    </form>
</body>
</html>
