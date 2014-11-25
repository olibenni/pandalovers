<?php
require("CardDeck.php");
require("Game.php");
require('database.php');



session_start();

if (isset($_SESSION["game"]) && isset($_SESSION["timeStamp"]) && (time() - $_SESSION["timeStamp"] < 86400*7)) {
  $game = unserialize($_SESSION["game"]);
} else {
  $_SESSION["timeStamp"] = time();
  $game = new Game();
}


$method = key($_POST);
switch ($method) {
  case 'new':
    $game = new Game();
    break;
  case 'draw':
    $game->add();
    break;
  case 'load':
    break;
  case 'undo':
    $game->undo();
    break;
  case 'clickedcard':
    $card = $_POST['card'];
    if($game->checkTwo($card) && $game->checkFour($card)){
      echo "YOLOSWAG";
    }
    if($game->checkTwo($card)){
      $game->removeTwo($card);
    }
    elseif($game->checkFour($card)){
      $game->removeFour($card);
    }else{
      break;
    }
    break;
  case 'lastfirst':
    $game->moveLast();
    break;
  case '':
  default:
    break;
}

$_SESSION["game"] = serialize($game);

function refresh($game){
  if($game->isWin()){
      echo "WINNER";
  }else{
    $hendi = $game->getHand();
    foreach ($hendi as $index => $card) {
      echo "<img id='$card' onclick='cardclicked($index)' src='pandakapall/img/$card.png' height='100px' width='80px'>";
    }
    echo "<p id='score'>Score ". $game->getScore() ."</p>";
    if( $game->isDeckEmpty()){
      echo "<button id='moveLast' onclick='moveLast()''>Put last card first</button>";
    }
  }
}
refresh($game);