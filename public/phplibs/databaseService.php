<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class DatabaseService
{
	private const HOST = "database";
	private const NAME = "Museo";
	private const USER = "user";
	private const PASS = "userpassword";

	private const GLOBALERROR = "ERROR encountered in databaseService.php";


	private $connection;

	public function __construct()
	{
		try {
			$this->connection = new mysqli(self::HOST, self::USER, self::PASS, self::NAME);
		} catch (mysqli_sql_exception $e) {
			throw new Exception(self::GLOBALERROR);
		}
	}

	public function __destruct()
	{
		if ($this->connection)
			$this->connection->close();
	}

	private function executePreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding = ""): mysqli_stmt
	{
		self::pulisciInput($arrayOfValues);
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
			throw new Exception(self::GLOBALERROR);
		}
	}

	private function insertValuesPreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding = ""): bool
	{
		try {
			$insertedRowsNumber = 0;
			for ($i = 0; $i < count($arrayOfValues); $i++) {
				$preparedStatement = $this->executePreparedQuery($queryToExecute, $arrayOfValues[$i], $valueTypeForBinding);
				$insertedRowsNumber += $preparedStatement->affected_rows;
			}
			if (!is_null($preparedStatement))
				$preparedStatement->close();
		} catch (mysqli_sql_exception $e) {
			if ($e->getCode() == 1062)
				return false;
			else
				throw new Exception(self::GLOBALERROR);
		}
		return $insertedRowsNumber > 0;
	}
	private function updateValuesPreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding = ""): bool
	{
		try {
			$preparedStatement = $this->executePreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding);
			$affectedRows = $preparedStatement->affected_rows;
			$preparedStatement->close();
		} catch (mysqli_sql_exception $e) {
			if ($e->getCode() == 1062)
				return false;
			else
				throw new Exception(self::GLOBALERROR);
		}
		return $affectedRows > 0;
	}

	private function deleteRowPreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding = ""): bool
	{
		try {
			$preparedStatement = $this->executePreparedQuery($queryToExecute, $arrayOfValues, $valueTypeForBinding);
			$affectedRows = $preparedStatement->affected_rows;
			$preparedStatement->close();
		} catch (mysqli_sql_exception $e) {
			throw new Exception(self::GLOBALERROR);
		}
		return $affectedRows > 0;
	}
	public function insertUserReview($idUtente, $voto, $data_recensione, $descrizione, $tipo): bool
	{
		$queryInsertRecensione = "INSERT INTO Recensione (id_utente, voto, data_recensione, descrizione, tipo)
								  VALUES (?, ?, ?, ?, ?)";
		$queryParams = [$idUtente, $voto, $data_recensione, $descrizione, $tipo];
		return $this->insertValuesPreparedQuery($queryInsertRecensione, [$queryParams], "iissi");
	}

	public function insertPrenotazione($userParam, $dayParam, $visitorsParam, $timeParam): bool
	{
		$queryInsertPrenotazione = "INSERT INTO Prenotazione (id_utente, data_prenotazione, num_persone, orario)
									VALUES (?, ? , ? , ?)";
		$queryParams = [$userParam, $dayParam, $visitorsParam, $timeParam];
		return $this->insertValuesPreparedQuery($queryInsertPrenotazione, [$queryParams], "isis");
	}

	public function insertMostra($nome, $descrizione, $data_inizio, $data_fine, $img_path): bool
	{
		$queryInsertMostra = "INSERT INTO Mostra (nome, descrizione, data_inizio, data_fine, img_path)
							  VALUES (?, ?, ?, ?, ?)";
		$queryParams = [$nome, $descrizione, $data_inizio, $data_fine, $img_path];
		return $this->insertValuesPreparedQuery($queryInsertMostra, [$queryParams], "sssss");
	}
	public function selectMostrePassate($extended = true): array
	{
		$queryMostrePassate = $extended ?
							"SELECT * 
							FROM Mostra
							WHERE Mostra.data_fine < CURDATE()
							ORDER BY Mostra.data_fine DESC" : 
							"SELECT * 
							FROM Mostra
							WHERE Mostra.data_fine < CURDATE()
							ORDER BY Mostra.data_fine DESC
							LIMIT 3";
		return $this->selectValuesPreparedQuery($queryMostrePassate, []);
	}

	public function selectMostreCorrenti($extended = true): array
	{
		$query = $extended ?
				"SELECT * 
				 FROM Mostra
				 WHERE CURDATE() BETWEEN data_inizio AND data_fine
				 ORDER BY Mostra.data_fine DESC" :
				"SELECT id_mostra, nome, img_path, alt
				 FROM Mostra
				 WHERE CURDATE() BETWEEN data_inizio AND data_fine
				 ORDER BY Mostra.data_fine ASC
				 LIMIT 3";
		return $this->selectValuesPreparedQuery($query, []);
	}

	public function selectMostraByID($id_mostra): array
	{
		$queryMostrePassate = "SELECT * 
							   FROM Mostra
							   WHERE Mostra.id_mostra = ?";
		return $this->selectValuesPreparedQuery($queryMostrePassate, [$id_mostra], "i");
	}
	public function selectMostreFuture($extended = true): array
	{
		$query = $extended ?
				"SELECT * 
				 FROM Mostra
				 WHERE Mostra.data_inizio > CURDATE()
				 ORDER BY Mostra.data_inizio ASC" :
				"SELECT id_mostra, nome, img_path, alt
				 FROM Mostra
				 WHERE Mostra.data_inizio > CURDATE()
				 ORDER BY Mostra.data_inizio ASC
				 LIMIT 3";
		return $this->selectValuesPreparedQuery($query, []);
	}


	public function selectOpereFromSala($numeroSala): array
	{
		$queryOpere = "SELECT *
					   FROM Opera
					   WHERE Opera.id_sala = ?";
		$queryParams = [$numeroSala];
		return $this->selectValuesPreparedQuery($queryOpere, $queryParams, "i");
	}
	public function selectOperaInfoFromId($id): array
	{
		$queryOpere = "SELECT Opera.nome AS nome, Opera.descrizione AS descrizione, anno, autore, 
					   Opera.img_path AS img_path, Sala.nome AS sala
					   FROM Opera 
					   JOIN Sala ON (Opera.id_sala = Sala.id_sala)
					   WHERE Opera.id_opera = ?";
		$queryParams = [$id];
		return $this->selectValuesPreparedQuery($queryOpere, $queryParams, "i");
	}

	public function selectInfoFromSala($numeroSala): array
	{
		$queryOpere = "SELECT *
					   FROM Sala
					   WHERE Sala.id_sala = ?";
		$queryParams = [$numeroSala];
		return $this->selectValuesPreparedQuery($queryOpere, $queryParams, "i");
	}

	public function selectRecensioniWithType($recensioniType): array
	{
		$queryOpere = "SELECT *
					   FROM Recensione
					   INNER JOIN Utente ON (Recensione.id_utente = Utente.id_utente)
					   WHERE Recensione.tipo = ?
					   ORDER BY Recensione.data_recensione DESC";
		$queryParams = [$recensioniType];
		return $this->selectValuesPreparedQuery($queryOpere, $queryParams, "i");
	}

	public function selectInfoUtenteFromId($idUtente): array
	{
		$queryUtente = "SELECT *
						FROM Utente
						WHERE Utente.id_utente = ?";
		$queryParams = [$idUtente];
		return $this->selectValuesPreparedQuery($queryUtente, $queryParams, "i");
	}
	public function selectPrenotazioniFromId($idUtente): array
	{
		$queryPrenotazioni = "SELECT *
							  FROM Prenotazione
							  WHERE Prenotazione.id_utente = ?";
		$queryParams = [$idUtente];
		return $this->selectValuesPreparedQuery($queryPrenotazioni, $queryParams, "i");
	}

	public function selectUsersFromUsername($username): array
	{
		$queryUser = "SELECT *
					  FROM Utente
					  WHERE Utente.username = ?";

		$queryParams = [$username];
		return $this->selectValuesPreparedQuery($queryUser, $queryParams, "s");
	}
	public function selectUsersFromEmail($email): array
	{
		$queryUser = "SELECT *
					  FROM Utente
					  WHERE Utente.email = ?";

		$queryParams = [$email];
		return $this->selectValuesPreparedQuery($queryUser, $queryParams, "s");
	}

	public function selectPrenotazioniPerData($date): array
	{
		$querySlots = "SELECT 
						orario AS slot_orario, 
						SUM(num_persone) AS posti_occupati
					FROM Prenotazione
					WHERE data_prenotazione = ?
					GROUP BY orario
					ORDER BY orario;";

		$queryParams = [$date];
		return $this->selectValuesPreparedQuery($querySlots, $queryParams, "s");
	}

	private function pulisciInputHelper(&$item): void
	{
		if (is_string($item)) {
			$item = html_entity_decode($item, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5);
			$item = trim($item);
			$item = strip_tags($item);
		}
	}

	public static function cleanedInput($input): string
	{
		$input = trim($input);
		$input = strip_tags($input, "<span><a>");
		$input = htmlentities($input);
		return $input;
	}

	private function pulisciInput(&$in): void
	{
		if (is_array($in))
			array_walk_recursive($in, "DatabaseService::pulisciInputHelper");
		elseif (is_string($in))
			$this->pulisciInputHelper($in);
	}

	public function insertUser($ruolo, $username, $nome, $cognome, $password_hash, $email): int
	{
		$queryUser = "INSERT INTO Utente (ruolo, username, nome, cognome, password_hash, email) 
					  VALUES (?, ?, ?, ?, ?, ?)";
		$queryParams = [$ruolo, $username, $nome, $cognome, $password_hash, $email];
		$stmt = $this->executePreparedQuery($queryUser, $queryParams, "isssss");
		if ($stmt->affected_rows > 0)
			return $stmt->insert_id;
		else
			return -1;
	}

	public function alterMostraAdmin($id_mostra, $nome, $descrizione, $data_inizio, $data_fine, $img_path): bool
	{
		$query = ($img_path && !empty($img_path)) ?
			"UPDATE Mostra SET 
                nome = ?, 
                descrizione = ?, 
                data_inizio = ?, 
                data_fine = ?, 
                img_path = ? 
              	WHERE id_mostra = ?" :
			"UPDATE Mostra SET 
				nome = ?, 
				descrizione = ?, 
				data_inizio = ?, 
				data_fine = ? 
			  	WHERE id_mostra = ?";
		$types = $img_path ? "sssssi" : "ssssi";
		$queryParams = $img_path ? [$nome, $descrizione, $data_inizio, $data_fine, $img_path, $id_mostra] : [$nome, $descrizione, $data_inizio, $data_fine, $id_mostra];
		return self::updateValuesPreparedQuery($query, $queryParams, $types);
	}

	public function deleteMostraAdmin($id_mostra): bool
	{
		$query = "DELETE FROM Mostra WHERE id_mostra = ?";
		$queryParams = [$id_mostra];
		return self::deleteRowPreparedQuery($query, $queryParams, "i");
	}
	public function deletePrenotazioneUser($idUtente, $data_prenotazione): bool
	{
		$query = "DELETE FROM Prenotazione WHERE id_utente = ? AND data_prenotazione = ?";
		$queryParams = [$idUtente, $data_prenotazione];
		return self::deleteRowPreparedQuery($query, $queryParams, "is");
	}
	public function checkVisitatori($giorno, $orario, $visitatori): bool
	{
		$query = "SELECT SUM(num_persone) AS tot_visitatori
				  FROM Prenotazione
				  WHERE data_prenotazione = ? AND orario = ?";
		$queryParams = [$giorno, $orario];
		$result = $this->selectValuesPreparedQuery($query, $queryParams, "ss");
		return $result[0]["tot_visitatori"] + $visitatori <= 90;
	}
}
?>