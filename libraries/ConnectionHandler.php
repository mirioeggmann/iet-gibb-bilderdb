<?php

class ConnectionHandler
{
	private static $connection = null;

	private function __construct() {}

	public static function getConnection()
	{
		if (self::$connection === null) {
			$config = require('config.php');
			$host     = $config['database']['host'];
			$username = $config['database']['username'];
			$password = $config['database']['password'];
			$database = $config['database']['database'];

			self::$connection = new MySQLi($host, $username, $password, $database);
			if (self::$connection->connect_error) {
				$error = self::$connection->connect_error;
				throw new Exception("Verbindungsfehler: $error");
			}

			self::$connection->set_charset('utf8');
		}

		return self::$connection;
	}
}
