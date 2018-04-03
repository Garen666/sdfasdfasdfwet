<?php
class statistics_online extends Engine_Class {

    public function process() {

        if ($kickID = $this->getArgumentSecure('kick')) {
            try {
                Shop::Get()->getUserService()->kickUser($kickID);
                $this->setValue('message', 'kick');
            } catch (Exception $e) {

            }
        }

        if ($banID = $this->getArgumentSecure('ban')) {
            try {
                Shop::Get()->getUserService()->banUser($banID);
                $this->setValue('message', 'ban');
            } catch (Exception $e) {

            }
        }

        $users = Shop::Get()->getUserService()->getUsersOnline();
        $u = array();
        while ($x = $users->getNext()) {
            $a['login'] = $x->getLogin();
            $a['email'] = $x->getEmail();
            $a['url'] = $x->makeURLEdit();
            $a['id'] = $x->getId();
            $a['ip'] = $x->getIp();
            $a['sid'] = $x->getSid();
            $a['sdate'] = $x->getSdate();
            $a['adate'] = $x->getAdate();
            $u[] = $a;
        }
        $this->setValue('usersArray', $u);
    }

}