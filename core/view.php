<?php

class view 
{
    private $template;

    public function __construct($template  /* = null*/)
    {
        $this->template=$template;
    }

    public function render($params = array())
{       
        extract($params); //crée  parmas selon ce qui est tapté dans le controller (url)

        $template = $this->template;

        ob_start();
        include(VIEW.$template.'.php');
        $contentPage = ob_get_clean();
        include_once ( VIEW.'layout.php');
    }

    public function redirect($routes)
    {
        header("Location: ".HOST.$routes);
        exit;
    }

}