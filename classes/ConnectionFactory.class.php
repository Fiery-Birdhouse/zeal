<?php
final class ConnectionFactory {

	private static $cache = array();

	private function __construct() {
		// Prevent the class from being instantiated
	}

	/**
	 * Create DB connection.
	 * @return PDO
	 */
	static function getConnection() {
		global $connection;
		global $def_cred;

		// Does not create connection if it was already created
		if (empty(self::$cache["connection"])) {
			if (empty($connection)) {
				throw new Exception(notificacoes("z2"));
			}

			// Create PDO Object
			$host = $connection['host'];
			$db = $connection['db'];
			$user = $connection['user'];
			$pass = $connection['pass'];
			$connection = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

			// Set UTF-8 as used encoding
			$connection->exec("SET NAMES 'utf8'");
			$connection->exec('SET character_set_connection=utf8');
			$connection->exec('SET character_set_client=utf8');
			$connection->exec('SET character_set_results=utf8');

			// Throw an exception in case of SQL error
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Store connection in cache
			self::$cache["connection"] = $connection;
		}

		return self::$cache["connection"];
	}

}
?>
