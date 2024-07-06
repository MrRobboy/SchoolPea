<?php
$pass = "AVVACAME4DX";
$passwordHash = password_hash($pass, PASSWORD_DEFAULT);
echo $passwordHash;
