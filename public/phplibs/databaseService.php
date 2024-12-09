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

    private function executePreparedQuery(&$queryToExecute,&$arrayOfValues,$valueTypeForBinding = "") : mysqli_stmt {
		$valueTypeForBinding = $valueTypeForBinding ?: str_repeat("s",count($arrayOfValues));
		$preparedStatement = $this->connection->prepare($queryToExecute);
		if(!is_null($arrayOfValues)) $preparedStatement->bind_param($valueTypeForBinding,...$arrayOfValues);
		$preparedStatement->execute();
		return $preparedStatement;
	}

	private function selectValuesPreparedQuery(&$queryToExecute,&$arrayOfValues,$valueTypeForBinding = "") : array {
		try{
		$preparedStatement = $this->executePreparedQuery($queryToExecute,$arrayOfValues,$valueTypeForBinding);
		$resultFromQueryExectution = $preparedStatement->get_result();
		$associativeRowsFromSelect = $resultFromQueryExectution->fetch_all(MYSQLI_ASSOC);
		$preparedStatement->close();
		$resultFromQueryExectution->close();
		return $associativeRowsFromSelect;
		}
		catch (mysqli_sql_exception $e) {
			throw new Exception(self::GLOBALERROR);
		}
	}

	public function selectMostrePassate() : array {
		$queryMostrePassate = "SELECT * 
							   FROM Museo.Mostra
							   WHERE Mostra.data_fine < CURDATE()";
		return $this->selectValuesPreparedQuery($queryMostrePassate,[]);
	}

	public function selectMostreCorrenti() : array {
		$queryMostrePassate = "SELECT * 
							   FROM Museo.Mostra
							   WHERE CURDATE() BETWEEN data_inizio AND data_fine;";
		return $this->selectValuesPreparedQuery($queryMostrePassate,[]);
	}
	public function selectMostreFuture() : array {
		$queryMostrePassate = "SELECT * 
							   FROM Museo.Mostra
							   WHERE Mostra.data_inizio > CURDATE()";
		return $this->selectValuesPreparedQuery($queryMostrePassate,[]);
	}

	




    public function __destruct() {
		if ($this->connection)
			$this->connection->close();
	}


}


?>