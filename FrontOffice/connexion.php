<?php require_once '../FrontEnd/connexion.php'; ?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Connexion | SchoolPéa</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />
</head>

<body>
    <div class="container Connexion" id="Conteneur">
        <div class="form-container sign-in">
            <form action="./connexion.php" method="post">
                <h1>Connexion</h1>
                <input type="email" id="email" name="email" placeholder="Email" />
                <input type="password" id="password" name="password" placeholder="Mot de passe" />
                <a href="#">Mot de passe oublié ?</a>
                <button type="submit">Connexion</button>
            </form>
        </div>

        <div class="form-container sign-up">
            <form action="inscription.php" method="post">
                <h1 style="text-align: center">Bienvenue chez SchoolPéa</h1>
                <input type="text" id="name" name="name" placeholder="Name" />
                <input type="email" id="email" name="email" placeholder="Email" />
                <input type="password" id="password" name="password" placeholder="Mot de passe" />
                <button type="submit">Inscription</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Te revoila !</h1>
                    <button class="hidden" id="Connexion">Connexion</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>T'es nouveau ?</h1>
                    <button class="hidden" id="Inscription">Inscription</button>
                </div>
            </div>
        </div>
    </div>
    <script src="./script.js"></script><!--S'active que s'il est dans le body-->
</body>