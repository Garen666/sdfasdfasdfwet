<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Egor Gerasimchuk <milhous@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_GuestBookService extends ServiceUtils_AbstractService {

    /**
     * Получить все записи с гостевой книге
     *
     * @return ShopGuestBook
     * @throws ServiceUtils_Exception
     */
    public function getGuestBookAll() {
        try {
            return $this->getObjectsAll('ShopGuestBook');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object (ShopGuestBook) by id not found');
    }
    /**
     *
     * @param integer $id
     * @return ShopGuestBook
     * @throws ServiceUtils_Exception
     */
    public function getGuestBookByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopGuestBook');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object (ShopGuestBook) by id not found');
    }

    /**
     * Добавить отзыв
     *
     * @throws ServiceUtils_Exception
     */
    public function addGuestBook($response, $user) {
        try {
            SQLObject::TransactionStart();

            $guestbook = $this->getGuestBookAll();
            $response = trim($response);

            $cdate = date('Y-m-d H:i:s');

            if (!$response) {
                throw new ServiceUtils_Exception();
            }

            $guestbook->setText($response);
            $guestbook->setCdate($cdate);
            if ($user) {
                $guestbook->setUserId($user->getId());
                $guestbook->setName($user->getName());
            }
            $guestbook->setDone(0);
            $guestbook->insert();

            // sendmail
            $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-shop-guestbook-response');
            if ($tpl) {
                $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));
                $sender->addEmail(Shop::Get()->getSettingsService()->getSettingValue('email-guestbook'));

                if ($user) {
                    $sender->setEmailFrom($user->getEmail());
                    $sender->assign('name', $user->getLogin());
                }

                $sender->assign('response', $response);
                $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                $sender->send();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function updateGuestBook(ShopGuestBook $guestbook, $response, $userId, $level) {
        try {
            SQLObject::TransactionStart();

            $response = trim($response);
            $done = $level;

            $ex = new ServiceUtils_Exception();
            if (!$response) {
                $ex->addError('response');
            }

            if (!$done) {
                $ex->addError('done');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            if ($response !== $guestbook->getText()) {
                $guestbook->setText($response);
            }
            if ($done !== $guestbook->getLevel()) {
                $guestbook->setDone($done);
            }
            $guestbook->update();

            if ($done > 0) {
                // sendmail
                $user = Shop::Get()->getUserService()->getUserByID($userId);
                $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-shop-guestbook-answer');
                if ($tpl) {
                    $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                    $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));
                    $sender->addEmail($user->getEmail());
                    $sender->assign('name', $user->getLogin());
                    $sender->assign('response', $response);
                    $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                    $sender->send();
                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

}