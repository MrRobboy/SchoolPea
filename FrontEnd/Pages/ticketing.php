<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Mon compte</title>
    <link rel="stylesheet" type="text/css" href="../Styles/ticketing.css" />
</head>


<body>
    <?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/headerNL.php';
    include($path);
    ?>

    <span class="trait" id="SchoolPea"></span>

    <div id="HELP">
        <title>Besoin d'aide ? </title>
        <h1>Comment pouvez-vous nous aider a vous aider ? </h1>

        <form action="create_ticket.php" method="post">

            <label for="subject">Sujet :</label>

            <input type="text" name="subject" required><br>

            <label for="description">Description :</label>

            <textarea name="description" required></textarea><br>

            <input type="submit" value="Créer un ticket">
        </form>

        <!--<h2>Liste des tickets</h2>
        <?php /*
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

            $conn->close();*/
        ?>-->
    </div>
</body>

</html>