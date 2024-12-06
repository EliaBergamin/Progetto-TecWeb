<?php

//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class DatabaseService{
    private const HOST = "database";
	private const NAME = "museo";
	private const USER = "user";
	private const PASS = "userpassword";

    private const GLOBALERROR = "ERROR encountered";


    private $connection;

    public function __construct() {
		try {
			$this->connection = new mysqli(self::HOST, self::USER, self::PASS, self::NAME);
			//$this->connection->set_charset("utf8");
		} catch (mysqli_sql_exception $e) {
			throw new Exception(self::GLOBALERROR);
		}
	}

    public function eseguiQueryProva($query) : array {
        $result = $this->connection->query($query);
        $rows = $result ->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }


    public function __destruct() {
		if ($this->connection)
			$this->connection->close();
	}


}


?>