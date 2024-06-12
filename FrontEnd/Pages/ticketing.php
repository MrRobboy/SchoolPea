<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Mon compte</title>
    <link rel="stylesheet" type="text/css" href="./compte.css" />
</head>


<body>
    <header>
        <div id="accueil">

            <img id="logo_header" src="../Images/SchoolPea.png" />
            </a>
            <a href="#SchoolPea"> SchoolPéa </a>
        </div>
        <div id="Pages">
            <span>
                <a class="lien_header" href="./index.html"> SchoolPea+ </a>
            </span>
            <span>
                <a class="lien_header" href="./index.html">
                    Explorer les Quizzs
                </a>
            </span>
            <span>
                <a class="lien_header" href="./index.html">
                    Explorer les Cours
                </a>
            </span>
            <span>
                <a class="lien_header" href="./index.html">Mes Cours</a>
            </span>

            <span id="slide_down">
                <svg xmlns="http://www.w3.org/2000/svg" widtd="30" height="30" fill="black" viewBox="0.5 .5 15 15">
                    <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                </svg>
                <div>
                    <a>Voir Plus</a>
                    <a>Mon compte</a>
                    <a>Paramètres</a>
                </div>
            </span>

            <span style="margin-left: 1.2rem">
                <img src="../Images/PP_TEST.jpg" style="width: 45px; border-radius: 50%" />
            </span>
        </div>
    </header>

    <span class="trait" id="SchoolPea"></span>

    <div id="HELP">
        <title>Besoin d'aide ? </title>
        <link rel="stylesheet" type="text/css" href="style.css">
        </head>

        <body>
            <h1>Comment pouvez-vous nous aider a vous aider ? </h1>

            <form action="create_ticket.php" method="post">

                <label for="subject">Sujet :</label>

                <input type="text" name="subject" required><br>

                <label for="description">Description :</label>

                <textarea name="description" required></textarea><br>

                <input type="submit" value="Créer un ticket">
            </form>

            <h2>Liste des tickets</h2>
            <?php
            $servername = "localhost";
            $username = "username";
            $password = "password";
            $dbname = "myDB";


            // creation de connection A FAIRE 
            $conn = new mysqli($servername, $username, $password, $dbname);

            // controle  connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $subject = $_POST['sujet'];
            $description = $_POST['description'];
            $created_at = date('Y-m-d');

            $sql = "INSERT INTO tickets (subject, description, created_at) VALUES ('$subject', '$description', '$created_at')";

            if ($conn->query($sql) === TRUE) {
                echo "Ticket envoyé avec succès ";
            } else {
                echo "Erreur création de ticket: " . $conn->error;
            }

            $conn->close();
            ?>


        </body>

</html>