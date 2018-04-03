<?php
class users_ajax_autocomplete_select2 extends Engine_Class {

    /**
     * Этот код написал Максим М ради извращений с profidm
     *
     * @deprecated
     *
     */
    public function process() {
        try {
            $searchTerm = $this->getArgument('name');
            $onlyCompany = $this->getArgumentSecure('onlyCompany');
            $onlyPerson = $this->getArgumentSecure('onlyPerson');

            $a = array();
            if ($searchTerm) {
                $users = Shop::Get()->getUserService()->searchUsers($searchTerm);
            } else {
                $users = Shop::Get()->getUserService()->getUsersAll();
            }

            if ($onlyCompany) {
                $users->addWhere('typesex', 'company', '=');
            } elseif ($onlyPerson) {
                $users->addWhere('typesex', 'company', '!=');
            }

            $users->setLimitCount(10);

            while ($x = $users->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(false),
                    'emailArray' => $x->getEmailArray(),
                    'email' => $x->getEmail(),
                    'phone' => $x->getPhone(),
                    'skype' => $x->getSkype(),
                    'whatsapp' => $x->getWhatsapp(),
                );
            }

            $a[] = array(
                'id' => 0,
                'name' => 'Добавить '.$searchTerm
            );


            echo json_encode($a);
            exit;
        } catch (Exception $e) {
            throw $e;
        }

    }

}