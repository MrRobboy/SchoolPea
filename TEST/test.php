<?php
echo 'FILE:<br><pre>';
print_r($_FILES);
echo '</pre>';

if ($_FILES["pp_file"]["size"] > 0 && is_uploaded_file($_FILES["pp_file"]["tmp_name"])) {
        $target_dir = "/var/www/html/SchoolPea/Cours/uploads/";
        $target_file = $target_dir . basename($_FILES["pp_file"]["name"]);
        if (!move_uploaded_file($_FILES["pp_file"]["tmp_name"], $target_file)) echo 'Erreur téléchargement !';
}

echo 'POST<br><pre>';
print_r($_POST);
echo '</pre>';
