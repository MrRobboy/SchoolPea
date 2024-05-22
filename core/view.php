<?php

class view 
{
    private $template;

    public function __construct($template)
    {
        $this->template=$template;
    }

    public function render()
    {
        $template = $this->template;

        include_once ( VIEW.$template.'.php');
    }
}