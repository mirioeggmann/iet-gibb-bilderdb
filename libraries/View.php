<?php

class View
{
    private $viewfile 	= null;
    private $properties = array();

    public function __construct($viewfile, $properties = array())
    {
    	$this->properties = $properties;

    	$viewfile = "./view/$viewfile.php";
    	if (file_exists($viewfile)) {
	       $this->viewfile = $viewfile;
	    }
    }

    public function __set($key, $value)
    {
        if (!isset($this->$key)) {
            $this->properties[$key] = $value;
        }
    }

    public function __get($key)
    {
        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }
    }

    public function display()
    {
        extract($this->properties);
        include_once($this->viewfile);
    }
}
