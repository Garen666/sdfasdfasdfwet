<?php
class users_json_autocomplete_select2 extends Engine_Class {

    public function process() {
        try {
            $pageNum = $this->getArgument('pageNum');
            $pageSize = $this->getArgument('pageSize');
            $callback = $this->getArgument('callback');
            $arrUserId = $this->getArgument('arrUserId');
            $searchTerm = $this->getArgument('searchTerm');

            $a = array();
            if ($searchTerm) {
                $users = Shop::Get()->getUserService()->searchUsers($searchTerm, $this->getUser());
                $count = $users->getCount();
            } else {
                $users = Shop::Get()->getUserService()->getUsersAll($this->getUser());
                $count = 1000000;
            }

            $users->setLimit(($pageNum-1)*$pageSize, $pageSize);

            $companyArray = array();
            $usersIdArray = explode(';', $arrUserId);

            while ($x = $users->getNext()) {
                if (in_array($x->getId(), $usersIdArray)) {
                    continue;
                }
                $a[] = array(
                'id' => $x->getId(),
                'text' => htmlspecialchars($x->makeName())
                );

                if ($x->getCompany()) {
                    $companyArray[$x->getCompany()] = $x->getCompany();
                }
            }

            echo $callback . '(' . json_encode(array(
            'Results' => $a,
            'Total' => $count
            )) .')';

        } catch (Exception $e) {

        }

        exit();
    }

}