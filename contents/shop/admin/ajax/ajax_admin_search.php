<?php
class ajax_admin_search extends Engine_Class {

    public function process() {
        try {
            $box = Engine::Get()->getConfigFieldSecure('project-box');

            $query = $this->getArgumentSecure('name');
            if (strlen($query)<3) {
                echo json_encode('badLen');
            }

            $a = array();

            // поиск сотрудников
            if ($box) {
                $users = Shop::Get()->getUserService()->searchUsers($query, $this->getUser(), true);
                $users->setLimitCount(10);
                $users->addWhereQuery('(level >=2 OR employer=1)');
                while ($x = $users->getNext()) {
                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(false),
                    'url' => $x->makeURLEdit(),
                    'group' => 'employee',
                    'category' => 'Сотрудники'
                    );
                }
            }

            // поиск контактов
            $users = Shop::Get()->getUserService()->searchUsers($query, $this->getUser(), true);
            $users->setLimitCount(10);
            if ($box) {
                $users->addWhere('level', 2, '<');
                $users->setEmployer(0);
            }
            while ($x = $users->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(false),
                'url' => $x->makeURLEdit(),
                'group' =>'users',
                'category' => 'Контакты'
                );
            }

            /*if ($box) {
            // поиск проектов
            $projects = IssueService::Get()->searchProjects($query, $this->getUser());
            $projects->setLimitCount(10);
            while ($x = $projects->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(false),
            'url' => $x->makeURL(),
            'group' => 'project',
            'category' => 'Проекты'
            );
            }
            }*/

            // поиск заказов/проектов
            $orders = Shop::Get()->getShopService()->searchOrders($query, $this->getUser());
            $orders->setLimitCount(10);
            $orders->setDateclosed('0000-00-00 00-00');
            $orders->setParentid(0);
            while ($x = $orders->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(false),
                'url' => $x->makeURLEdit(),
                'group' => 'orders',
                'category' => $box ? 'Проекты' : 'Заказы',
                );

            }

            // поиск задач
            $orders = Shop::Get()->getShopService()->searchOrders($query, $this->getUser());
            $orders->setLimitCount(10);
            $orders->setDateclosed('0000-00-00 00-00');
            $orders->addWhere('parentid', 0, '<>');
            while ($x = $orders->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(false),
                'url' => $x->makeURLEdit(),
                'group' => 'orders',
                'category' => 'Задачи'
                );
            }

            // поиск документов
            if (Shop_ModuleLoader::Get()->isImported('document')) {
                try {
                    $documents = DocumentService::Get()->searchDocuments($query);
                    $documents->setLimitCount(10);
                    while ($x = $documents->getNext()) {
                        $a[] = array(
                        'id' => $x->getId(),
                        'name' => $x->makeName(),
                        'url' => $x->makeURLEdit(),
                        'group' => 'document',
                        'category' => 'Документы'
                        );
                    }
                } catch (Exception $documentEx) {

                }
            }

            // поиск писем
            if ($box) {
                try {
                    $events = EventService::Get()->searchEvents($query);
                    $events->setLimitCount(10);
                    while ($x = $events->getNext()) {
                        $a[] = array(
                        'id' => $x->getId(),
                        'name' => $x->makeName(),
                        'url' => $x->makeURL(),
                        'group' => 'event',
                        'category' => 'События'
                        );
                    }
                } catch (Exception $eventEx) {

                }
            }

            // поиск продуктов
            $products = Shop::Get()->getShopService()->searchProducts($query, false);
            $products->setLimitCount(10);
            while ($x = $products->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getId().' '.$x->makeName(false),
                'url' => $x->makeURLEdit(),
                'group' => 'products',
                'category' => 'Продукты'
                );
            }

            // поиск категорий
            $category = Shop::Get()->getShopService()->searchObgectByName($query, 'category', false);
            $category->setLimitCount(10);
            while ($x = $category->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(false),
                'url' => $x->makeEditURL(),
                'group' => 'category',
                'category' => 'Категории'
                );
            }

            $orders = Shop::Get()->getShopService()->searchOrders($query, $this->getUser());
            $orders->setLimitCount(10);
            $orders->addWhere('dateclosed', '0000-00-00 00-00', '<>');
            while ($x = $orders->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(false),
                'url' => $x->makeURLEdit(),
                'group' => 'orders',
                'category' => 'Закрытые задачи'
                );
            }

            // выдача результатов
            echo json_encode($a);
            exit;
        } catch (Exception $e) {
            throw $e;
        }

    }

}