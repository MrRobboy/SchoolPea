<?php

class SchoolPeaManager
{
    private $bdd;

    public function __construct()
    {
        $this->bdd =new PDO("mysql:host=localhost ; dbname=PA; charset=utf8", "root" , "root" );
    }
}