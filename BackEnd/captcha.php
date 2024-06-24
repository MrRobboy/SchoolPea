<?php
session_start();
echo $_SESSION['email'];
if (!empty($_SESSION['erreur']) && $_SESSION['erreur'] == 'erreur') {
    echo '<script>alert("Mauvaise réponse")</script>';
}

include('db.php');
$request = $dbh->query('SELECT question FROM CAPTCHA;');
$questions = $request->fetchAll();
$request = $dbh->query('SELECT count(id) FROM CAPTCHA;');
$max = $request->fetchAll();
$x = random_int(0, $max[0][0] - 1);
$_SESSION['x'] = $x;
$question = $questions[$x]['question'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./styles.css">
    <title>Captcha</title>
</head>

<body>
    <div class="container">
        <div>
            <form method="post" action="./Verif_captcha.php">
                <h2><?php echo ($question); ?></h2>
                <input name="textCaptchaAnswer" type="text" required />
                <button type="submit" name="submit">Valider</button>
            </form>
        </div>
    </div>
</body>

</html>