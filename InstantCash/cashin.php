<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #125A66; 
            margin: 0;
            padding: 0;
            color: black; 
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

        .account-title {
            text-align: center;
            margin-bottom: 20px;
            color: white; 
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
            color: #125A66; 
            text-decoration: none;
        }

        .btn-check-balance {
            background-color: #125A66;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            padding: 5px 10px; 
            font-size: 14px; 
        }

        .btn-check-balance:hover {
            background-color: #0B3B44;
        }


        .modal-content {
            border-radius: 10px;
        }


        .modal-body iframe {
            width: 100%;
            height: 500px; 
            border: none;
            opacity: 0; 
            transition: opacity 0.5s ease-in-out; 
        }


        .modal-body iframe.loaded {
            opacity: 1;
        }

        h1 {
            text-align: center; 
        }
    </style>
    <title>InstantCash - Cash In</title>
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
        setInterval(updateLocalTime, 1000); 
    </script>

    <main class="container mt-5">
        <h2 class="account-title">Cash In</h2>
        <div class="row text-center">
            <div class="col-md-6">
                <div class="action-box">
                    <a href="#" id="openBankModal">
                        <img src="Assets/bank.jpg" width="180" alt="Bank">
                    </a>
                    <div class="text-below">
                        <a href="#">Bank</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="action-box">
                    <a href="#" id="openCreditCardModal">
                        <img src="Assets/creditcard.jpg" width="180" alt="Credit Card">
                    </a>
                    <div class="text-below">
                        <a href="#">Credit Card</a>
                    </div>
                </div>
            </div>
        </div>
    </main>




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
                    <iframe src="" class="loaded"></iframe> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Credit Card Modal -->
    <div class="modal fade" id="CreditCardModal" tabindex="-1" role="dialog" aria-labelledby="CreditCardModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CreditCardModalLabel">Credit Card</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="" class="loaded"></iframe> 
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

        function openModal(modalId, contentUrl) {

            $(modalId + ' iframe').attr('src', contentUrl);
            $(modalId).modal('show'); 
        }


        $('.modal-body iframe').on('load', function() {
            $(this).addClass('loaded');
        });


        $('#openBankModal').click(function (e) {
            e.preventDefault(); 
            openModal('#BankModal', 'http://localhost/InstantCash/bank.php'); 
        });

        $('#openCreditCardModal').click(function (e) {
            e.preventDefault(); 
            openModal('#CreditCardModal', 'http://localhost/InstantCash/creditcard.php'); 
        });
    </script>
</body>
</html>
