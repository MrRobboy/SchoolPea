<?php
session_start();
if ($_SESSION['x']) echo ('1'); /* Vérifie que la session existe */
session_unset();
if ($_SESSION['x']) echo ('2'); /*Vide la session */
session_destroy(); /*Détruit la session */
