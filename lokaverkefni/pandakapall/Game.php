<?php
class Game{
	protected $hand;
	protected $handhistory = array();
	protected $deck;
	protected $deckhistory = array();
	protected $score;
	protected $scorehistory = array();
	protected $undo_punishment;
	public $victory;

	public function __construct(){
		$this->newGame();
	}

	public function newGame(){
		$this->hand = array();
		$this->deck = new CardDeck();
		$this->score = 100;
		$this->victory = False;
		$this->undo_punishment = 2;
		for($i = 0; $i < 4; $i++){
			array_push($this->hand, $this->deck->draw());
		}
	}

	public function	getHand(){
		return $this->hand;
	}

	public function getScore(){
		return $this->score;
	}

	public function removeTwo($index){
		if($this->checkTwo($index)){
			$this->gamehistory();
			unset($this->hand[$index], $this->hand[$index+1]);
			$this->hand = array_values($this->hand);
			$this->score += 5;
		}
	}

	public function removeFour($index){
		if($this->checkFour($index)){
			for($i=0;$i < 4; $i++){ 
				$this->gamehistory();
				unset($this->hand[$index+$i]);
			}
			$this->hand = array_values($this->hand);
			$this->score += 15;
		}
	}

	public function checkTwo($index){
		if($index <= 0 or $index+2 >= sizeof($this->hand)){
			return False;
		}
		$firstCard_str = $this->hand[$index-1];
		$lastCard_str = $this->hand[$index+2];
		if(substr($firstCard_str, 0, 1) == substr($lastCard_str, 0, 1)){
			return True;
		}
		return False;
	}

	public function checkFour($index){
		if($index < 0 or $index+4 > sizeof($this->hand)){
			return False;
		}
		$firstCard_str = $this->hand[$index];
		$lastCard_str = $this->hand[$index+3];
		if(substr($firstCard_str, 1) == substr($lastCard_str, 1)){
			return True;
		}
		return False;
	}

	public function add(){
		if(!$this->deck->isEmpty()){
			$this->gamehistory();
			array_push($this->hand, $this->deck->draw());
			$this->score--;
			return True;
		}
		return False;
	}

	public function undo(){
		if(sizeof($this->handhistory) > 0){
			$lasthand = array_pop($this->handhistory);
			$lastdeck = array_pop($this->deckhistory);
			$lastscore = array_pop($this->scorehistory) - $this->undo_punishment;
			// if(sizeof($this->hand) - sizeof($lasthand) == 1){
			// 	$this->deck->putBack(array_pop($this->hand));
			// }
			$this->hand = $lasthand;
			$this->deck = $lastdeck;
			$this->score = $lastscore;
			$this->undo_punishment += 2;
		}
	}

	public function gamehistory(){
		$this->handhistory[] = $this->hand;
		$this->deckhistory[] = $this->deck;
		$this->scorehistory[] = $this->score;
	}

	//public function moveLast(){}

	public function isWin(){
		if(sizeof($this->hand) <= 2){
			$victory = True;
			return True;
		}
		return False;
	}
}