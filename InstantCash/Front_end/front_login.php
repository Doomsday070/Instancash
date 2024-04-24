<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Tilt Prism', sans-serif;
            background-color: #ffffff; 
            margin: 0;
            padding: 0;
            color: black; 
        }
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .navbar a {
            margin: 0 15px;
            color: #125A66; 
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 40px;
            background-color: #125A66; 
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            max-width: 900px;
            width: 100%;
        }
        .logo {
            max-width: 400px;
            height: auto;
        }
        .form-container {
            flex: 1;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }
        .form-control {
            border-radius: 8px;
            background-color: white; 
            color: #125A66; 
            width: 100%;
        }
        .btn-primary {
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 18px;
        }
        .text-center {
            text-align: center;
            color: white; 
        }
        .text-center a {
            color: #00ccff; 
            text-decoration: none;
        }
        .text-center a:hover {
            text-decoration: underline;
        }
        .centered-text {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 400px;
            height: auto;
            animation: fadeInUp 1s ease-in-out;
        }
        .welcome {
            animation: fadeInDown 1s ease-in-out;
        }
        .slogan {
            animation: fadeInUp 1s ease-in-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="http://localhost/InstantCash/admin_login.php">InstantCash</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><span id="local-time" class="nav-link"></span></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="content">
            <img src="assets/mw.jpg" alt="InstantCash Logo" class="logo">
            <div class="form-container">
                <div class="centered-text">
                    <h1 class="welcome" style="color:white">Welcome to InstantCash</h1>
                    <p class="slogan" style="color:white">Your financial solution for easy transactions.</p>
                </div>
                
                <form action="login.php" method="post" style="width: 100%;">
                    <div class="form-group">
                        <label for="phone" style="color:white">Phone No:</label>
                        <input type="text" class="form-control" id="phone" name="Phone" placeholder="Enter your Phone No." maxlength="11" oninput="validateNumber(this)" required>
                    </div>
                    <div class="form-group position-relative">
                        <label for="password" style="color:white">Password:</label>
                        <input type="password" class="form-control" name="Password" id="password" placeholder="Enter your Password" pattern="\d{6}" title="6-digit number" maxlength="6" oninput="validatePassword(this)" required>
                        <i onclick="togglePasswordVisibility()" class="toggle-password" style="position: absolute; right: 10px; top: 75%; transform: translateY(-50%); cursor: pointer;">👁</i>
                    </div>
                    <div class="form-group">
                        <label style="color:white">Login As:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="loginType" id="userRadio" value="user" checked>
                            <label class="form-check-label" for="userRadio">
                                User
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="loginType" id="adminRadio" value="admin">
                            <label class="form-check-label" for="adminRadio">
                                Admin
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>

                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="http://localhost/InstantCash/signup.php">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function validateNumber(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
            if (input.value.length > 11) {
                input.value = input.value.slice(0, 11);
            }
        }
        
        function validatePassword(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
            if (input.value.length > 6) {
                input.value = input.value.slice(0, 6);
            }
        }

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }

        function updateLocalTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true };
            const localTime = now.toLocaleString('en-US', options);
            document.getElementById('local-time').textContent = localTime;
        }

        updateLocalTime();
        setInterval(updateLocalTime, 1000); 
    </script>
</body>

</html>
