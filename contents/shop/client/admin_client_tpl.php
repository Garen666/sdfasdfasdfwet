<?php
class admin_client_tpl extends Engine_Class {

    public function process() {
        $admin = false;
        try {
            $admin = $this->getUser()->isAdmin();
        } catch (Exception $e) {

        }
        $this->setValue('admin', $admin);

        $this->setValue('page', Engine::Get()->getRequest()->getContentID());

    }

}