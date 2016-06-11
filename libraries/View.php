<?php

/**
 * Lychez : Image database (https://lychez.luvirx.io)
 * Copyright (c) luvirx (https://luvirx.io)
 *
 * Licensed under The MIT License
 * For the full copyright and license information, please see the LICENSE.md
 * Redistributions of the files must retain the above copyright notice.
 *
 * @link 		https://lychez.luvirx.io Lychez Project
 * @copyright 	Copyright (c) 2016 luvirx (https://luvirx.io)
 * @license		https://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Handles the creation of view. Displays the view parts.
 */
class View
{
    /**
     * @var null|string The name of the view file.
     */
    private $viewfile 	= null;

    /**
     * @var array Properties that are used by the view file.
     */
    private $properties = array();

    /**
     * Adds the view file and properties if there are any given.
     *
     * @param $viewfile The name of the view file.
     * @param array $properties the properties that are used by the view file.
     */
    public function __construct($viewfile, $properties = array())
    {
    	$this->properties = $properties;

    	$viewfile = "./views/templates/$viewfile.php";
    	if (file_exists($viewfile)) {
	       $this->viewfile = $viewfile;
	    }
    }

    /**
     * Set a new property.
     *
     * @param $key Key of the property.
     * @param $value Value of the property.
     */
    public function __set($key, $value)
    {
        if (!isset($this->$key)) {
            $this->properties[$key] = $value;
        }
    }

    /**
     * Get a property.
     *
     * @param $key The key of the property.
     * @return mixed The value of the property.
     */
    public function __get($key)
    {
        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }
    }

    /**
     * Call the viewfile and give it the properties.
     */
    public function display()
    {
        extract($this->properties);
        include_once($this->viewfile);
    }
}
