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
 * Represents the connection with a database (mysql) server.
 */
class ConnectionHandler
{
	/**
	 * Contains the MySQLi object if the connection is successfull.
	 * @var MySQLi|null
	 */
	private static $connection = null;

	/**
	 * @return MySQLi|null
	 * @throws Exception When the connection fails.
	 */
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
