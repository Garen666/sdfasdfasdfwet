<?php
class dashboard_index extends Engine_Class {

    public function process() {
        // если box отключен - то редирект на заказы
        $box = Engine::Get()->getConfigFieldSecure('project-box');
        if (!$box) {
            header('Location: /admin/shop/orders/');
            exit();
        }

        $groupBy = $this->getArgumentSecure('groupby');
        if (!$groupBy) {
            $groupBy = 'hour';
        }

        if ($this->getArgumentSecure('ok')) {
            $datefrom = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateFrom'));
            $dateto = DateTime_Corrector::CorrectDate($this->getControlValue('dateTo')).' 23:59:59';
        } else {
            $dateto = DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now());
            $datefrom = DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now()->addMonth(-6)->setFormat('Y-m-01'));

            $this->setControlValue('dateFrom', $datefrom);
            $this->setControlValue('dateTo', $dateto);
        }

        $cuser = $this->getUser();

        // Календарь
        $issues = IssueService::Get()->getIssuesAll($cuser);
        $list = Engine::GetContentDriver()->getContent('issue-list');
        try {
            $this->getArgument('filtershowclosed');
        } catch (Exception $e) {
            Engine::GetURLParser()->setArgument('filtershowclosed', true);
        }
        try {
            $this->getArgument('mode');
        } catch (Exception $e) {
            Engine::GetURLParser()->setArgument('mode', 'calendar');
        }
        try {
            $this->getArgument('filtermanagerid');
        } catch (Exception $e) {
            Engine::GetURLParser()->setArgument('filtermanagerid', $cuser->getId());
        }
        $list->setValue('issues', $issues);
        $this->setValue('block_issue', $list->render());

        // cписок менеджеров
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        $a = array();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            );
        }
        $this->setValue('managerArray', $a);
    }

}