<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>TEST</title>
</head>

<body style="justify-content:center; padding: 3em;">
    <form action="test.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="max_size" value="1048576">
        <label for="image">UPLOAD IMG 1</label>
        <input name="pp_file" type="file" id="image" placeholder="Send" hidden>

        <input type="submit" Value="Soumettre">
    </form>
</body>

</html>