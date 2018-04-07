<?php
class lot_type_sale_other extends Engine_Class {

    public function process() {

        try {
            $this->setValue('id', $this->getArgument('id'));
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
                    Shop::Get()->getLotService()->updateMinSum($user->getId(), $lotType->getId(), $this->getArgumentSecure('minsum'));

                    $gameFilter = $lotType->getAllFilterName();
                    $gameFilterNameArray = array();
                    while ($x = $gameFilter->getNext()) {
                        $gameFilterNameArray[$x->getId()] = $x->getId();
                    }


                    ksort($gameFilterNameArray);

                    $filters = array();
                    $filters[0] = array();

                    $filtersId = array();
                    $filtersId[0] = array();

                    foreach ($gameFilterNameArray as $filterId) {
                        $filters[] = $this->getArgumentSecure('filter'.$filterId);
                        $filtersId[] = $filterId;
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