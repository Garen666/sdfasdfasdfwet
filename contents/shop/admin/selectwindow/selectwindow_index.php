<?php
class selectwindow_index extends Engine_Class {

    public function process() {
        $this->setValue('windowID', $this->getArgument('windowID'));
        $this->setValue('option_productsearch', $this->getArgumentSecure('productsearch') == 'true');
        $this->setValue('option_productadd', $this->getArgumentSecure('productadd') == 'true');
        $this->setValue('option_boxsearch', $this->getArgumentSecure('boxsearch') == 'true');
        $this->setValue('option_boxadd', $this->getArgumentSecure('boxadd') == 'true');
        $this->setValue('option_usersearch', $this->getArgumentSecure('usersearch') == 'true');
        $this->setValue('option_useradd', $this->getArgumentSecure('useradd') == 'true');
        $this->setValue('option_productAddDefault', $this->getArgumentSecure('productAddDefault'));
        $this->setValue('option_userAddDefault', htmlspecialchars($this->getArgumentSecure('userAddDefault')));

        $this->setValue('box', Engine::Get()->getConfigFieldSecure('project-box'));
        // для создания товаров нам нужно дерево категорий
        if ($this->getValue('option_productadd')) {
            $this->setValue('categoryArray', $this->_makeCategoryArray());

            // список валют
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $this->setValue('currencyArray', $currency->toArray());

            // список брендов
            $brands = Shop::Get()->getShopService()->getBrandsAll();
            $this->setValue('brandsArray', $brands->toArray());


        }
    }

    /**
     * @return array
     */
    private function _makeCategoryArray() {
        // строим массив всех категорий
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $a = array();
        while ($x = $category->getNext()) {
            $a[$x->getParentid()][] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
            'parentid' => $x->getParentid(),
            );
        }

        return $this->_makeCategoryTree(0, 0, $a);
    }

    private function _makeCategoryTree($parentID, $level, $categoryArray) {
        $a = array();
        if (empty($categoryArray[$parentID])) {
            return $a;
        }
        foreach ($categoryArray[$parentID] as $x) {
            $x['level'] = $level;
            $a[] = $x;
            $childs = $this->_makeCategoryTree($x['id'], $level + 1, $categoryArray);
            foreach ($childs as $y) {
                $a[] = $y;
            }
        }
        return $a;
    }

}