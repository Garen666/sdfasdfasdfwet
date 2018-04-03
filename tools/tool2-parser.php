<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$contents = file_get_contents("https://funpay.ru");

preg_match_all('/<div class="promo-games-game" data-game="\d+">\s*(<div class="promo-games-char">.+\s*<\/div>)?\s*<p class="promo-games-title\s*(bold)?\s*">\s*<a href=".*">(.+)<\/a>\s*(<sup>(.*)<\/sup>)?\s*<\/p>(.*)<\/div>/iusU', $contents, $r);

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



    $game = new Game();
    $game->setName($item);
    $game->setDescriptionshort($r[5][$i]);
    if (!$game->select()) {
        $game->insert();
    }

    foreach ($r2[1] as $key => $item2) {
        $gameType = new XLotType();
        $gameType->setGameId($game->getId());
        $gameType->setName($item2);

        if (!$gameType->select()) {
            $gameType->insert();
        }


        preg_match_all('/<a href="(.*)">.*<\/a>/iusU', $r2[0][$key], $rr);

        sleep(5);
        $contents2 = file_get_contents($rr[1][0]);
        preg_match_all('/<div class="form-group">\s*<label>(.*)<\/label>\s*<select class="form-control.*" name=".*">(.*)<\/select>\s*<\/div>/iusU', $contents2, $rrr);
        preg_match_all('/<div class="form-group lot-field" data-id=".*">\s*<label.*>(.*)<\/label>\s*<select class="form-control.*" name=".*">(.*)<\/select>\s*<\/div>/iusU', $contents2, $rrr2);


        foreach ($rrr[1] as $key2 => $value2) {
            $gameFilter = new XGameFilter();
            $gameFilter->setName($value2);
            $gameFilter->setGameId($game->getId());
            if (!$gameFilter->select()) {
                $gameFilter->insert();
            }


            $gameLotTypeFilter = new XGameLotTypeFilter();
            $gameLotTypeFilter->setGameFilterId($gameFilter->getId());
            $gameLotTypeFilter->setLotTypeId($gameType->getId());
            if (!$gameLotTypeFilter->select()) {
                $gameLotTypeFilter->insert();
            }

            $options = $rrr[2][$key2];
            preg_match_all('/<option value="(.*)">(.*)<\/option>/iusU', $options, $rrrr);

            foreach ($rrrr[1] as $key3 => $value3) {
                if (!$value3) {
                    continue;
                }


                $value4 = $rrrr[2][$key3];

                if (!$value4) {
                    continue;
                }

                $filterValue = new XGameFilterValue();
                $filterValue->setGameFilterId($gameFilter->getId());
                $filterValue->setValue($value4);
                $filterValue->setGameId($game->getId());
                if (!$filterValue->select()) {
                    $filterValue->insert();
                }
            }


        }

        foreach ($rrr2[1] as $key2 => $value2) {
            $gameFilter = new XGameFilter();
            $gameFilter->setName($value2);
            $gameFilter->setGameId($game->getId());
            if (!$gameFilter->select()) {
                $gameFilter->insert();
            }

            $gameLotTypeFilter = new XGameLotTypeFilter();
            $gameLotTypeFilter->setGameFilterId($gameFilter->getId());
            $gameLotTypeFilter->setLotTypeId($gameType->getId());
            if (!$gameLotTypeFilter->select()) {
                $gameLotTypeFilter->insert();
            }

            $options = $rrr2[2][$key2];
            preg_match_all('/<option.*>(.*)<\/option>/iusU', $options, $rrrr);

            foreach ($rrrr[1] as $key3 => $value3) {
                if (!$value3 || $value3 == "&nbsp;") {
                    continue;
                }

                $filterValue = new XGameFilterValue();
                $filterValue->setGameFilterId($gameFilter->getId());
                $filterValue->setValue($value3);
                $filterValue->setGameId($game->getId());
                if (!$filterValue->select()) {
                    $filterValue->insert();
                }
            }
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