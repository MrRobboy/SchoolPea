<?php 





class routeur
{ 
    private $request;

    private $routes = ["accueil.html" => "accueil", ];

    public function __construct($request)

    {
        $this->request = $request;        
    }

    public function renderController()
    {
        $request = $this->request;

        if (key_exists($request,$this->routes))
        {

            $controller = $this->routes[$request]['controller'];
            $method     = $this->routes[$request]['method'];
        } else {
            include(CONTROLLER.'404.php');
        }
    }
}