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
            color: white; /* Title color */
        }

        .action-box {
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 30px;
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
            padding: 5px 10px; /* Adjust padding as needed */
            font-size: 14px; /* Adjust font size as needed */
        }

        .btn-check-balance:hover {
            background-color: #0B3B44;
        }

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
        
        .icon-container {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto;
        }
        
        .icon-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    <title>InstantCash - Cash Out</title>
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
        <h2 class="account-title">Cash Out</h2>
        <div class="row text-center">
            <div class="col-md-6">
                <div class="action-box">
                    <div class="icon-container">
                        <a href="#" id="openBankModal">
                            <img src="Assets/bank.jpg" alt="Bank">
                        </a>
                    </div>
                    <div class="text-below">
                        <a href="#">Bank</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="action-box">
                    <div class="icon-container">
                        <a href="#" id="openAgentModal">
                            <img src="Assets/agent.jpg" alt="Agent">
                        </a>
                    </div>
                    <div class="text-below">
                        <a href="#">Agent</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap Modals -->

    <!-- Bank Modal -->
    <div class="modal fade" id="BankModal" tabindex="-1" role="dialog" aria-labelledby="BankModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="BankModalLabel">Bank</h5>
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

    <!-- Agent Modal -->
    <div class="modal fade" id="AgentModal" tabindex="-1" role="dialog" aria-labelledby="AgentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AgentModalLabel">Agent</h5>
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
        $('#openBankModal').click(function (e) {
            e.preventDefault(); // Prevent the default link behavior
            openModal('#BankModal', 'http://localhost/InstantCash/cashout_bank.php'); // Change the URL as needed
        });

        $('#openAgentModal').click(function (e) {
            e.preventDefault(); // Prevent the default link behavior
            openModal('#AgentModal', 'http://localhost/InstantCash/cashout_agent.php'); // Change the URL as needed
        });
    </script>
</body>
</html>
