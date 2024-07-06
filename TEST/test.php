<?php
echo 'FILE:<br><pre>';
print_r($_FILES);
echo '</pre>';

if ($_FILES["image_pres"]["size"] > 0 && is_uploaded_file($_FILES["image_pres"]["tmp_name"])) {
        $target_dir = "/var/www/html/SchoolPea/TEST/uploads/";
        $target_file = $target_dir . basename($_FILES["image_pres"]["name"]);
        move_uploaded_file($_FILES["pp_file"]["tmp_name"], $target_file);
}

echo 'POST<br><pre>';
print_r($_POST);
echo '</pre>';
