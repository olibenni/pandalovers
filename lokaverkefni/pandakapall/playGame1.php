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
$key = "";           //Notum þetta í bili til að gera eitthvað :) sækum seinna lykil úr notendanafni.
try{
  $game = $db->loadGame($key);
}catch(Exception $e){
  $game = new Game();
  $db->newGame($key, $game);
  echo "virkar";
}

for ($i=0; $i < 10; $i++) {
  $db->newGame("CPU" . $i, new Game());
}

$method = key($_POST);
switch ($method) {
  case 'new':
    $game = new Game();
    $db->newGame($key, $game);
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
    // if($game->checkTwo($card) && $game->checkFour($card)){
    //   echo "YOLOSWAG";
    //   //bjóða takka til að velja á milli
    // }
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
$db->saveGame($key, $game);
function refresh($key, $db){
  $game = $db->loadGame($key);
  $hendi = $game->getHand();
  foreach ($hendi as $index => $card) {
    echo "<img id='$card' onclick='cardclicked($index)' src='pandakapall/img/$card.png' height='100px' width='80px'>";
  }
}
if($game->isWin()){
  echo "WINNER";
}else{
  refresh($key, $db);
  if( $game->isDeckEmpty()){
      echo "<button id='moveLast' onclick='moveLast()''>Put last card first</button>";
  }
}
var_dump($game->getScore());


// $key = isset($_GET['key']) ? $_GET['key'] : '';
// if ($key == ''){
//   //fela load og highscore, og draw.
//   $key = uniqid();
// }
// if($key !== ''){
//   $url = "http://localhost/mitt/test2.php?key=". $key;
//   echo "<p style= 'clear:both;'>";
//   echo "<br>";
//   echo "Hlekkur á todo listann þinn: <a href = '$url'>$key</a>";
//   echo "</p>";
  
// }