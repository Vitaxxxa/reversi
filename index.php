<?php
include('data/player.php');
include('data/board.php');
session_start();

if (isset($_POST['new_game'])){ //if start NEW GAME!!!!!!
    $player1 = new Player();    //create new player1
    $player1->setName('Ivan');  //set name for first player
    $player1->setId(1);     //set ID for first player

    $player2 = new Player();    //create new player2
    $player2->setName('Petro'); //set name for second player
    $player2->setId(2);      //set ID for second player

    $board = new Board();       //create object BOARD
    $board->createBoard(8);     //create board with size=8*8

    $currentPlayer=$player1->getId();   //set current player move
    $waitPlayer=$player2->getId();      //set wait player

    $board->setStartPosition($currentPlayer,$waitPlayer); //set start position for players
    $board->showMoves($currentPlayer,$waitPlayer); //show possible moves for current player

    saveGame();                 //save game to $_SESSION

}elseif (isset($_GET['x']) AND isset($_GET['y'])) { //if player try to MOVE!!!!!

    loadGame();                 //load current game from $_SESSION

    $board->movePlayer($currentPlayer,$waitPlayer,$_GET['x'],$_GET['y']); //move current player!!!!!!

        if ($currentPlayer == $player1->getId()){   //shift players (current and wait)
            $currentPlayer=$player2->getId();       //shift players (current and wait)
            $waitPlayer=$player1->getId();          //shift players (current and wait)
        }else{                                      //shift players (current and wait)
            $currentPlayer=$player1->getId();       //shift players (current and wait)
            $waitPlayer=$player2->getId();          //shift players (current and wait)
        }

    $board->showMoves($currentPlayer,$waitPlayer);

    saveGame();                 //save game to $_SESSION

}else{          //if './' TRY to load current game                   
    loadGame(); // load current game from $_SESSION
}

if (isset($_POST['clear'])){    //clear current SESSION!!!
    $_SESSION = array();        //clear current SESSION!!!   
}                               //clear current SESSION!!!
?>

    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="data/style.css">
        <title>REVERSI GAME</title>
    </head>
        
    <body>
        <center>
        <? if ($_SESSION['board'] != '') : ?>
        <table>
            <tr>
                <td align="center">
                    <h2>Now turn : 
                        <? if ($currentPlayer==$player1->getId()){
                                echo "".$player1->getName().""; 
                                echo "<div class='player_1' style='width:60px;height:60px;'></div>";
                        }else{ 
                                echo "".$player2->getName().""; 
                                echo "<div class='player_2' style='width:60px;height:60px;' ></div>";
                        }?>
                    </h2>
                </td>
                <td>
                    <table>
                        <tr>
                            <td> 
                                <div class='player_1'><b><?=$player1->getCount($board->getArea()) ?></b></div> 
                            </td>
                            <td>
                                <div class='player_2'><b><?=$player2->getCount($board->getArea()) ?></b></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <?=$board->showBoard($player1->getId(),$player2->getId()); ?>
                </td>
        <? endif; ?>
                <td>
                    <form method="POST">
                        <input type="submit" name="new_game" value="NEW Game">
                    </form>
                    <form method="POST">
                        <input type="submit" name="clear" value="clear session">
                    </form>
                </td>
            </tr>
        </table>
        </center>
        <pre>
            <?=print_r($_SESSION); ?>
        </pre>
    </body>
</html>

<?php
function saveGame(){
    global $board;
    global $player1;
    global $player2;
    global $currentPlayer;
    global $waitPlayer;
    $_SESSION['board']=$board;
    $_SESSION['player1']=$player1;
    $_SESSION['player2']=$player2;
    $_SESSION['currentPlayer']=$currentPlayer;
    $_SESSION['waitPlayer']=$waitPlayer;
}

function loadGame(){
    global $board;
    global $player1;
    global $player2;
    global $currentPlayer;
    global $waitPlayer;
    $board=$_SESSION['board'];
    $player1=$_SESSION['player1'];
    $player2=$_SESSION['player2'];
    $currentPlayer=$_SESSION['currentPlayer'];
    $waitPlayer=$_SESSION['waitPlayer'];
}
?>
