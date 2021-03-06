<?php
class lot_type_sale extends Engine_Class {

    public function process() {

        try {
            $lotType = Shop::Get()->getLotTypeService()->getLotTypeByID($this->getArgument('id'));
            $user = $this->getUser();
            $game = $lotType->getGame();


            // скрытые товары показываем только админу
            if ($lotType->getHidden()) {
                if (!$this->getUser()->isAdmin()) {
                    throw new ServiceUtils_Exception('hidden');
                }
            }

            // проверяем, есть ли специфический URL
            // и делаем редирект
            /*$url = Engine_URLParser::Get()->getTotalURL();
            if ($lotType->getUrl() && preg_match("/^\/lot\/type\/(\d+)\/$/ius", $url)) {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: '.$lotType->makeURL());
                exit();
            }*/


            if ($this->getArgumentSecure('save')) {


                if ($lotType->getType() == "money") {
                    Shop::Get()->getLotService()->updateMinSum(
                        $user->getId(),
                        $lotType->getId(),
                        $this->getArgumentSecure('minsum')
                    );

                    $filters = array();
                    $filters[0] = array();

                    $filtersId = array();
                    $filtersId[0] = array();


                    foreach ($this->getArguments() as $key => $value) {
                        if (strpos($key, 'filter') === 0) {
                            $filters[] = $value;
                            $filtersId[] = str_replace('filter', '', $key);
                        }
                    }

                    $actives = $this->getArgumentSecure('active');
                    $prices = $this->getArgumentSecure('price');
                    $counts = $this->getArgumentSecure('count');

                    foreach ($actives as $key => $value) {

                        Shop::Get()->getLotService()->addLot(
                            $user->getId(),
                            $user->makeName(),
                            $game->getId(),
                            $lotType->getId(),
                            $value,
                            @$prices[$key],
                            @$counts[$key],
                            '',
                            '',
                            @$filtersId[1],
                            @$filters[1][$key],
                            @$filtersId[2],
                            @$filters[2][$key],
                            @$filtersId[3],
                            @$filters[3][$key],
                            @$filtersId[4],
                            @$filters[4][$key],
                            @$filtersId[5],
                            @$filters[5][$key]
                        );
                    }
                } else {

                }




            }



            $this->setValue("gameName", $game->makeName());
            $this->setValue("lotType", $lotType->getType());
            $this->setValue("lotTypeName", $lotType->getName());
            $this->setValue("lotTypeUrl", $lotType->makeURL());

            if ($lotType->getType() == "money") {
                $lineArray = array();

                $gameFilter = $lotType->getAllFilterName();
                $gameFilterNameArray = array();
                while ($x = $gameFilter->getNext()) {
                    $gameFilterNameArray[$x->getId()] = array(
                        'id' => $x->getId(),
                        'name' => $x->getName(),
                        'additionally' => $x->getAdditionally()
                    );
                }

                $gameFilterNameArrayClone = $gameFilterNameArray;


                $gameFilterValue = $game->getAllFilterValue();
                $gameFilterValueArray = array();

                while ($x = $gameFilterValue->getNext()) {
                    $gameFilterValueArray[$x->getGameFilterId()][] = array(
                        'id' => $x->getId(),
                        'value' => $x->getValue()
                    );
                }

                //$this->setValue('gameFilterValueArray', $gameFilterValueArray);
                $this->setValue('gameFilterNameArray', $gameFilterNameArray);

                if (count($gameFilterNameArray) == 0) {

                } else if (count($gameFilterNameArray) == 1) {
                    $filter1 = array_shift($gameFilterNameArrayClone)['id'];

                    foreach ($gameFilterValueArray[$filter1] as $key2 => $value2) {
                        $lineArray[] = array($filter1 => array('value' => $value2["value"]));
                    }
                } else if (count($gameFilterNameArray) == 2) {
                    ksort($gameFilterNameArrayClone);

                    $filter1 = array_shift($gameFilterNameArrayClone)["id"];
                    $filter2 = array_shift($gameFilterNameArrayClone)["id"];

                    $lots = Shop::Get()->getLotService()->getLots3($user->getId(), $game->getId(), $lotType->getId());
                    $lotsArray = array();

                    while ($x = $lots->getNext()) {
                        $lotsArray[$x->getFilterId1()][$x->getFilterValue1()][$x->getFilterId2()][$x->getFilterValue2()] = array(
                            'price' => $x->getPrice(),
                            'count' => $x->getCount(),
                            'active' => $x->getActive()
                        );
                    }

                    $arr = array();
                    foreach ($gameFilterValueArray[$filter1] as $key1 => $value1) {
                        foreach ($gameFilterValueArray[$filter2] as $key2 => $value2) {
                            $lineArray[] = array(
                                $filter1 => array(
                                    'value' => $value1['value']
                                ),
                                $filter2 => array(
                                    'value' => $value2['value']
                                ),
                                'count' => @$lotsArray[$filter1][$value1['value']][$filter2][$value2['value']]['count'],
                                'price' => @$lotsArray[$filter1][$value1['value']][$filter2][$value2['value']]['price'],
                                'active' => @$lotsArray[$filter1][$value1['value']][$filter2][$value2['value']]['active'],
                            );


                            $arr[] = $value1['value']. '|' . $value2['value'];
                        }
                    }
                } else if (count($gameFilterNameArray) == 3) {

                }
                $this->setValue('lineArray', $lineArray);


                $this->setValue('minSum', Shop::Get()->getLotService()->getMinSum($user->getId(), $lotType->getId()));



            } else {

            }




            $gameFilter = $lotType->getAllFilterName();
            $gameFilterNameArray = array();
            while ($x = $gameFilter->getNext()) {
                $gameFilterNameArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'additionally' => $x->getAdditionally()
                );
            }







            Engine::GetHTMLHead()->setTitle(
                htmlspecialchars($game->getName() . " " .$lotType->getName())
            );

        } catch (Exception $ge) {
            if (method_exists($ge, 'log')) {
                $ge->log();
            }

            Engine::Get()->getRequest()->setContentNotFound();

            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }
        }
    }
}