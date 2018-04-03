<?php
class user_contact_preview extends Engine_Class {

    public function process() {
        try {
            $contact = Shop::Get()->getUserService()->getUserByID(
            $this->getArgument('id')
            );

            $name = $contact->makeName(true, 'lfm');
            $this->setValue('name', $name);
            $this->setValue('company', $contact->getCompany(), true);
            $this->setValue('title', $contact->getPost(), true);
            $this->setValue('url', $contact->makeURLEdit());

            $this->setValue('emailArray', $contact->getEmailArray());
            $this->setValue('phoneArray', $contact->getPhoneArray());
            $this->setValue('address', $contact->getAddress());
            $turboSmsLogin =  Shop::Get()->getSettingsService()->getSettingValue('turbosms-login');
            $turboSmsPass = Shop::Get()->getSettingsService()->getSettingValue('turbosms-password');
            $turboSmsSender = Shop::Get()->getSettingsService()->getSettingValue('turbosms-sender');
            if ($turboSmsLogin && $turboSmsPass && $turboSmsSender) {
                $this->setValue('canSMS', true);
            }

            try {
                $companyObject = Shop::Get()->getShopService()->getCompanyByName($contact->getCompany());
                $this->setValue('logo', $companyObject->makeImageThumb(50, 50));
                $this->setValue('companyURL', $companyObject->makeURLEdit());
            } catch (Exception $e) {

            }

            if ($contact->getImage()) {
                $this->setValue('logo', $contact->makeImageThumb(50, 50));
            }

            // дата последней коммуникации с клиентом
            if ($contact->getActivitydate() && $contact->getActivitydate() != '0000-00-00 00:00:00') {
                $this->setValue('clientactivitydate', $contact->getActivitydate());
            }

            // cписок бизнес-процессов
            $category = Shop::Get()->getShopService()->getWorkflowsActive($this->getUserSecure());
            $category->setHidden(0);
            $a = array();
            while ($x = $category->getNext()) {
                $p = array();
                $p['workflowid'] = $x->getId();
                $p['clientid'] = $contact->getId();
                $p['clientname'] = $contact->makeName();

                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'url' => Engine::GetLinkMaker()->makeURLByContentIDParams('issue-add', $p),
                );
            }
            $this->setValue('workflowArray', $a);

            /*$currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('balance', $contact->makeBalance($currency));
            $this->setValue('currency', $currency->getSymbol());*/

        } catch (Exception $e) {
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}