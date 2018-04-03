<?php
class search_issue_ajax_select2 extends Engine_Class {

    /**
     * @deprecated
     * @todo переделать по нормальному, а то куча API...
     */
    public function process() {
        try {
            $query = $this->getArgumentSecure('name');
            if (strlen($query)<3) {
                echo json_encode('badLen');
            }

            $a = array();

            // поиск проектов
            $projects = Shop::Get()->getShopService()->searchOrders($query, $this->getUser());
            $projects->setParentid(0);
            $projects->setDateclosed('0000-00-00 00:00:00');
            $projects->setLimitCount(10);
            while ($x = $projects->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(false),
                'manager' => $x->getManagerOrAuthor()->getId(),
                'category' => 'Проекты'
                );
            }

            // поиск задач
            $issue = Shop::Get()->getShopService()->searchOrders($query, $this->getUser());
            $issue->addWhere('parentid', 0, '!=');
            $issue->setDateclosed('0000-00-00 00-00');
            $issue->setLimitCount(10);
            while ($x = $issue->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(false),
                    'manager' => $x->getManagerOrAuthor()->getId(),
                    'category' => 'Задачи',
                );

            }

            // Закрытые проекты
            $orders = Shop::Get()->getShopService()->searchOrders($query, $this->getUser());
            $orders->setParentid(0);
            $orders->addWhere('dateclosed', '0000-00-00 00-00', '<>');
            $orders->setLimitCount(10);
            while ($x = $orders->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(false),
                    'manager' => $x->getManagerOrAuthor()->getId(),
                    'category' => 'Закрытые проекты'
                );

            }

            // закрыты задачи
            $orders = Shop::Get()->getShopService()->searchOrders($query, $this->getUser());
            $orders->addWhere('parentid', 0, '!=');
            $orders->addWhere('dateclosed', '0000-00-00 00-00', '<>');
            $orders->setLimitCount(10);

            while ($x = $orders->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(false),
                    'manager' => $x->getManagerOrAuthor()->getId(),
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