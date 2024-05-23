<?php

/**permet de montrer la vue accueil_nl.php */


class Accueil_nl
{

    public function showAccueil()

    $manager = new SchoolPeaManager();
    $SchoolPea = $manager->findAll();

    $myView = new view('accueil_nl');
    $myView->render($SchoolPea);

    //remplace le include (VIEW.'home.php')

    
}