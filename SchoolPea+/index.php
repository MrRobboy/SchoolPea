<?php
session_start();
if (!isset($_SESSION['mail_valide'])) {
    header('Location: https://schoolpea.com/Connexion');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SchoolPea+ Adhésion</title>
    <link rel="stylesheet" type="text/css" href="./schoolpea+.css">
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form id="subscriptionForm">
                <h2>Adhésion SchoolPea+</h2>
                <p>Devenez le roi de SchoolPea pour 9.99€ par mois</p>
                <input type="email" id="email" placeholder="Email" required>
                <div id="card-element"></div>
                <div id="card-errors" role="alert"></div>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
