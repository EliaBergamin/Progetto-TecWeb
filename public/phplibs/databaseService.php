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
		return $preparedStatement->execute() ? $preparedStatement : null;
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
	private function updateValuesPreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding = ""): bool{
		try{
			$preparedStatement = $this->executePreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding);
			$affectedRows = $preparedStatement->affected_rows;
			$preparedStatement->close();
		}
		catch (mysqli_sql_exception $e) {
			if ($e->getCode() == 1062)
				return false;
			else
				throw new Exception(self::GLOBALERROR);
		}
		return $affectedRows > 0;
	}

	private function deleteRowPreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding = ""): bool{
		try{
			$preparedStatement = $this->executePreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding);
			$affectedRows = $preparedStatement->affected_rows;
			$preparedStatement->close();
		}
		catch (mysqli_sql_exception $e) {
			throw new Exception(self::GLOBALERROR);
		}
		return $affectedRows > 0;
	}
	public function insertUserReview($idUtente, $voto, $data_recensione, $descrizione, $tipo): bool
	{
		$queryInsertRecensione = "INSERT INTO Museo.Recensione (id_utente, voto, data_recensione, descrizione, tipo)
								  VALUES (?, ?, ?, ?, ?)";
		$queryParams = [$idUtente, $voto, $data_recensione, $descrizione, $tipo];
		self::pulisciInput($queryParams);
		return $this->insertValuesPreparedQuery($queryInsertRecensione, [$queryParams], "iissi");
	}

	public function insertUserPrenotazione($userParam, $dayParam, $visitorsParam, $timeParam): bool{
		$queryInsertPrenotazione = "INSERT INTO Museo.Prenotazione (id_utente, data_prenotazione, num_persone, orario)
									VALUES (?, ? , ? , ?)";
		$queryParams = [$userParam, $dayParam, $visitorsParam, $timeParam];
		self::pulisciInput($queryParams);
		return $this->insertValuesPreparedQuery($queryInsertPrenotazione, [$queryParams], "isis");
	}
	
	public function insertMostraAdmin($nome_mostra,$descrizione_mostra,$data_inizio,$data_fine,$img_path): bool
	{
		$queryInsertMostra = "INSERT INTO Museo.Mostra (nome, descrizione, data_inizio, data_fine, img_path)
							  VALUES (?, ?, ?, ?, ?)";
		$queryParams = [$nome_mostra, $descrizione_mostra, $data_inizio, $data_fine, $img_path];
		self::pulisciInput($queryParams);
		return $this->insertValuesPreparedQuery($queryInsertMostra, [$queryParams], "sssss");
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

	public function selectMostraByID($id_mostra): array
	{
		$queryMostrePassate = "SELECT * 
							   FROM Museo.Mostra
							   WHERE Mostra.id_mostra = ?";
		return $this->selectValuesPreparedQuery($queryMostrePassate, [$id_mostra],"i");
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

	public function selectUsersFromUsername($username): array
	{
		$queryUser = "SELECT *
					  FROM Museo.Utente
					  WHERE Utente.username = ?";

		$queryParams = [$username];
		return $this->selectValuesPreparedQuery($queryUser, $queryParams, "s");
	}

	private function pulisciInputHelper(&$item): void
	{
		if (is_string($item)) {
			$item = html_entity_decode($item, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5);
			$item = trim($item);
			$item = strip_tags($item);
		}
	}

	private function pulisciInput(&$in): void
	{
		if (is_array($in))
			array_walk_recursive($in, "self::pulisciInputHelper");
		elseif (is_string($in))
			$this->pulisciInputHelper($in);
	}

	public function insertUser($ruolo, $username, $nome, $cognome, $password_hash, $email): int
	{
		$queryUser = "INSERT INTO Museo.Utente (ruolo, username, nome, cognome, password_hash, email) 
					  VALUES (?, ?, ?, ?, ?, ?)";
		$queryParams = [$ruolo, $username, $nome, $cognome, $password_hash, $email];
		self::pulisciInput($queryParams);
		$stmt = self::executePreparedQuery($queryUser, $queryParams, "isssss");
		if ($stmt->affected_rows > 0)
			return $stmt->insert_id;
		else
			return -1;
	}
	
	public function alterMostraAdmin($id_mostra,$nome_mostra,$descrizione_mostra,$data_inizio,$data_fine,$img_path): bool {
		$query = "UPDATE Mostra SET 
                nome = ?, 
                descrizione = ?, 
                data_inizio = ?, 
                data_fine = ?, 
                img_path = ? 
              WHERE id_mostra = ?";

		$queryParams = [$nome_mostra, $descrizione_mostra, $data_inizio, $data_fine, $img_path,$id_mostra];
		self::pulisciInput($queryParams);
		return self::updateValuesPreparedQuery($query, $queryParams, "sssssi");
	}

	public function deleteMostraAdmin($id_mostra): bool{
		$query = "DELETE FROM Mostra WHERE id_mostra = ?";
		$queryParams = [$id_mostra];
		self::pulisciInput($queryParams);
		return self::deleteRowPreparedQuery($query, $queryParams, "i");
	}

	public function __destruct()
	{
		if ($this->connection)
			$this->connection->close();
	}


}


?>