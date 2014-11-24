<?php
class PlayClass{
	protected $db;
	protected $key;

	public function __construct($db, $key){
		$this->db = $db;
		$this->key = $key;
	}

	public function refresh(){
		$game = $this->db->loadGame($this->key);
		$hendi = $game->getHand();
		foreach ($hendi as $card) {
			?><img id="<?php?>"src="pandakapall/img/<?php echo $card; ?>.png" height="100px" width="80px"><?php
		}
	}

	function newgame(){
		$game = new Game();
		$this->db->newGame($this->key, $game);
		$this->refresh();
	}
	function drawingcard(){
		$game = $this->db->loadGame($this->key);
		$game->add();
		$this->db->saveGame($this->key, $game);
		$this->refresh();
	}


	function undo(){
		$game = $this->db->loadGame($this->key);
		$game->undo();
		$this->db->saveGame($this->key, $game);
		$this->refresh();
	}
	
	function checkTwo($index){
		$game = $this->db->loadGame($this->key);
		return $game->checkTwo($index);
	}

	function checkFour($index){
		$game = $this->db->loadGame($this->key);
		return $game->checkFour($index);
	}

	function removeTwo($index){
		$game = $this->db->loadGame($this->key);
		$game->removeTwo($index);
		$this->db->saveGame($this->key, $game);
		$this->refresh();	
	}

	function removeFour($index){
		$game = $this->db->loadGame($this->key);
		$game->removeFour($index);
		$this->db->saveGame($this->key, $game);
		$this->refresh();	
	}

	function lastfirst(){}
}