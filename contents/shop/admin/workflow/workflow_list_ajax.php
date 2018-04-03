<?php
class workflow_list_ajax extends Engine_Class {

    public function process() {

        $tab = $this->getArgumentSecure('tab');

        $workflows = Shop::Get()->getShopService()->getWorkflowsAll($this->getUser());

        if (!$tab || $tab=='project') {
            $workflows->filterSmart(0);
        } elseif ($tab=='issue') {
            $workflows->filterSmart(1);
        } elseif ($tab == 'order') {
            $workflows->filterIssue(0);
        }

        $a = array();

        while ($x= $workflows->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
            );
        }

        echo json_encode($a);
        exit;
    }

}