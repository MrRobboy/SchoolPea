<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" >
        <title> Pong </title>
    </head>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');


            *{
                font-family: 'Montserrat', sans-serif;
            }
            body{
                text-align: center;
                background-color: ghostwhite;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                flex-direction: column;
                position: fixed;
                width: 100%;
            }
        </style>
    <body>
        <h1>Pong</h1>
        <canvas></canvas>
        <p>Tu es le joueur de gauche ! Utilise les Flèches HAUT et BAS pour bouger !</p>
        <script src="./script"></script>
    </body>
</html>