<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>TEST</title>
</head>

<body style="justify-content:center; padding: 3em;">
    <form action="test.php" method="post" enctype="multipart/form-data">
        <label for="image">UPLOAD IMG 1</label>
        <input type="file" name="pp_file" placeholder="Send">
        <input type="hidden" name="max_size" value="1048576">

        <input type="submit" placeholder="Soumettre">
    </form>
</body>

</html>