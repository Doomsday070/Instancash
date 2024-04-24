<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #125A66; /* Background color */
            margin: 0;
            padding: 0;
            color: black; /* Text color */
        }
        .navbar {
            background-color: white;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .navbar a {
            margin: 0 15px;
            color: black; /* Dark blue text color */
            text-decoration: none;
            font-weight: bold;
        }

        .account-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .user-box {
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .user-box p {
            margin: 0;
        }

        .qr-code img {
            max-width: 100%;
        }

        .action-box {
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .action-box:hover {
            transform: translateY(-5px);
        }

        .text-below {
            margin-top: 10px;
        }

        .action-box a {
            color: #125A66; /* Dark blue text color */
            text-decoration: none;
        }

        .btn-check-balance {
    background-color: #125A66;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    /* New styles for basic size */
    padding: 5px 10px; /* Adjust padding as needed */
    font-size: 14px; /* Adjust font size as needed */
}

.btn-check-balance:hover {
    background-color: #0B3B44;
}
.nav-link .emoji {
        color: grey;
    }
        /* Your existing styles here */

        /* Custom styles for the modal */
        .modal-content {
            border-radius: 10px;
        }

        /* Style the iframe to fill the modal body */
        .modal-body iframe {
            width: 100%;
            height: 500px; /* Adjust the height as needed */
            border: none;
            opacity: 0; /* Initially hidden */
            transition: opacity 0.5s ease-in-out; /* Add a fade-in transition */
        }

        /* Show the iframe when it's loaded */
        .modal-body iframe.loaded {
            opacity: 1;
        }
        h1 {
        text-align: center; /* Center-align the h1 element */
        }
    </style>
    <title>InstantCash - Pay Bill</title>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="#">InstantCash</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="http://localhost/InstantCash/account.php">Home</a></li>
                
                <li class="nav-item"><a class="nav-link" href="http://localhost/InstantCash/history.php">History</a></li>
                <li class="nav-item"><span id="local-time" class="nav-link"></span></li>
            </ul>
        </div>
    </nav>
    <script>
        function updateLocalTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true};
            const localTime = now.toLocaleString('en-US', options);
            document.getElementById('local-time').textContent = localTime;
        }
        updateLocalTime();
        setInterval(updateLocalTime, 1000); // Update every second
    </script>

    <main class="container mt-5">
        <h2 class="account-title,"style="color:white;">Pay Bill</h2>
        <div class="row text-center">
            <div class="col-md-3">
                <div class="action-box">
                    <a href="#" id="openGasModal">
                        <img src="Assets/gas.jpg" width="180" alt="Gas">
                    </a>
                    <div class="text-below">
                        <a href="#">Gas</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="action-box">
                    <a href="#" id="openWaterModal">
                        <img src="Assets/water.jpg" width="180" height="180" alt="Water">
                    </a>
                    <div class="text-below">
                        <a href="#">Water</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="action-box">
                    <a href="#" id="openInternetModal">
                        <img src="Assets/wifi.jpg" width="180" height="180" alt="Internet">
                    </a>
                    <div class="text-below">
                        <a href="#">Internet</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="action-box">
                    <a href="#" id="openElectricityModal">
                        <img src="Assets/electricity.jpg" width="180" height="180" alt="Electricity">
                    </a>
                    <div class="text-below">
                        <a href="#">Electricty</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap Modals -->

    <!-- Send Money Modal -->
    <div class="modal fade" id="GasModal" tabindex="-1" role="dialog" aria-labelledby="GasModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="GasModalLabel">Gas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="" class="loaded"></iframe> <!-- Leave the 'src' attribute empty initially -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cash In Modal -->
    <div class="modal fade" id="WaterModal" tabindex="-1" role="dialog" aria-labelledby="WaterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="WaterModalLabel">Water</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="" class="loaded"></iframe> <!-- Leave the 'src' attribute empty initially -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Recharge Modal -->
    <div class="modal fade" id="InternetModal" tabindex="-1" role="dialog" aria-labelledby="InternetModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="InternetModalLabel">Internet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="" class="loaded"></iframe> <!-- Leave the 'src' attribute empty initially -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ElectricityModal" tabindex="-1" role="dialog" aria-labelledby="ElectricityModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ElectricityModalLabel">Electricity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="" class="loaded"></iframe> <!-- Leave the 'src' attribute empty initially -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Function to open the modal and load content from the specified URL
        function openModal(modalId, contentUrl) {
            // Set the 'src' attribute of the iframe when the modal is opened
            $(modalId + ' iframe').attr('src', contentUrl);
            $(modalId).modal('show'); // Show the modal
        }

        // When the iframe has loaded, add the 'loaded' class to trigger the fade-in effect
        $('.modal-body iframe').on('load', function() {
            $(this).addClass('loaded');
        });

        // Attach click event handlers to the action links
        $('#openGasModal').click(function (e) {
            e.preventDefault(); // Prevent the default link behavior
            openModal('#GasModal', 'http://localhost/InstantCash/gas_bills.php');
        });

        $('#openWaterModal').click(function (e) {
            e.preventDefault(); // Prevent the default link behavior
            openModal('#WaterModal', 'http://localhost/InstantCash/water_bills.php');
        });

        $('#openInternetModal').click(function (e) {
            e.preventDefault(); // Prevent the default link behavior
            openModal('#InternetModal', 'http://localhost/InstantCash/internet_bills.php');
        });
        $('#openElectricityModal').click(function (e) {
            e.preventDefault(); // Prevent the default link behavior
            openModal('#ElectricityModal', 'http://localhost/InstantCash/electricity_bills.php');
        });
    </script>
</body>
</html>
 