<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Connexion | SchoolPéa</title>
    <link rel="stylesheet" type="text/css" href="../../Styles/style.css" />
</head>

<body>
    <div class="container Connexion" id="Conteneur">
        <div class="form-container sign-in">
            <form action="./accueilNL.php" method="post">
                <h1>Connexion</h1>
                <input type="email" id="email" name="mail" placeholder="email" required />
                <input type="password" id="password" name="password" placeholder="Mot de passe" required />
                <a href="#">Mot de passe oublié ?</a>
                <button type="submit">Connexion</button>
            </form>
        </div>

        <div class="form-container sign-up">
            <form action="./accueilNL.php" method="post">
                <h1 style="text-align: center">Bienvenue chez SchoolPéa</h1>
                <input type="text" id="name" name="name" placeholder="Name" />
                <input type="email" id="email" name="email" placeholder="Email" />
                <input type="password" id="password" name="password" placeholder="Mot de passe" />
                <p><?php if (isset($_GET['password']) && $_GET['password'] === '0') {
                        echo ('Mauvais mdp');
                    } ?></p>
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
    <script src="../../Scripts/script.js"></script>
</body>

</html>