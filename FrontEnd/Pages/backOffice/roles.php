<?php
include 'auth.php';

// Afficher les rôles et permissions
$roles = [
    'admin' => ['Gérer les utilisateurs', 'Gérer le contenu', 'Superviser les logs'],
    'user' => ['Voir le contenu']
];