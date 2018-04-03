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
class Shop_FaqService extends ServiceUtils_AbstractService {

    /**
     * Получить все вопросы и ответы
     *
     * @return XShopFaq
     */
    public function getFaqAll() {
        try {
            return $this->getObjectsAll('XShopFaq');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object(XShopFaq) by id not found');
    }

    /**
     * @return XShopFaq
     */
    public function getFaqByID($id) {
        try {
            return $this->getObjectByID($id, 'XShopFaq');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object(XShopFaq) by id not found');
    }

    /**
     * Добавить свой вопрос
     *
     * @param string $question
     * @param int $userID
     */
    public function addFaq($question, $userID = false) {
        try {
            SQLObject::TransactionStart();

            $faq = $this->getFaqAll();

            $question = nl2br(trim($question));
            $cdate = date('Y-m-d H:i:s');

            if (!$question) {
                throw new ServiceUtils_Exception();
            }

            $faq->setQuestion($question);
            $faq->setCdate($cdate);
            if ($userID) {
                $faq->setUserId($userID);
            }
            $faq->insert();

            // sendmail
            $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-shop-faq-question');
            if ($tpl) {
                $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);

                $sender->addEmail(Shop::Get()->getSettingsService()->getSettingValue('faq-email'));
                $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));

                try {
                    $user = Shop::Get()->getUserService()->getUserByID($userID);
                    $sender->setEmailFrom($user->getEmail());
                    $sender->assign('name', $user->getLogin());
                } catch (Exception $userEx) {

                }

                $sender->assign('question', $question);
                $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                $sender->send();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить вопрос-ответ
     *
     * @param XShopFaq $faq
     * @param string $question
     * @param string $answer
     * @param string $userID
     */
    public function updateFaq(XShopFaq $faq, $question, $answer, $userID) {
        try {
            SQLObject::TransactionStart();

            $question = trim($question);
            $answer = trim($answer);

            $ex = new ServiceUtils_Exception();
            if (!$question) {
                $ex->addError('question');
            }

            if (!$answer) {
                $ex->addError('answer');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            if ($question !== $faq->getQuestion()) {
                $faq->setQuestion($question);
            }
            if ($answer !== $faq->getAnswer()) {
                $faq->setAnswer($answer);
            }
            $faq->update();

            // sendmail
            if ($answer) {
                $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-shop-faq-answer');
                if ($tpl) {
                    $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                    $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));
                    $sender->addEmail($user->getEmail());
                    $sender->assign('name', $user->getLogin());
                    $sender->assign('question', $question);
                    $sender->assign('answer', $answer);
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