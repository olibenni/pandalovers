<?php
require_once("CardDeck.php");
require_once("Game.php");
require('database.php');

$file_db = new PDO('sqlite:games.db');
$file_db->setAttribute(PDO::ATTR_ERRMODE, 
                        PDO::ERRMODE_EXCEPTION);

$file_db->exec("CREATE TABLE IF NOT EXISTS Saves (
        key TEXT PRIMARY KEY,
        game TEXT)");

$db = new Database($file_db);
$key = "oli";

for ($i=0; $i < 10; $i++) {
  $db->newGame("CPU" . $i, new Game());
}

function refresh($key, $db){
  $game = $db->loadGame($key);
  $hendi = $game->getHand();
  foreach ($hendi as $card) {
    ?><img id="<?php?>"src="pandakapall/img/<?php echo $card; ?>.png" height="100px" width="80px"><?php
  }
}

// ========================================
// hooka hérna upp aðferðir við takka
// $method = $_SERVER['REQUEST_METHOD'];
$card = 6;
$method = key($_POST);      //Notum þetta í bili til að gera eitthvað :)
switch ($method) {
  case 'new':
    $game = new Game();
    $db->newGame($key, $game);
    break;
  case 'draw':
    $game = $db->loadGame($key);
    $game->add();
    $db->saveGame($key, $game);
    break;
  case 'load':
    break;
  case 'undo':
    $game = $db->loadGame($key);
    $game->undo();
    $db->saveGame($key, $game);
    break;
  case 'clickedcard':
    $game = $db->loadGame($key);
    if($game->checkTwo($card) && $game->checkFour($card)){
      echo "YOLOSWAG";
      //bjóða takka til að velja á milli
    }
    elseif($game->checkTwo($card)){
      $game->removeTwo($card);
      $db->saveGame($key, $game);
    }
    elseif($game->checkFour($card)){
      $game->removeFour($card);
      $db->saveGame($key, $game);
    }else{
      echo "ILLEGAL MOVE";
    }
    break;
  case 'lastfirst':
    //TODO
    break;
  case '':
  default:
    $game->load();
    break;
}
refresh($key, $db);
var_dump($game->getScore());










// $db->saveGame("oli", $game);
// $game = $db->loadGame("oli");
// $game->add();
// var_dump($game->getHand());
// refresh($game->getHand());