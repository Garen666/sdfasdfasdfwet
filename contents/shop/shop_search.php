<?php
class shop_search extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgument('query');
            $query = str_replace('/',' ',$query);
            $url = Engine::GetLinkMaker()->makeURLByContentIDParam('shop-search', urlencode($query), 'queryfixed');
            header('Location: '.$url);
            exit();
        } catch (Exception $e) {

        }

        try {
            $query = urldecode($this->getArgument('queryfixed'));
            Engine::GetURLParser()->setArgument('query', $query);

            $this->setValue('name', $query, true);
            Engine::GetHTMLHead()->setTitle($this->getControlValue('query'));
            $slogan = Shop::Get()->getSettingsService()->getSettingValue('shop-slogan');
            if ($slogan) {
                Engine::GetHTMLHead()->setMetaDescription($slogan);
            }

            try {
                $searchOptionArray = Engine::Get()->getConfigField('search-options');
            } catch (Exception $e) {
                $searchOptionArray = array('product', 'category', 'page');
            }

            $a = array();

            $page = intval($this->getArgumentSecure('p')); // на следующих страницах выводим только товары

            foreach ($searchOptionArray as $searchKey) {
                if ($searchKey == 'product') {
                    $products = Shop::Get()->getShopService()->searchProducts(
                        $query
                    );
                    $products->setHidden(0);
                    $render = Engine::GetContentDriver()->getContent('shop-product-list');
                    $render->setValue('filtercategory', true);
                    $render->setValue('items', $products);
                    $render->setValue('need_relevance_sort', true);
                    $a[$searchKey] = $render->render();
                } elseif (!$page) {
                    $object = Shop::Get()->getShopService()->searchObgectByName($query, $searchKey, false);
                    $object->setLimitCount(3);
                    $a[$searchKey] = $this->_getObjectArray($object);
                }
            }

            $this->setValue('resultArray',$a);

        } catch (Exception $e) {
            $this->setValue('error', true);
        }
    }

    private function _getObjectArray($object) {
        $a = array();
        while ($x = $object->getNext()) {
            if (get_class($object) == 'ShopTextPage') {
                $description = strip_tags($x->getContent());
                $image = $x->makeImage();
            } else {
                $description = strip_tags($x->getDescription());
                $image = $x->makeImageThumb(100);
                if (!$image) {
                    $image = Shop_ImageProcessor::MakeThumbUniversal(PackageLoader::Get()->getProjectPath().'/media/shop/stub.jpg', 100);
                }
            }
            $description = StringUtils_Limiter::LimitWordsSmart($description, 20);

            $a[] = array(
                'id' => $x->getId(),
                'name' => htmlspecialchars($x->getName()),
                'url' => $x->makeURL(),
                'image' => $image,
                'description' => $description,
            );
        }
        return $a;
    }

}