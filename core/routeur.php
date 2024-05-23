<?php

// class routeur cherche routes et trouve un controller 
// private $routes est un tableau de routes ici l'URL verifie si l'information recherché est bien dan sle tableau si oui elle redirige vers un controller 


class routeur
{
    private $request;


    private $routes = [
        "accueil_nl.html" => ["controller" => 'accueil', "method" => 'showAccueil'],
        "inscription.html" => ["controller" => 'inscription', "method" => 'showInscription'],
        "connexion.html" => ["controller" => 'connexion', "method" => 'showConnexion'],
        "add.html" => ["controller" => 'add', "method" => 'showAdd'],
        "delete.html" => ["controller" => 'delete', "method" => 'showDelete'],
        "modify.html" => ["controller" => 'modify', "method" => 'showModify'],
        "compte.html" => ["controller" => 'compte', "method" => 'showCompte'],
        "quizz.html" => ["controller" => 'quizz', "method" => 'showQuizz'],
        "cours.html" => ["controller" => 'cours', "method" => 'showCours'],
        "facture.html" => ["controller" => 'facture ', "method" => 'showFacture'],
        "schoolpea.html" => ["controller" => 'schoolpea', "method" => 'showSchoolPea'],
        "apropos.html" => ["controller" => 'apropos', "method" => 'showApropos'],
        "contact.html" => ["controller" => 'contact', "method" => 'showContact'],
        "accueil.html" => ["controller" => 'accueil', "method" => 'showAccueil'],
        "newsletter.html" => ["controller" => 'newsletter', "method" => 'showNewsletter'],
        "classement.html" => ["controller" => 'classement', "method" => 'showClassement'],
        "join.html" => ["controller" => 'join', "method" => 'showJoin'],
        "exit.html" => ["controller" => 'exit', "method" => 'showExit'],
        "monabonnement.html" => ["controller" => 'monabonnement', "method" => 'showMonabonnement'],
        "défi.html" => ["controller" => 'défi', "method" => 'showDéfi'],

    ];

    public function __construct($request)

    {
        $this->request = $request;
    }

    public function getRoutes()
    {
        $elements = explode('/', $this->request);
        return $elements[0];
    }

    public function getParams()
    {
        $elements = explode('/', $this->request);
        unset($elements[0]);
        $params = [];

        for ($i = 1; $i < count($elements); $i += 2) {
            if (isset($elements[$i + 1])) {
                $params[$elements[$i]] = $elements[$i + 1];
            }
        }

        return $params;
    }

    public function renderController()
    {
        $routes = $this->getRoutes();
        //$request = $this->request;
        $params = $this->getParams();

        if (key_exists($routes, $this->routes)) {

            $controller = $this->routes[$routes]['controller'];
            $method     = $this->routes[$routes]['method'];

            $currentController = new $controller();
            $currentController->$method();
        } else {
            include(CONTROLLER . 'error404.php');
        }
    }
}
