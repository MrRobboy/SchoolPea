<?php
session_start();
echo $_SESSION['email'];
if (isset($_SESSION['erreur']) && $_SESSION['erreur'] == 'erreur') {
?>
    <script>
        alert("Mauvaise réponse");
    </script>
<?php
}
include('db.php');
$request = $dbh->query('SELECT question FROM CAPTCHA;');
$questions = $request->fetchAll();
$request = $dbh->query('SELECT count(id) FROM CAPTCHA;');
$max = $request->fetchAll();
$x = random_int(1, $max[0][0]);
$_SESSION['x'] = $x;
$question = $questions[$x]['question'];

echo ('<form method="post" style="margin : 5rem auto; justify-content : center; display : flex; font-size: 1.5rem;" action="./Verif_captcha.php" >' . $question);
echo ('<input name="textCaptchaAnswer" style="margin : 0 0.5rem; font-size : 1.5rem" type="text" required />');
echo ('<input type="submit" style ="padding: 0 0.5rem; font-size : 1rem;" value="Submit" name="submit"></form>');
