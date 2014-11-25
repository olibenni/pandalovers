<?php
	require_once("CardDeck.php");
	require_once("Game.php");

class NewGame {

	public $game;
	public $hendi;
	
	public function __construct() {
	}

	public function newGame() {
		$this->game = new Game();
		$this->hendi = $this->game->getHand();
		$this->refreshDraw($this->hendi);
	}

	public function drawCard() {
		// var_dump($this->hendi);
		$this->game->add();
		$this->hendi = $this->game->getHand();
		$this->refreshDraw($this->hendi);
	}

	public function refreshDraw($hendi) {
		for ($i=0; $i < count($hendi); $i++) { 
			?><img id="<?php echo $i ?>"src="pandakapall/img/<?php echo $hendi[$i]; ?>.png" height="100px" width="80px"><?php
		}
	}

}
	// var_dump($game->getHand());
	// $game->add();
	// var_dump($game->getHand());
	// $game->add();
	// var_dump($game->getHand());
	// $game->add();
	// var_dump($game->getHand());

	// var_dump($hendi[43]);

	// $hendi = $game->getHand();
	// var_dump($hendi);




	// $hendi = $game->getHand();
	// var_dump($hendi);
	// $game->add();
	// $hendi = $game->getHand();
	// var_dump($hendi);
	// $game->add();
	// $hendi = $game->getHand();
	// var_dump($hendi);
	// $game->add();
	// $hendi = $game->getHand();
	// var_dump($hendi);
	// $game->add();
	// $hendi = $game->getHand();
	// var_dump($hendi);
	// $game->add();
	// $hendi = $game->getHand();
	// var_dump($hendi);
	// $game->add();
