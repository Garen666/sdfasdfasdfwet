<?php
class shop_search_json_autocomplete extends Engine_Class {

    public function process() {
        try {
            $query = $this->getArgument('name');

            try {
                $searchOptionArray = Engine::Get()->getConfigField('search-options');
            } catch (Exception $e) {
                $searchOptionArray = array('product', 'category', 'page');
            }

            $a = array();

            foreach ($searchOptionArray as $searchKey) {
                if ($searchKey == 'product') {
                    // поиск по товарам
                    $products = Shop::Get()->getShopService()->searchProducts($query, false);
                    $products->setLimitCount(10);

                    $a = array_merge($a,$this->_getObjectArray($products));
                } else {
                    $object = Shop::Get()->getShopService()->searchObgectByName($query, $searchKey, false);
                    $object->setLimitCount(3);
                    $a = array_merge($a,$this->_getObjectArray($object));
                }
            }
            echo json_encode($a);
        } catch (Exception $e) {

        }

        exit();
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
