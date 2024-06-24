<?php
session_start();
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Mon compte</title>
    <link rel="stylesheet" type="text/css" href="./compte.css" />
</head>


<body>
    <?php

    $path = $_SERVER['DOCUMENT_ROOT'];
    if (!empty($_SESSION['path_pp'])) {
        $path .= '/headerL.php';
    } else {
        header('Location: https://schoolpea.com/Connexion');
    }
    include_once($path);
    ?>

    <!-- <span class="trait" id="SchoolPea"></span> -->

    <div id="div1">
        <span id="Info_gen">
            <span id="Titre_Info_gen">
                <img src="https://schoolpea.com/Images/reglages.svg" style="width: 45px;">
                <h1 style="margin-left: 0.5em;">Informations Générales</h1>
            </span>

            <span id="Modif_Photo">
                <img src="https://schoolpea.com/<?php echo $_SESSION['path_pp']; ?>" id="Photo_profile">
                <button id="But_Photo">Charger une photo</button>
            </span>

            <span id="Modif_Nom_Prenom">
                <span id="Nom">
                    <span class="Text_Nom_Prenom_Email">Nom</span>
                    <input type="text" placeholder="Changer le nom" class="Input_Nom_Prenom_Email">
                </span>

                <span id="Prenom">
                    <span class="Text_Nom_Prenom_Email">Prénom</span>
                    <input type="text" placeholder="Changer le prénom" class="Input_Nom_Prenom_Email">
                </span>
            </span>

            <span id="Email">
                <span class="Text_Nom_Prenom_Email">Email adresse</span>
                <input type=" text" placeholder="Changer l'email" class="Input_Nom_Prenom_Email">
            </span>

            <span style="margin: 1em 0;">
                <input type="submit" id="Sauvegarde_modif" value="Sauvegarder Les modifications"></input>
            </span>
        </span>

        <span id="Mdp_modif">
            <h2 id="Titre_Mdp_modif"> Changer de <br> Mot de passe </h2>
            <div class="Mdp_modif_div">
                <span class="Text_Modif_mdp">Ancien Mot de Passe</span>
                <input type="text" class="Input_Mdp_modif_div" placeholder="Old Password"></input>
            </div>

            <div class="Mdp_modif_div">
                <span class="Text_Modif_mdp">Nouvau Mot de Passe</span>
                <input type="text" class="Input_Mdp_modif_div" placeholder="New Password"></input>
            </div>

            <div class="Mdp_modif_div">
                <span class="Text_Modif_mdp">Confirmer le Mot de Passe</span>
                <input type="text" class="Input_Mdp_modif_div" placeholder="Confirm Password"></input>
            </div>
            <input type="submit" value="Changer de mot de passe" id="Sauvegarde_modif_mdp"></input>
        </span>
    </div>

    <div id="div2">
        <div style="padding: 2em;">
            <span style="display: flex; flex-direction: row;">
                <span>
                    <img src="../../Images/exclamation.svg" id="Exclamation">
                </span>

                <span id="Delete_Acc">
                    <span id="Titre_Delete_Acc">Supprimer votre compte</span>
                    <span id="Text_Delete_Acc">Si vous supprimez votre compte, vous en perdrez l'accès définitif sans possibilité de le récupérer. Vos données personnelles et vos progrès seront effacés et perdus, de même que tout abonnement en cours.</span>
                </span>
            </span>

            <span>
                <button id="But_Delete_Acc">Supprimer le compte</button>
            </span>
        </div>
    </div>
</body>