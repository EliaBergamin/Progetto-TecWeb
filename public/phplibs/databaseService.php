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
	
	private function insertValuesPreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding = ""): bool
	{
		try{
			$insertedRowsNumber = 0;
			for( $i = 0; $i < count($arrayOfValues); $i++ ){
				$preparedStatement = $this->executePreparedQuery($queryToExecute, $arrayOfValues[$i], $valueTypeForBinding);
				$insertedRowsNumber += $preparedStatement->affected_rows;
			}
			if(!is_null($preparedStatement)) $preparedStatement->close();
		}
		catch (mysqli_sql_exception $e) {
			if ($e->getCode() == 1062)
				return false;
			else
				throw new Exception(self::GLOBALERROR);
		}
		return $insertedRowsNumber > 0 ;
	}
	public function insertUserReview($idUtente, $voto, $data_recensione, $descrizione, $tipo): bool
	{
		$queryInsertRecensione = "INSERT INTO Museo.Recensione (id_utente, voto, data_recensione, descrizione, tipo)
								  VALUES (?, ?, ?, ?, ?)";
		$queryParams = [$idUtente, $voto, $data_recensione, $descrizione, $tipo];
		return $this->insertValuesPreparedQuery($queryInsertRecensione, [$queryParams], "iissi");
	}

	public function insertUserPrenotazione($userParam, $dayParam, $visitorsParam, $timeParam): bool{
		$queryInsertPrenotazione = "INSERT INTO Museo.Prenotazione (id_utente, data_prenotazione, num_persone, orario)
									VALUES (?, ? , ? , ?)";
		$queryParams = [$userParam, $dayParam, $visitorsParam, $timeParam];
		return $this->insertValuesPreparedQuery($queryInsertPrenotazione, [$queryParams], "isis");
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

	public function selectPrenotazioniFromId($idUtente): array{
		$queryPrenotazioni = "SELECT *
							  FROM Museo.Prenotazione
							  WHERE Prenotazione.id_utente = ?";
		$queryParams = [$idUtente];
		return $this->selectValuesPreparedQuery($queryPrenotazioni,$queryParams,"i");
	}
	public function __destruct()
	{
		if ($this->connection)
			$this->connection->close();
	}


}


?>