<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Golub Oleksii <avator@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_FeedbackService extends ServiceUtils_AbstractService {

    /**
     * Получить всех сообщений из обратной связи
     *
     * @return XShopFeedback
     */
    public function getFeedbackAll() {
        try {
            return $this->getObjectsAll('XShopFeedback');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object(XShopFeedback) by id not found');
    }

    /**
     * @return XShopFeedback
     */
    public function getFeedbackByID($id) {
        try {
            return $this->getObjectByID($id, 'XShopFeedback');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object(XShopFeedback) by id not found');
    }

    /**
     *  add Feedback
     *
     * @param string $name
     * @param string $phone
     * @param string $email
     * @param string $message
     * @param User $user
     */
    public function addFeedback($name, $phone, $email, $message, $user = false, $url = false) {
        try {
            SQLObject::TransactionStart();

            $f = $this->getFeedbackAll();

            $name = trim($name);
            $email = trim($email);
            $message = nl2br(trim($message));
            $cdate = date('Y-m-d H:i:s');

            $ex = new ServiceUtils_Exception();

            // @todo
            if (!$name || $name == 'Имя') {
                $ex->addError('name');
            }

            if (!$message) {
                $ex->addError('message');
            }


            if (!Checker::CheckEmail($email)) {
                $ex->addError('email');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $f->setName($name);
            $f->setCdate($cdate);
            $f->setEmail($email);
            $f->setMessage($message);
            $f->setPageurl($url);
            if ($user) {
                $f->setUserid($user->getId());
            }
            $f->insert();

            // sendmail
            $tpl = MEDIA_PATH.'/mail-templates/add-feedback.html';
            if ($tpl) {
                $sender = new MailUtils_SmartySender($tpl);

                $sender->addEmail(Shop::Get()->getSettingsService()->getSettingValue('feed-back-email'));
                $sender->setEmailFrom($email);

                $sender->assign('name', $name);
                $sender->assign('email', $email);
                $sender->assign('message', $message);
                $sender->assign('url', $url);
                if ($user) {
                    $sender->assign('userUrl', Engine::Get()->getProjectURL().$user->makeURLEdit());
                }
                $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                $sender->send();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

}