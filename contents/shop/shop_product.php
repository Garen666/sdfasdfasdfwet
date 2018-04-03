<?php
class shop_product extends Engine_Class {

    public function process() {
        $storeName = Shop::Get()->getSettingsService()->getSettingValue('shop-name');

        $this->setValue('storeTitle', $storeName);

        try {
            // получаем товар по ID
            $product = Shop::Get()->getShopService()->getProductByID(
            $this->getArgument('id')
            );

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

            // скрытые товары показываем только админу
            if ($product->getHidden()) {
                if (!$this->getUser()->isAdmin()) {
                    throw new ServiceUtils_Exception('hidden');
                }
            }

            // issue #35572
            try {
                $category = $product->getCategory();
            } catch (Exception $categoryEx) {
                $category = false;
            }

            if (!empty($category) && $category->isHidden()) {
                if (!$this->getUser()->isAdmin()) {
                    throw new ServiceUtils_Exception('hidden');
                }
            }

            // ------------------------------------------------- //

            if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $h = 'https://';
            } else {
                $h = 'http://';
            }

            if ($categorySubdomain = $product->getCategorySubdomain()) {
                $e = explode('.', Engine::GetURLParser()->getHost());
                if ($e[0] != $categorySubdomain) {
                    $u = $h.$categorySubdomain.'.'.Engine::Get()->getProjectHost().Engine::GetURLParser()->getTotalURL();
                    header('HTTP/1.1 301 Moved Permanently');
                    header('Location: '.$u);
                    exit();
                }
            }

            // проверяем, есть ли у товара специфический URL
            // и делаем редирект
            $url = Engine_URLParser::Get()->getTotalURL();
            if ($product->getUrl() && preg_match("/^\/product\/(\d+)\/$/ius", $url)) {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: '.$product->makeURL());
                exit();
            }

            //для корзины
            $this->setValue('productID',$product->getId());

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
            Engine::GetHTMLHead()->setMetaTag('og:description', htmlspecialchars(strip_tags($product->getDescription())));



            // +1 view counter
            Shop::Get()->getShopService()->viewProduct($product);

            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $this->setValue('id', $product->getId());
            $this->setValue('code', $product->makeCode());
            $this->setValue('paymentid', $product->getId() . time());
            $this->setValue('name', htmlspecialchars($product->getName()));
            $nameQuick = str_replace("'", "\'", $product->makeName());
            $this->setValue('nameQuick', $nameQuick);
            $this->setValue('description', $product->getDescription());
            if ($product->getWidth() != 0){
                $this->setValue('width', $product->getWidth());
            }
            if ($product->getHeight() != 0){
                $this->setValue('height', $product->getHeight());
            }
            if ($product->getLength() != 0){
                $this->setValue('length', $product->getLength());
            }
            if ($product->getWeight() != 0){
                $this->setValue('weight', $product->getWeight());
            }

            $this->setValue('viewed', $product->getViewed());
            $this->setValue('url', $product->makeUrl());
            $this->setValue('ordered', $product->getOrdered());
            $this->setValue('price', $product->makePriceWithTax($currencyDefault, true));
            $this->setValue('priceold', $product->makePriceOld($currencyDefault), $product->getDiscount());
            $this->setValue('discount', $product->getDiscount());
            $this->setValue('pricediscount', $product->makePriceWithTax($currencyDefault));
            $this->setValue('currency', $currencyDefault->getSymbol());
            $this->setValue('model', htmlspecialchars($product->getModel()));
            $this->setValue('unit', htmlspecialchars($product->getUnit()));
            $this->setValue('count', (($product->getDivisibility() > 0) ? ((float) $product->getDivisibility()) : 1));
            $this->setValue('avail', $product->getAvail());
            $this->setValue('availtext', htmlspecialchars($product->getAvailtext()));
            $this->setValue('share', $product->getShare());
            $this->setValue('canMakePreorder',$product->getPreorderDiscount());
            $this->setValue('avail',$product->getAvail());
            $imagesArray = array();
            foreach ($product->getImagesArray() as $image) {
                // Если нету файла на диске, то идем дальше
                if (!file_exists(PackageLoader::Get()->getProjectPath().'/media/shop/'.$image)) {
                    continue;
                }
                $size = getimagesize(PackageLoader::Get()->getProjectPath().'/media/shop/'.$image);

                if ($size[0] < 800) {
                    $originalUrl = Shop_ImageProcessor::MakeThumbProportional(PackageLoader::Get()->getProjectPath().'/media/shop/'.$image, $size[0], false, 'png');
                    $originalUrl = str_replace(PackageLoader::Get()->getProjectPath(), '', $originalUrl);
                }else {
                    $originalUrl = Shop_ImageProcessor::MakeThumbProportional(PackageLoader::Get()->getProjectPath().'/media/shop/'.$image, 800, false, 'png');
                    $originalUrl = str_replace(PackageLoader::Get()->getProjectPath(), '', $originalUrl);
                }

                $cropUrl = Shop_ImageProcessor::MakeThumbCrop(PackageLoader::Get()->getProjectPath().'/media/shop/'.$image, 210, 210, 'png');
                $cropUrl = str_replace(PackageLoader::Get()->getProjectPath(), '', $cropUrl);

                $imagesArray[] = array (
                    'originalUrl' => $originalUrl,
                    'cropUrl' => $cropUrl
                );
            }
            $this->setValue('imagesArray', $imagesArray);

            // SEO-контекнт передаем в shop-tpl
            $tpl = Engine::GetContentDriver()->getContent('shop-tpl');
            $tpl->setValue('seocontent', $product->getSeocontent());

            // иконка к товару
            try {
                $icon = $product->getIcon();

                $this->setValue('iconImage', $icon->makeImage());
                $this->setValue('iconName', $icon->makeName());
                $this->setValue('iconURL', $icon->getUrl());
            } catch (Exception $e) {

            }

            /
            $this->setValue('siteurl', $product->getSiteurl());
            $this->setValue('descriptionshort', $product->getDescriptionshort());

            $this->setValue('rating', round($product->getRating()));

            // количество голосов, на основе которых был построен рейтинг
            $ratingCount = $product->getRatingcount();
            if (!$ratingCount && $product->getRating()) {
                $ratingCount = $product->getOrdered();
            }
            $this->setValue('ratingCount', $ratingCount);

            // показывать ли кнопки соц. сетей
            if (Shop::Get()->getSettingsService()->getSettingValue('social-button')) {
                $this->setValue('showSocial', 1);
            }

            $warranty = htmlspecialchars($product->getWarranty());
            $payment = htmlspecialchars($product->getPayment());
            if (empty($warranty)) {
                $warranty = Shop::Get()->getSettingsService()->getSettingValue('warranty');
            }
            if (empty($payment)) {
                $payment = Shop::Get()->getSettingsService()->getSettingValue('payment');
            }

            $this->setValue('warranty', $warranty);
            $this->setValue('payment', $payment);

            // поставщики и баланс
            try {
                if (!$this->getUser()->isAdmin()) {
                    throw new ServiceUtils_Exception();
                }

                if (Shop_ModuleLoader::Get()->isImported('storage')) {
                    // считаем количество на складе
                    $storageArray = array();

                    $balance = StorageBalanceService::Get()->getBalanceByProductAndStoragesForSale(
                        $this->getUser(),
                        $product
                    );

                    while ($s = $balance->getNext()) {
                        try {
                            $storageArray[] = array(
                                'name' => $s->getStorageName()->getName(),
                                'count' => round($s->getAmount(), 3),
                                'price' => $s->getPrice(),
                                'currency' => Shop::Get()->getCurrencyService()->getCurrencyByID($s->getCurrencyid())->getName(),
                                'cdate' => $s->getCdate(),
                            );
                        } catch (Exception $balanceEx) {

                        }
                    }
                    $this->setValue('storageArray', $storageArray);
                }

            } catch (Exception $supplierEx) {

            }

            $this->setValue('characteristics', nl2br(htmlspecialchars($product->getCharacteristics())));

            // характеристики по данному товару;
            // одновременно строим массив опций
            $a = array();
            $optionIDArray = array();
            $filterArray = array();
            $filterNameArray = array();

            try {
                $filter_count = Engine::Get()->getConfigField('filter_count');
            } catch (Exception $e) {
                $filter_count = 10;
            }

            for ($j = 1; $j <= $filter_count; $j++) {
                try {
                    $filterID = $product->getField('filter'.$j.'id');
                    $filter = Shop::Get()->getShopService()->getProductFilterByID($filterID);
                    if ($filter->getHidden()) {
                        continue;
                    }

                    // запоминаем характеристику, может понадобиться
                    // для модельного ряда
                    $filterArray[] = $filter;

                    if ($product->getField('filter'.$j.'actual')) {

                        $filterValue = $product->getField('filter'.$j.'value');

                        if ($product->getField('filter'.$j.'actual') && $filterValue) {
                            $filterColor = '';

                            if (preg_match("/^color:(.+?)(?:\s+)(.+?)$/ius", $filterValue, $r)) {
                                // фильтр по цветам
                                $filterValue = $r[2];
                                $filterColor = $r[1];
                            } else {
                                // обычный фильтр
                                $filterValue = htmlspecialchars($filterValue);
                            }

                            $charsInfo = false;
                            if ($category && $product->getField('filter'.$j.'use')) {
                                $charsInfo = array('url' => $category->makeURL()."filter{$filter->getId()}=".urlencode($filterValue).'/', 'title' => $category->getName().' '.$filterValue);
                            }
                            $a[$filter->getName()][] = array(
                            'characteristicValue' => $filterValue,
                            'characteristicColor' => $filterColor,
                            'characteristicInfo' => $charsInfo,
                            );
                        }

                    }
                    if ($product->getField('filter'.$j.'option')) {
                        $optionIDArray[] = $filter->getId();
                    }


                } catch (Exception $e) {

                }
            }
            $this->setValue('characteristicsArray', $a);

            // опции товара
            $optionIDArray = array_unique($optionIDArray);
            $optionArray = array();
            foreach ($optionIDArray as $filterID) {
                $filter = Shop::Get()->getShopService()->getProductFilterByID(
                $filterID
                );

                // допустимые значения для данного товара
                $valueArray = array();
                for ($k = 0; $k <= $filter_count; $k++) {
                    if ($product->getField('filter'.$k.'id') == $filter->getId()
                    && $product->getField('filter'.$k.'option')
                    ) {
                        $valueArray[] = array(
                        $product->getField('filter'.$k.'value'),
                        $product->getField('filter'.$k.'markup'),
                        md5($product->getField('filter'.$k.'value'))
                        );
                    }
                }

                if (!$valueArray) {
                    continue;
                }

                $optionArray[] = array(
                'id' => $filter->getId(),
                'name' => $filter->getName(),
                'valueArray' => $valueArray,
                );
            }
            $this->setValue('optionArray', $optionArray);

            // модельный ряд
            if ($product->getSeriesname()) {
                $products = Shop::Get()->getShopService()->getProductsAll();
                $products->setHidden(0);
                $products->setDeleted(0);
                $products->setSeriesname($product->getSeriesname());
                $a = array();
                $filterValueArray = array();
                while ($x = $products->getNext()) {
                    foreach ($filterArray as $filter) {
                        try {
                            $filterNameArray[$filter->getId()] = $filter->getName();
                            $filterValueArray[$filter->getId()][$x->getId()] = $x->getFilterValue($filter, true);
                        } catch (Exception $e) {

                        }
                    }

                    $modelName = $x->getModel();
                    if (!$modelName) {
                        $modelName = $x->makeName();
                    }

                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $modelName,
                    'url' => $x->makeURL(),
                    'price' => $x->makePrice($currencyDefault, true),
                    'avail' => $x->getAvail(),
                    'availtext' => $x->getAvailtext(),
                    );
                }

                // убираем полные дубликаты
                foreach ($filterValueArray as $filterID => $x) {
                    $diffed = false;

                    $xtmp = -1;
                    foreach ($x as $tmp) {
                        if ($xtmp === -1) {
                            $xtmp = $tmp;
                        }

                        if ($tmp != $xtmp) {
                            $diffed = true;
                        } else {
                            $xtmp = $tmp;
                        }
                    }

                    if (!$diffed) {
                        unset($filterNameArray[$filterID]);
                    }
                }

                $this->setValue('seriesArray', $a);
                $this->setValue('filterValueArray', $filterValueArray);
                $this->setValue('filterNameArray', $filterNameArray);
            }

            try {
                if ($this->getUser()->isAdmin()) {
                    $this->setValue('urledit', $product->makeURLEdit());
                }
            } catch (Exception $e) {

            }

            $this->setValue('orderurl', Engine::GetLinkMaker()->makeURLByContentIDParam($this->getContentID(), $product->getId()));

            // ловим комментарий
            if ($this->getControlValue('submitcomment')) {
                try {
                    if ($this->getControlValue('ajs') != 'ready') {
                        throw new ServiceUtils_Exception('bot');
                    }

                    Shop::Get()->getShopService()->addProductComment(
                    $product,
                    $this->getUser(),
                    $this->getControlValue('postcomment'),
                    $this->getControlValue('postplus'),
                    $this->getControlValue('postminus'),
                    $this->getControlValue('commentrating'),
                    $this->getArgumentSecure('upload_image', 'file')
                    );

                    $this->setValue('message', 'commentok');
                } catch (Exception $commentException) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $commentException;
                    }

                    $this->setValue('message', 'commenterror');
                }
            }

            // новости по товару
            try {
                $news = Shop::Get()->getNewsService()->getNewsByProduct(
                $product
                );

                $a = array();
                while ($x = $news->getNext()) {
                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => htmlspecialchars($x->getName()),
                    'date' => DateTime_Formatter::DatePhonetic($x->getCdate()),
                    'url' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-news-view', $x->getId()),
                    );
                }
                $this->setValue('productnewsArray', $a);
            } catch(Exception $e) {

            }

            // комментарии по товару
            if (!$product->getDenycomments()) {
                $comments = Shop::Get()->getShopService()->getProductComments($product);
                $a = array();
                $index = 0;
                while ($x = $comments->getNext()) {
                    $name = $x->getUsername();
                    if (!$name) {
                        try {
                            $name = htmlspecialchars(Shop::Get()->getUserService()->getUserByID($x->getUserid())->getName());
                        } catch (Exception $e) {

                        }
                    }

                    $a[] = array(
                    'id' => $x->getId(),
                    'index' => $index,
                    'content' => htmlspecialchars($x->getText()),
                    'plus' => htmlspecialchars($x->getPlus()),
                    'minus' => htmlspecialchars($x->getMinus()),
                    'datetime' => DateTime_Formatter::DateISO9075($x->getCdate()),
                    'rating' => $x->getRating(),
                    'name' => $name,
                    'image' => $x->makeImage(),
                    'imagecrop' => $x->makeImageThumb(),
                    'answer' => $x->getAnswer()
                    );

                    $index ++;

                }
                $this->setValue('commentsArray', $a);

                // разрешено ли комментировать товар?
                $this->setValue('allowcomment', $this->isUserAuthorized());
                if ($this->isUserAuthorized()) {
                    $ratingArray = array(0, 1, 2, 3, 4, 5);
                    $this->setValue('ratingArray', $ratingArray);
                }

                // интеграция с внешней системой комментариев
                $integration = Shop::Get()->getSettingsService()->getSettingValue('integration-comments');
                $integration = trim($integration);
                $this->setValue('commentIntegration', $integration);
            }

            // путь к товару (хлебные крошки)
            $a = array();
            for ($i = 1; $i <= 10; $i++) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID(
                    $product->getField('category'.$i.'id')
                    );

                    $a[] = $category->makeInfoArray();
                } catch (Exception $e) {
                    break;
                }
            }
            $this->setValue('pathArray', $a);

            // связанные списки товаров
            $a = $this->_makeListsArray($product);
            $this->setValue('listsArray', $a);

            // информация о характеристиках
            $this->setValue('characteristics_message', nl2br(Shop::Get()->getSettingsService()->getSettingValue('characteristics-message')));
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

    private function _processKeywords($s, ShopProduct $product) {
        if ($product->getPrice()) {
            $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $s = str_replace('[price]', $product->makePrice($currency), $s);
        } else {
            $s = str_replace('[price]', '', $s);
        }

        if ($product->getAvail()) {
            if ($product->getAvailtext()) {
                $s = str_replace('[avail]', $product->getAvailtext(), $s);
            } else {
                $s = str_replace('[avail]', 'В наличии', $s);
            }
        } else {
            $s = str_replace('[avail]', '', $s);
        }

        $tmpArray = array();
        for ($j = 1; $j <= 10; $j++) {
            try {
                $tmp = Shop::Get()->getShopService()->getCategoryByID($product->getField('category'.$j.'id'));
                $tmpArray[] = $tmp->getName();
            } catch (Exception $ce) {

            }
        }
        if ($tmpArray) {
            $s = str_replace('[categorypath]', implode(', ', $tmpArray).'.', $s);
        } else {
            $s = str_replace('[categorypath]', '', $s);
        }

        $s = str_replace('[name]', $product->getName(), $s);
        return $s;
    }

}
