<?php
session_start();

if (!empty($_SESSION['erreur']) && $_SESSION['erreur'] == 'erreur') {
    echo '<script>alert("Mauvaise réponse")</script>';
}

include('db.php');

$request = $dbh->query('SELECT question FROM CAPTCHA;');
$questions = $request->fetchAll();

$request = $dbh->query('SELECT count(id_CAPTCHA) FROM CAPTCHA;');
$max = $request->fetchAll();

$x = random_int(0, $max[0][0] - 1);
$_SESSION['x'] = $x;
$question = $questions[$x]['question'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./back.css">
    <title>Captcha</title>
</head>

<body>
    <div class="container">
        <div>
            <form method="post" action="./Verif_captcha.php">
                <h2><?php echo ($question); ?></h2>
                <input name="textCaptchaAnswer" type="text" style="font-size: 20px; font-weight: 400; background-color: #eee;" required />
                <input type="submit" name="submit" value="Valider" id="validation_captcha"></input>
            </form>
        </div>
    </div>
</body>

</html>