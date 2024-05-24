<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Connexion | SchoolPéa</title>
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <script href="./script.js"></script>
</head>

<div class="container Connexion" id="Conteneur">
    <div class="form-container sign-in">
        <form action="./accueil_nl.php">
            <h1>Connexion</h1>
            <!-- <span>ou utilise ton adresse mail ! </span> -->
            <input type="email" placeholder="Email" />
            <input type="password" placeholder="Mot de passe" />
            <a href="./accueil_nl.php">
                Mot de passe oublié ?
            </a>
            <!-- Setup page mdp oublié à faire-->
            <button>Connexion</button>
        </form>
    </div>

    <div class="form-container sign-up">
        <form action="./accueil_nl.php">
            <h1 style="text-align: center">Bienvenue chez SchoolPéa</h1>
            <!-- <span>ou utilise ton adresse mail !</span> -->
            <input type="text" placeholder="Name" />
            <input type="email" placeholder="Email" />
            <input type="password" placeholder="Mot de passe" />
            <button>Inscription</button>
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
                <button class="hidden" id="Inscription">
                    Inscription
                </button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo JS; ?>connexion.js"></script>
<!--S'active que s'il est dans le body-->