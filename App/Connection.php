<?php

namespace App;

class Connection {

	public static function getDb() {
		try {

			$conn = new \PDO(
				"mysql:host=localhost;dbname=loja_test_1;charset=utf8",
				"root",
				"", 
				array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") 
			);

			return $conn;

		} catch (\PDOException $e) {
			echo "<p style='color:#ff0000'>Erro:" . $e->getCode() . ' Menssagem: ' . $e->getMessage() . "</p>";
		}
	}
}

?>

