<?php
class shop_lot_type extends Engine_Class {

    public function process() {
        try {
            $lotType = Shop::Get()->getLotTypeService()->getLotTypeByID($this->getArgument('id'));

            // скрытые товары показываем только админу
            if ($lotType->getHidden()) {
                if (!$this->getUser()->isAdmin()) {
                    throw new ServiceUtils_Exception('hidden');
                }
            }

            // проверяем, есть ли специфический URL
            // и делаем редирект
            $url = Engine_URLParser::Get()->getTotalURL();
            if ($lotType->getUrl() && preg_match("/^\/lot\/type\/(\d+)\/$/ius", $url)) {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: '.$lotType->makeURL());
                exit();
            }

            $game = $lotType->getGame();

            $this->setValue("gameName", $game->makeName());


            $lotTypeAll = $game->getAllLotType();
            $lotTypeAllArray = array();
            while ($x = $lotTypeAll->getNext()) {
                $lotTypeAllArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'selected' => $x->getId() == $lotType->getId() ? true:false,
                    'url' => $x->makeURL()
                );
            }

            $this->setValue('lotTypeAllArray', $lotTypeAllArray);

            $gameFilter = $lotType->getAllFilterName();
            $gameFilterNameArray = array();
            while ($x = $gameFilter->getNext()) {
                $gameFilterNameArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'additionally' => $x->getAdditionally()
                );
            }

            $gameFilterValue = $game->getAllFilterValue();
            $gameFilterValueArray = array();

            while ($x = $gameFilterValue->getNext()) {
                $gameFilterValueArray[$x->getGameFilterId()][] = array(
                    'id' => $x->getId(),
                    'value' => $x->getValue()
                );
            }

            $this->setValue('gameFilterNameArray', $gameFilterNameArray);
            $this->setValue('gameFilterValueArray', $gameFilterValueArray);

            $buyName = $lotType->getBuyText();
            if (!$buyName) {
                $buyName = $lotType->getName();
            }

            $this->setValue('buyName', $buyName);
            $this->setValue('description', $lotType->getDescription());
            $this->setValue('mustDescription', $lotType->getMustDescription());


            $lotsArray = array();

            $lots = Shop::Get()->getLotService()->getLots2($game->getId(), $lotType->getId());
            $lots->setActive(1);

            while ($x = $lots->getNext()) {
                $lotsArray[] = array(
                    'id' => $x->getId(),
                    'price' => $x->getPrice(),
                    'count' => $x->getCount(),
                    'userId' => $x->getUserId(),
                    'userName' => $x->getUserName(),
                    'description' => $x->getDescription(),
                    'filters' => array(
                        $x->getFilterId1() => $x->getFilterValue1(),
                        $x->getFilterId2() => $x->getFilterValue2(),
                        $x->getFilterId3() => $x->getFilterValue3(),
                        $x->getFilterId4() => $x->getFilterValue4(),
                        $x->getFilterId5() => $x->getFilterValue5(),
                    )
                );
            }

            $this->setValue('lotsArray', $lotsArray);


            Engine::GetHTMLHead()->setTitle(
                htmlspecialchars($game->getName() . " " .$lotType->getName())
            );
            /*

            try {
                $seo = Shop::Get()->getSEOService()->getSEOByURL(
                    Engine::GetURLParser()->getTotalURL()
                );

                if ($seo->getSeoh1()) {
                    $this->setValue('seoh1', $seo->getSeoh1());
                }
            } catch (Exception $seoEx) {

            }

            // ------------------------------------------------- //

            if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $h = 'https://';
            } else {
                $h = 'http://';
            }

            /

            // ------------------------------------------------- //

            // meta-ключевые слова
            $metaKeywords = $product->getSeokeywords();

            if (!$metaKeywords) {
                // строим ключевые слова на основе характеристик

                try {
                    $metaKeywords = $product->getCategory()->makePathName(', ');
                    $metaKeywords .= ', ';
                } catch (Exception $categoryEx) {

                }

                $metaKeywords .= $product->getName();

                try {
                    $filter_count = Engine::Get()->getConfigField('filter_count');
                } catch (Exception $e) {
                    $filter_count = 10;
                }

                for ($j = 1; $j <= $filter_count; $j++) {
                    try {
                        $filterID = $product->getField('filter'.$j.'id');
                        $filterValue = $product->getField('filter'.$j.'value');

                        if (!$filterValue) {
                            continue;
                        }

                        $filter = Shop::Get()->getShopService()->getProductFilterByID($filterID);
                        if ($filter->getHidden()) {
                            continue;
                        }

                        $metaKeywords .= ', ';
                        $metaKeywords .= $filter->getName();
                        $metaKeywords .= ' ';
                        $metaKeywords .= $filterValue;
                    } catch (Exception $filterEx) {

                    }
                }
            }

            Engine::GetHTMLHead()->setMetaKeywords(
                htmlspecialchars($metaKeywords)
            );

            // meta-описание
            $metaDescription = $product->getSeodescription();

            if (!$metaDescription) {
                $metaDescription = Shop::Get()->getSettingsService()->getSettingValue('seo-meta-description-product');
            }

            if (!$metaDescription) {
                $metaDescription = $product->getDescription();
                $metaDescription = strip_tags($metaDescription);
                $metaDescription = StringUtils_Object::Create($metaDescription)->limit(200)->__toString();
            }

            $metaDescription = $this->_processKeywords($metaDescription, $product);

            Engine::GetHTMLHead()->setMetaDescription(
                htmlspecialchars($metaDescription)
            );

            // title
            $title = $product->getSeotitle();
            if (!$title) {
                $title = Shop::Get()->getSettingsService()->getSettingValue('seo-title-product');
            }

            $title = $this->_processKeywords($title, $product);

            Engine::GetHTMLHead()->setTitle(
                htmlspecialchars($title)
            );

            // ------------------------------------------------- //

            // SEO tags
            $tags = new XShopProduct2Tag();
            $tags->setProductid($product->getId());
            $a = array();
            while ($x = $tags->getNext()) {
                try {
                    $tag = Shop::Get()->getShopService()->getProductTagByID($x->getTagid());

                    $a[] = array(
                        'name' => $tag->makeName(),
                        'url' => $tag->makeURL(),
                    );
                } catch (Exception $e) {

                }
            }
            $this->setValue('tagArray', $a);

            // ------------------------------------------------- //

            // open graph tags
            $image = $product->makeImageThumb(100);
            if ($image) {
                Engine::GetHTMLHead()->setMetaTag('og:image', Engine::Get()->getProjectURL().$image);
            }
            Engine::GetHTMLHead()->setMetaTag('og:title', $product->getName());
            Engine::GetHTMLHead()->setMetaTag('og:description', htmlspecialchars(strip_tags($product->getDescription())));*/

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