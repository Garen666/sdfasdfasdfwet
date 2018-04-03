<?php
class shop_category extends Engine_Class {

    public function process() {
        try {
            $category = Shop::Get()->getShopService()->getCategoryByID(
            $this->getArgument('id')
            );

            // проверяем, скрыта ли категория
            if ($category->isHidden()) {
                try {
                    if (!$this->getUser()->isAdmin()) {
                        throw new ServiceUtils_Exception();
                    }
                } catch (Exception $e) {
                    Engine::Get()->getRequest()->setContentNotFound();
                    return;
                }
            }

            if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $h = 'https://';
            } else {
                $h = 'http://';
            }

            // проверяем, есть ли у URL
            $url = Engine::GetURLParser()->getTotalURL();
            if ($category->getUrl() && preg_match("/^\/category\/(\d+)\/$/ius", $url)) {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: '.$category->makeURL());
                exit();
            }

            // отправляем в шаблон указание, какая категория выбрана
            Engine::GetContentDriver()->getContent('block-menu-category')->setValue('categorySelected', $category->getId());

            // ------------------------------------------------- //

            // устанавливаем meta-ключевые слова и описание
            Engine::GetHTMLHead()->setMetaKeywords(htmlspecialchars($category->getSeokeywords()));

            $metaDescription = $category->getSeodescription();

            if (!$metaDescription) {
                $metaDescription = Shop::Get()->getSettingsService()->getSettingValue('seo-meta-description-category');
            }
            if (!$metaDescription) {
                $metaDescription = $category->getDescription();
                $metaDescription = strip_tags($metaDescription);
                $metaDescription = StringUtils_Object::Create($metaDescription)->limit(200)->__toString();
            }

            $metaDescription = $this->_processKeywords($metaDescription, $category);

            Engine::GetHTMLHead()->setMetaDescription(htmlspecialchars($metaDescription));

            // устанавливаем title
            $title = $category->getSeotitle();

            if (!$title) {
                $title = Shop::Get()->getSettingsService()->getSettingValue('seo-title-category');
            }

            $title = $this->_processKeywords($title, $category);

            $page = $this->getArgumentSecure('p');
            if ($page) {
                $title .= ' (страница '.($page + 1).')';
            }

            Engine::GetHTMLHead()->setTitle(
            htmlspecialchars($title)
            );

            // ------------------------------------------------- //

            // open graph tags
            $image = $category->makeImageThumb(100);
            if ($image) {
                Engine::GetHTMLHead()->setMetaTag('og:image', Engine::Get()->getProjectURL().$image);
            }
            Engine::GetHTMLHead()->setMetaTag('og:title', $category->getName());
            Engine::GetHTMLHead()->setMetaTag('og:description', htmlspecialchars(strip_tags($category->getDescription())));

            // ------------------------------------------------- //

            // подкатегории
            $childs = Shop::Get()->getShopService()->getCategoriesByParentID($category->getId());
            $a = array();
            while ($x = $childs->getNext()) {
                $a[] = $x->makeInfoArray();
            }
            $this->setValue('categoryArray', $a);

            $this->setValue('categoryName', $category->getName());

            // показываем описание категории только на первой странице
            // и если нет фильтров
            if ($page < 1 && !$this->_checkFilters()) {
                $this->setValue('image', $category->makeImageThumb());
                $this->setValue('description', $category->getDescription());

                // SEO-контекнт передаем в shop-tpl
                $tpl = Engine::GetContentDriver()->getContent('shop-tpl');
                $tpl->setValue('seocontent', $category->getSeocontent());
            }

            $products = $category->getProducts();

            // подкатегории
            $subcategories = Shop::Get()->getShopService()->getCategoriesByParentID($category->getId());
            $subcategories->setHidden(0);

            // ------------------------------------------------- //

            // seoh1
            try {
                $seo = Shop::Get()->getSEOService()->getSEOByURL(
                Engine::GetURLParser()->getTotalURL()
                );
                if ($seo->getSeoh1()) {

                    $this->setValue('seoh1',$seo->getSeoh1());

                }
            } catch (Exception $seoEx) {

            }

            $render = Engine::GetContentDriver()->getContent('shop-product-list');
            $render->setValue('items', $products);
            $render->setValue('categoryName', $category->getSeotitle() ? $category->getSeotitle() : $category->getName());
            $render->setValue('showtype', $category->getShowtype());
            $render->setValue('filtervalue', true);
            $render->setValue('category', $subcategories->getCount());
            $render->setValue('categoryid', $category->getId());
            $render->setValue('subcategories', $subcategories);
            $render->setValue('pathArray', $this->_makePathArray($category));
            $render->setValue('currentURL', $category->makeURL());
            $this->setValue('items', $render->render());

            // список тегов
            try {
                $productForTag = $render->getValue('productsWithFilter');
                if (!$productForTag) {
                    $productForTag = $products;
                }

                $tags = new XShopProduct2Tag();
                $tags->addWhereQuery("productid IN (SELECT id FROM {$productForTag->getTablename()} WHERE {$productForTag->makeWhereString()})");
                $tags->setGroupByQuery('tagid');
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
            } catch (Exception $tagEx) {

            }
        } catch (Exception $ge) {
            if (method_exists($ge, 'log')) {
                $ge->log();
            }

            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    /**
     * Построить путь категории
     *
     * @param ShopCategory $category
     * @return array
     */
    private function _makePathArray(ShopCategory $category) {
        $category = clone $category;
        $a = array();
        try {
            $a[] = $category->makeInfoArray();;
            while ($category = $category->getParent()) {
                $a[] = $category->makeInfoArray();
            }
        } catch (Exception $e) {

        }
        return array_reverse($a);
    }

    /**
     * Проверить, есть ли по указанному URL какие-либо SEO-примочки
     *
     * @param string $url
     * @return bool
     */
    private function _checkFilters() {
        $argumentsArray = $this->getArguments();
        foreach ($argumentsArray as $key => $value) {
            if (preg_match("/^filter(\d+)value$/ius", $key, $r)) {
                return true;
            }
        }
        return false;
    }

    private function _processKeywords($s, ShopCategory $category) {
        $s = str_replace('[name]', $category->getName(), $s);
        $s = str_replace('[categorypath]', $category->makePathName(', '), $s);

        return $s;
    }

}