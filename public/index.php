<?php

// Inclusion des fichiers nécessaires
require_once 'core/Router.php'; // Inclure la classe Router

// Instanciation du routeur
$router = new Router();

// Définition des routes

// Route pour la page d'accueil non connectée
$router->get('/accueil-non-connecte', function() {
    include 'app/views/pages/Accueil (non-connecté)/index.html';
});

// Route pour la page d'accueil connectée
$router->get('/accueil-connecte', function() {
    include 'app/views/pages/Accueil (connecté)/index.html';
});

// Route pour la page d'inscription/connexion
$router->get('/inscription-connexion', function() {
    include 'app/views/pages/Inscription-Connexion/index.html';
});

// Exécution du routeur
$router->run();
