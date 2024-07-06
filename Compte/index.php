<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Mon compte</title>
    <link rel="stylesheet" type="text/css" href="https://schoolpea.com/Compte/compte.css" />
</head>

<body>
    <?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    if (isset($_SESSION['mail_valide'])) {
        $path .= '/headerL.php';
    } else {
        header('Location: https://schoolpea.com/Connexion');
    }
    include($path);
    ?>

    <span class="trait" id="SchoolPea"></span>

    <div id="div1">
        <form method="post" id="Info_gen" action="apply_edit.php">
            <span id="Titre_Info_gen">
                <img src="https://schoolpea.com/Images/reglage.svg" style="width: 45px;">
                <h1 style="margin-left: 0.5em;">Informations Générales</h1>
            </span>

            <span id="Modif_Photo">
                <img src="<?php echo $_SESSION['path_pp']; ?>" id="PP">
                <input type="hidden" name="max_size" value="1048576">
                <label for="image_pp" id="But_Photo" class="btn" style="cursor: pointer; margin: 1em; position: relative; padding: 0.5em 1em 0 1em; z-index: 0;">Charger une photo</label>
                <input id="image_pp" type="file" name="img_pp" hidden>
            </span>

            <span id="Modif_Nom_Prenom">
                <span id="Nom">
                    <span class="Text_Nom_Prenom_Email">Nom</span>
                    <input type="text" name="lastname" value="<?php echo ($_SESSION['lastname']); ?>" class="Input_Nom_Prenom_Email">
                </span>

                <span id="Prenom">
                    <span class="Text_Nom_Prenom_Email">Prénom</span>
                    <input type="text" name="firstname" value="<?php echo ($_SESSION['firstname']); ?>" class="Input_Nom_Prenom_Email">
                </span>
            </span>

            <span id="Email">
                <span class="Text_Nom_Prenom_Email">Adresse Email</span>
                <input type=" text" name="email" value="<?php echo ($_SESSION['email']); ?>" class="Input_Nom_Prenom_Email">
            </span>

            <span style="margin: 1em 0;">
                <input type="submit" id="Sauvegarde_modif" value="Sauvegarder Les modifications"></input>
            </span>
        </form>

        <form id="Mdp_modif" method="post">
            <h2 id="Titre_Mdp_modif"> Changer de <br> Mot de passe </h2>
            <div class="Mdp_modif_div">
                <span class="Text_Modif_mdp">Ancien Mot de Passe</span>
                <input type="password" class="Input_Mdp_modif_div" placeholder="Old Password"></input>
            </div>

            <div class="Mdp_modif_div">
                <span class="Text_Modif_mdp">Nouvau Mot de Passe</span>
                <input type="password" class="Input_Mdp_modif_div" placeholder="New Password"></input>
            </div>

            <div class="Mdp_modif_div">
                <span class="Text_Modif_mdp">Confirmer le Mot de Passe</span>
                <input type="password" class="Input_Mdp_modif_div" placeholder="Confirm Password"></input>
            </div>
            <input type="submit" value="Changer de mot de passe" id="Sauvegarde_modif_mdp"></input>
        </form>
    </div>

    <div id="div2">
        <div style="padding: 2em;">
            <span style="display: flex; flex-direction: row;">
                <span>
                    <img src="../../Images/exclamation.svg" id="Exclamation">
                </span>

                <span id="Delete_Acc" style="margin: 0 0 1.5em 0;">
                    <span id="Titre_Delete_Acc">Supprimer votre compte</span>
                    <span id="Text_Delete_Acc">Si vous supprimez votre compte, vous en perdrez l'accès définitif sans possibilité de le récupérer. Vos données personnelles et vos progrès seront effacés et perdus, de même que tout abonnement en cours.</span>
                </span>
            </span>

            <span id="BUT_DEL" style="margin: 1em 0 1.5em 0; padding: 1em 2em;">
                <a id="But_Delete_Acc" href="#">Supprimer le compte</a>
            </span>
        </div>
    </div>
</body>