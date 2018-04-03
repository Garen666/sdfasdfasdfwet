<?php
class ajax_category_manager extends Engine_Class {

    public function process() {
        $a = $this->getArgumentSecure('listArray');
        if ($a) {
            $a = explode('&',$a);
            // строим массив ключ - id категории, значение - id родителя
            $categoryArray = array();
            foreach ($a as $val) {
                // получаемые значения хранятся в виде list[$id] = $parentId,
                // если парента нету, list[$id] = null
                $tmp = explode('=', $val);
                // убераем лишнее, оставляем только число
                $id = preg_replace("/\D/","",$tmp[0]);
                $parentID = $tmp[1];
                $categoryArray[$id] = $parentID;
            }
            $index = 0;
            foreach ($categoryArray as $id => $parentID) {
                try {
                    SQLObject::TransactionStart();
                    $category = Shop::Get()->getShopService()->getCategoryByID($id);
                    if ($category->getParentid() != $parentID || $category->getSort() != $index) {
                        $category->setParentid($parentID);
                        $category->setSort($index);
                    }
                    $category->update();

                    $index++;
                    SQLObject::TransactionCommit();
                } catch (ServiceUtils_Exception $e) {
                    SQLObject::TransactionRollback();
                }
            }


            // Сделано по дыбильному. Другого метода пока не нашел.
            // @TODO переделать по нормальному.
            // 1 SQL-запросом перестроить дерево категорий у всех товаров в этой категории.
            
            // Обновляем дерево категорий у товаров.
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setOrderBy('categoryid'); // оптимизация кеша по категориям

            $transactions = 250;
            $index = 0;

            SQLObject::TransactionStart();

            while ($product = $products->getNext()) {

                // устанавливаем родительские категории
                try {
                    Shop::Get()->getShopService()->buildProductCategories($product);
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }

                $index ++;
                if ($index % $transactions == 0) {
                    SQLObject::TransactionCommit();
                    SQLObject::TransactionStart();
                }
            }

            SQLObject::TransactionCommit();
        }
    }

}