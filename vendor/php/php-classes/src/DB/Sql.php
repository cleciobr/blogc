<?php 

namespace Php\DB;

use \PDO;
use \PDOStatement;

class Sql {

	private $conn; 

public function __construct() {
    $path = __DIR__ . '/../../.env'; 
    if (file_exists($path)) {
        $linhas = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($linhas as $linha) {
            if (strpos(trim($linha), '#') === 0) continue;
            list($name, $value) = explode('=', $linha, 2);
            putenv(trim($name) . "=" . trim($value));
        }
    }
    // --- FIM DO BLOCO ---

    $host = getenv('DB_HOST');
    $port = "24257"; 
    $dbname = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASS');
    
    $cert = __DIR__ . "/admin/cert/ca.pem"; 

    try {
        $this->conn = new PDO(
            "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", 
            $user, 
            $pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_SSL_CA => $cert,
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
            ]
        );
    } catch (\PDOException $e) {
        die("Erro na conexão com Aiven: " . $e->getMessage());
    }
}


	private function setParams($statement, $parameters = []) {
		foreach ($parameters as $key => $value) {
			$this->bindParam($statement, $key, $value);
		}
	}

	private function bindParam($statement, $key, $value) {
		$statement->bindParam($key, $value);
	}

	// public function query($rawQuery, $params = []) {
	// 	$stmt = $this->conn->prepare($rawQuery);
	// 	$this->setParams($stmt, $params);
	// 	$stmt->execute();
	// 	return $stmt;
	// }
	public function query($rawQuery, $params = []) {
		try {
			$stmt = $this->conn->prepare($rawQuery);
			$this->setParams($stmt, $params);
			$stmt->execute();
			return $stmt;
		} catch (\PDOException $e) {
			
			die("Erro no SQL: " . $e->getMessage() . " | Query: " . $rawQuery);
		}
	}
	public function select($rawQuery, $params = []) {
		$stmt = $this->query($rawQuery, $params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
	}
}
