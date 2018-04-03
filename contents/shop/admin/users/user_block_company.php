<?php
class user_block_company extends Engine_Class {

    /**
     * @return User
     */
    private function _getCompany() {
        return $this->getValue('company');
    }

    public function process() {
        $user = $this->_getCompany();
        $usercompany =  htmlspecialchars($user->getCompany(), ENT_QUOTES);
        $this->setValue('company', $usercompany);
        $companyName = $user->getCompany();

        // другие карточки этой компании
        $tmp = Shop::Get()->getUserService()->getUsersAll();
        $tmp->addWhere('id', $user->getId(), '<>');
        $tmp->addWhere('typesex', 'company', '<>');
        $tmp->setCompany($companyName);
        //$tmp->addWhere('level', 0, '>');
        $a = array();
        while ($x = $tmp->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            'image' => $x->makeImageThumb(),
            'url' => $x->makeURLEdit(),
            'nameshort' => $x->getName(),
            'namelast' => $x->getNamelast(),
            'namemiddle' => $x->getNamemiddle(),
            'post' => $x->getPost(),
            'phone' => $x->getPhone(),
            'email' => $x->getEmail(),
            //'blocked' => ($x->getLevel() <= 0 && $x->getLogin()),
            );
        }

        $this->setValue('companyArray', $a);
    }

}