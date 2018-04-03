<?php
class user_add extends Engine_Class {

    public function process() {
        $result = false;
        $status = false;
        $errorsArray = array();

        try {
            $user = Shop::Get()->getUserService()->addUserClient(
            $this->getArgumentSecure('name'),
            false,
            false,
            $this->getArgumentSecure('email'),
            $this->getArgumentSecure('phone'),
            $this->getArgumentSecure('address'),
            $this->getArgumentSecure('company'),
            false,
            false,
            false,
            $this->getArgumentSecure('namelast'),
            $this->getArgumentSecure('namemiddle'),
            $this->getArgumentSecure('post'),
            $typeSex = $this->getArgumentSecure('typesex')
            );

            $whatsapp = $this->getArgumentSecure('whatsapp');
            $skype = $this->getArgumentSecure('skype');

            if($whatsapp){
                $user->setWhatsapp($whatsapp);
            }
            if($skype){
                $user->setSkype($skype);
            }
            $user->setDistribution(1);
            $user->update();

            $result = array(
            'id' => $user->getId(),
            'name' => htmlspecialchars($user->getName()),
            'namelast' => htmlspecialchars($user->getNamelast()),
            'namemiddle' => htmlspecialchars($user->getNamemiddle()),
            'company' => htmlspecialchars($user->getCompany()),
            'email' => htmlspecialchars($user->getEmail()),
            'phone' => htmlspecialchars($user->getPhone()),
            'skype' => htmlspecialchars($user->getSkype()),
            'whatsapp' => htmlspecialchars($user->getWhatsapp()),
            );
            $status = 'success';
        } catch (Exception $e) {
            $status = 'error';
            $errorsArray = array();
        }

        $json = array(
        'status' => $status,
        'result' => $result,
        'errors' => $errorsArray
        );

        echo json_encode($json);
        exit();
    }

}