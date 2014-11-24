<?php
class Database{
	private $pdo;

	public function __construct($pdo){
		$this->pdo = $pdo;
	}

	public function newGame($key, $game){
		$game = serialize($game);
		try{
			$query = $this->pdo->prepare("INSERT INTO Saves (key, game) VALUES (:key, :game)");
			$result = $query->execute(array('key' => $key, 'game' => $game, ));
		}catch(PDOException $ex){
			$game = unserialize($game);
			$this->saveGame($key, $game);
		}
	}

	public function saveGame($key, $game){
		$game = serialize($game);
		$query = $this->pdo->prepare("UPDATE Saves SET game=? WHERE key=?");
		$result = $query->execute(array($game, $key));
	}

	public function loadGame($key){
		$query = $this->pdo->prepare("SELECT game FROM Saves WHERE key = :key");
		$result = $query->execute(array('key' => $key));
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		return unserialize($data[0]['game']);
	}

	public function fetch($key){
		try{
			$var = $this->loadGame($key);
			return true;
		}catch(PDOException $ex){
			return false;
		}
	}


	public function getHighestScores(){
		$query = $this->pdo->prepare("SELECT game, key FROM Saves LIMIT 10");
		$result = $query->execute(array());
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		$highscores = array();;

		foreach ($data as $key => $value) {
			$game = unserialize($value['game']);
			$highscores[$value['key']] = $game->getScore();
		}
		return $highscores;
	}
}