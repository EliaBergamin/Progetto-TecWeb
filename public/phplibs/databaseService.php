<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class DatabaseService
{
	private const HOST = "database";
	private const NAME = "Museo";
	private const USER = "user";
	private const PASS = "userpassword";

	private const GLOBALERROR = "ERROR encountered";


	private $connection;

	public function __construct()
	{
		try {
			$this->connection = new mysqli(self::HOST, self::USER, self::PASS, self::NAME);
			//$this->connection->set_charset("utf8");
		} catch (mysqli_sql_exception $e) {
			echo $e;
			throw new Exception(self::GLOBALERROR);
		}
	}

	private function executePreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding = ""): mysqli_stmt
	{
		$valueTypeForBinding = $valueTypeForBinding ?: str_repeat("s", count($arrayOfValues));
		$preparedStatement = $this->connection->prepare($queryToExecute);
		if (!empty($arrayOfValues))
			$preparedStatement->bind_param($valueTypeForBinding, ...$arrayOfValues);
		$preparedStatement->execute();
		return $preparedStatement;
	}

	private function selectValuesPreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding = ""): array
	{
		try {
			$preparedStatement = $this->executePreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding);
			$resultFromQueryExectution = $preparedStatement->get_result();
			$associativeRowsFromSelect = $resultFromQueryExectution->fetch_all(MYSQLI_ASSOC);
			$preparedStatement->close();
			$resultFromQueryExectution->close();
			return $associativeRowsFromSelect;
		} catch (mysqli_sql_exception $e) {
			echo $e;
			throw new Exception(self::GLOBALERROR);
		}
	}

	public function selectMostrePassate(): array
	{
		$queryMostrePassate = "SELECT * 
							   FROM Museo.Mostra
							   WHERE Mostra.data_fine < CURDATE()";
		return $this->selectValuesPreparedQuery($queryMostrePassate, []);
	}

	public function selectMostreCorrenti(): array
	{
		$queryMostrePassate = "SELECT * 
							   FROM Museo.Mostra
							   WHERE CURDATE() BETWEEN data_inizio AND data_fine;";
		return $this->selectValuesPreparedQuery($queryMostrePassate, []);
	}
	public function selectMostreFuture(): array
	{
		$queryMostrePassate = "SELECT * 
							   FROM Museo.Mostra
							   WHERE Mostra.data_inizio > CURDATE()";
		return $this->selectValuesPreparedQuery($queryMostrePassate, []);
	}


	public function selectOpereFromSala($numeroSala): array
	{
		$queryOpere = "SELECT *
					   FROM Museo.Opera
					   WHERE Opera.id_sala = ?";
		$queryParams = [$numeroSala];
		return $this->selectValuesPreparedQuery($queryOpere, $queryParams, "i");
	}

	public function selectInfoFromSala($numeroSala): array
	{
		$queryOpere = "SELECT *
					   FROM Museo.Sala
					   WHERE Sala.id_sala = ?";
		$queryParams = [$numeroSala];
		return $this->selectValuesPreparedQuery($queryOpere, $queryParams, "i");
	}

	public function selectRecensioniWithType($recensioniType): array
	{
		$queryOpere = "SELECT *
					   FROM Museo.Recensione
					   INNER JOIN Museo.Utente ON (Recensione.id_utente = Utente.id_utente)
					   WHERE Recensione.tipo = ?";

		$queryParams = [$recensioniType];
		return $this->selectValuesPreparedQuery($queryOpere, $queryParams, "i");
	}


	public function __destruct()
	{
		if ($this->connection)
			$this->connection->close();
	}


}


?>