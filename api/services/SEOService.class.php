<?php

/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Package
 */
class SEOService {

    /**
     * @return XShopSEO
     */
    public function getSEOAll() {
        $x = new XShopSEO();
        $x->setOrder('url', 'ASC');
        return $x;
    }

    /**
     * @return XShopSEO
     * @param string $url
     */
    public function getSEOByURL($url) {
        if (!$url) {
            throw new ServiceUtils_Exception();
        }
        $x = new XShopSEO();
        $x->setUrl($url);
        if ($x->select()) {
            return $x;
        } else {
            //порверка какой протокол
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

            $url = $protocol.Engine::Get()->getConfigField('project-host').Engine::GetURLParser()->getTotalURL();
            $x = new XShopSEO();
            $x->setUrl($url);
            if ($x->select()) {
                return $x;
            }
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Построить sitemap для всего проекта
     */
    public function generateSitemap($path = false) {
        PackageLoader::Get()->import('Sitemap');

        // количество товаров на странице категорий/брендов
        $onpage = Shop::Get()->getSettingsService()->getSettingValue('shop-onpage');
        if (!$onpage) {
            $onpage = 50;
        }



        $lastWeek = DateTime_Object::Now()->addDay(-7)->__toString();
        $lastMonth = DateTime_Object::Now()->addMonth(-1)->__toString();
        $lastYear = DateTime_Object::Now()->addYear(-1)->__toString();

        // Соединение с БД
        $connection = ConnectionManager::Get()->getConnectionDatabase();

        // создаем генератор sitemaps'a
        $sitemap = new Sitemap(Engine::Get()->getProjectHost());

        // все товары
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setHidden(0);
        $products->setDeleted(0);
        while ($x = $products->getNext()) {
            try {
                if ($x->getCategory()->isHidden()) {
                    continue;
                }
            } catch (Exception $categoryEx) {

            }

            $priority = 1;
            if (!$x->getAvail()) {
                $priority = 0.5;
            }

            $freq = 'daily';
            if ($x->getUdate() < $lastWeek) {
                $freq = 'weekly';
            }
            if ($x->getUdate() < $lastMonth) {
                $freq = 'monthly';
            }
            if ($x->getUdate() < $lastYear) {
                $freq = 'yearly';
            }

            $sitemap->addURL($x->makeURL(), $priority, $freq, $x->getUdate(), $x->makeBigImagesArray(true));
        }

        // все категории
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->setHidden(0);
        while ($x = $category->getNext()) {
            if ($x->isHidden()) {
                continue;
            }

            // все страницы категорий
            $count = $x->getProducts()->getCount();
            for ($j = 0; $j <= $count / $onpage; $j++) {
                $sitemap->addURL($x->makeURL(true, $j), 1, 'daily');
            }
        }

        // все текстовые страницы
        $pages = Shop::Get()->getTextPageService()->getTextPageAll();
        $pages->setHidden(0);
        while ($x = $pages->getNext()) {
            $sitemap->addURL($x->makeURL(), 0.3, 'monthly');
        }

        // все теги товаров
        $tags = new ShopProductTag();
        while ($x = $tags->getNext()) {
            // публикуем URL в sitemap
            $url = $x->makeURL();
            $sitemap->addURL($url, 1, 'daily');
        }

        if (!$path) {
            $path = PackageLoader::Get()->getProjectPath().'/media/sitemap/'.Engine::Get()->getProjectHost().'/';
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        }
        $sitemap->render($path);
    }

    /**
     * Построить URL всем товарам, категориям, страницам, у которых еще нет
     * URL.
     */
    public function buildFriendlyURLs() {
        // строим ЧПУ для всех категорий
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->setUrl('');
        while ($x = $category->getNext()) {
            try {
                $url = Shop::Get()->getShopService()->buildURL($x->getName());
                if (!Shop::Get()->getShopService()->checkURLUnique($url)) {
                    $url .= '-'.$x->getId();
                }

                $x->setUrl($url);
                $x->update();
            } catch (Exception $e) {

            }
        }

        // строим ЧПУ для всех товаров
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setUrl('');
        while ($x = $products->getNext()) {
            try {
                $url = Shop::Get()->getShopService()->buildURL($x->getName());
                if (!Shop::Get()->getShopService()->checkURLUnique($url)) {
                    $url .= '-'.$x->getId();
                }

                $x->setUrl($url);
                $x->update();
            } catch (Exception $e) {

            }
        }

        // строим ЧПУ для всех текстовых страницы
        $pages = Shop::Get()->getTextPageService()->getTextPageAll();
        $pages->setUrl('');
        while ($x = $pages->getNext()) {
            try {
                $url = Shop::Get()->getShopService()->buildURL($x->getName());
                if (!Shop::Get()->getShopService()->checkURLUnique($url)) {
                    $url .= '-'.$x->getId();
                }

                $x->setUrl($url);
                $x->update();
            } catch (Exception $e) {

            }
        }
    }

}