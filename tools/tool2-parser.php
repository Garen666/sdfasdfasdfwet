<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$contents = file_get_contents("https://funpay.ru");

preg_match_all('/<div class="promo-games-game" data-game="\d+">\s*(<div class="promo-games-char">.+\s*<\/div>)?\s*<p class="promo-games-title\s*(bold)?\s*">\s*<a href=".*">(.+)<\/a>\s*(<sup>(.*)<\/sup>)?\s*<\/p>(.*)<\/div>/iusU', $contents, $r);


$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

foreach ($r[3] as $i => $item) {
    $arr = array();

    preg_match_all('/<a.*>(\w+)<\/a>/iusU', $r[6][$i], $r2);

    $str = "";
    foreach ($r2[1] as $item2) {
        if ($str) {
            $str .= ", ";
        }

        $str .= $item2;
    }



    $game = new ShopGame();
    $game->setName($item);
    $game->setDescriptionshort($r[5][$i]);
    if (!$game->select()) {
        $game->insert();
    }

    foreach ($r2[1] as $item2) {
        $gameType = new XLotType();
        $gameType->setGameId($game->getId());
        $gameType->setName($item2);

        if (!$gameType->select()) {
            $gameType->insert();
        }
    }

    print "#" . $game->getId();


    /*$sql = "INSERT INTO shopGame (`name`, `descriptionshort`) VALUES ('{$item}', '".$r[5][$i]."')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }*/
        print $item . " - " . $r[5][$i] . " - " . $str . "<br>\n";

}





$conn->close();