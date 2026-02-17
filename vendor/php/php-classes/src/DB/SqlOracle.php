<?php

namespace Php\DB;

class SqlOracle {

    const HOSTNAME = "192.168.200.6";
    const USERNAME = "wpd";
    const PASSWORD = "wpd";
    const DBNAME = "simul";
    const PORT = "1525";
    const CHARSET = "utf8";

    private $conn;

    public function __construct() {
        $this->conn = oci_connect(self::USERNAME, self::PASSWORD, self::HOSTNAME . ":" . self::PORT . "/" . self::DBNAME);
        if (!$this->conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    private function setParams($statement, $parameters = array()) {
        foreach ($parameters as $key => $value) {
            $this->bindParam($statement, $key, $value);
        }
    }

    private function bindParam($statement, $key, $value) {
        oci_bind_by_name($statement, $key, $value);
    }

    public function query($rawQuery, $params = array()) {
        $stmt = oci_parse($this->conn, $rawQuery);
        $this->setParams($stmt, $params);
        oci_execute($stmt);
    }

    public function select($rawQuery, $params = array()): array {
        $stmt = oci_parse($this->conn, $rawQuery);
        $this->setParams($stmt, $params);
        oci_execute($stmt);
        $result = array();
        while (($row = oci_fetch_array($stmt, OCI_ASSOC)) !== false) {
            $result[] = $row;
        }
        return $result;
    }
}
?>
