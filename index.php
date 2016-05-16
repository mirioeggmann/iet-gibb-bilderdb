<?php
require_once('libraries/Dispatcher.php');
require_once('libraries/View.php');
require_once('libraries/Model.php');

$dispatcher = new Dispatcher();
$dispatcher->dispatch();

error_reporting(E_ALL);
