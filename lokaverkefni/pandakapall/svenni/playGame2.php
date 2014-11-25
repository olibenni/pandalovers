<?php
require("CardDeck.php");
require("Game.php");
require("newGame.php");

session_start();
// $_SESSION["playGame"] = null;
// session_unset($_SESSION["playGame"]);
// session_unset();

if (isset($_SESSION["playGame"])) {
	echo "SESSION SETT";
	// $game = serialize($_SESSION["playGame"]);
	$game = unserialize($_SESSION["playGame"]);
	// var_dump($game);
} else {
	echo "SESSION ekki sett";
	$game = new NewGame();
}

if (isset($_POST["newGame"])) {
	$game->newGame();
} else if (isset($_POST["drawCard"])) {
	$game->drawCard();
}

$_SESSION["playGame"] = serialize($game);

// if (isset($_POST["newGame"])) {

// }
