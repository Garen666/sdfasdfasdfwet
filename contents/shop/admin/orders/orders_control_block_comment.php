<?php
class orders_control_block_comment extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('CommentsAPI');

        try {
            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
            $this->getArgument('id')
            );

            // текущий авторизированный пользователь
            $user = $this->getUser();
            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);

            // режим box?
            $isBox = Engine::Get()->getConfigFieldSecure('project-box');
            $this->setValue('box', $isBox);

            // когда нажата кнопка Сохранить
            if ($canEdit && $this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    // добавления комментария/файла
                    $comment = $this->getControlValue('postcomment');

                    $fileAttachedArray = array();
                    $fileArgumentArray = $this->getArgumentSecure('file');
                    if ($fileArgumentArray) {
                        foreach ($fileArgumentArray['tmp_name'] as $index => $path) {
                            if (!file_exists($path)) {
                                continue;
                            }

                            $name = trim($fileArgumentArray['name'][$index]);
                            $type = $fileArgumentArray['type'][$index];

                            $fileAttachedArray[] = array(
                            'name' => $name,
                            'type' => $type,
                            'tmp_name' => $path, // дубликат нужен
                            'path' => $path, // дубликат нужен
                            );
                        }
                    }

                    if ($this->getArgumentSecure('sendclientemail')) {
                        $comment .= "\n\n";
                        $comment .= "Комментарий отправлен клиенту на ".$order->getClient()->getEmail();
                        $comment .= "\n";
                    }

                    if ($this->getArgumentSecure('sendclientsms')
                    && $this->getControlValue('sendclientsmsphone')) {
                        $comment .= "\n\n";
                        $comment .= "Комментарий отправлен клиенту по SMS ".$this->getControlValue('sendclientsmsphone');
                        $comment .= "\n";
                    }

                    $comment = trim($comment);
                    if ($comment || $fileAttachedArray) {
                        try {
                            Shop::Get()->getShopService()->addOrderComment(
                            $order,
                            $this->getUser(),
                            $comment,
                            $fileAttachedArray
                            );

                            $this->setValue('message', 'commentok');
                        } catch (Exception $commentException) {
                            if (PackageLoader::Get()->getMode('debug')) {
                                print $commentException;
                            }

                            $this->setValue('message', 'commenterror');
                        }
                    }

                    if ($this->getArgumentSecure('sendclientemail')) {
                        $comment = $this->getControlValue('postcomment');
                        if ($comment || $fileAttachedArray) {
                            $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('box-parser-email');
                            if (!$emailFrom) {
                                $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
                            }

                            $subject = $this->getArgumentSecure('sendclientemailsubject');
                            $subject .= ' #'.$order->getId();
                            $subject = trim($subject);
                            Shop::Get()->getUserService()->sendEmail(
                            $emailFrom,
                            $order->getClient()->getEmail(),
                            $subject,
                            $comment,
                            $fileAttachedArray
                            );
                            Shop::Get()->getUserService()->sendEmail(
                            $emailFrom,
                            $order->getClient()->getEmail(),
                            $subject,
                            $comment,
                            false
                            );
                        }
                    }

                    // отправка SMS
                    if ($this->getArgumentSecure('sendclientsms')) {
                        Shop::Get()->getUserService()->sendSMS(
                        $this->getControlValue('sendclientsmsphone'),
                        $this->getControlValue('postcomment')
                        );
                    }

                    SQLObject::TransactionCommit();

                    if (Engine::GetURLParser()->getArgumentSecure('message') != 'error') {
                        Engine::GetURLParser()->setArgument('message', 'ok');
                    }

                } catch (ServiceUtils_Exception $te) {
                    SQLObject::TransactionRollback();

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $te;
                    }

                    Engine::GetURLParser()->setArgument('message', 'error');

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $te->getErrorsArray());
                }
            }

            // удаление файла
            // @todo: to transaction up?
            try {
                $file = new ShopFile(
                $this->getArgument('filedelete')
                );

                $file->setDeleted(1);
                $file->update();
            } catch (Exception $e) {

            }

            if ($isBox) {
                try {
                    $this->setValue('clientEmail', $order->getClient()->getEmail());
                    $this->setValue('clientSMSArray', $order->getClient()->getPhoneArrayForSMS());
                } catch (Exception $e) {

                }
            }

            // вывод комментариев
            $commentKey = 'shop-order-'.$order->getId();
            $comments = CommentsAPI::Get()->getComments($commentKey);
            $block = Engine::GetContentDriver()->getContent('comment-block');
            $block->setValue('comments', $comments);
            $this->setValue('block_comment', $block->render());

            if ($isBox) {
                $this->setValue('box', true);

                // файлы-вложения
                $files = new ShopFile();
                $files->setKey('order-'.$order->getId());
                $files->setDeleted(0);
                $a = array();
                while ($x = $files->getNext()) {
                    try {
                        $username = Shop::Get()->getUserService()->getUserByID($x->getUserid())->makeName(true, 'lfm');
                    } catch (Exception $e) {
                        $username = false;
                    }

                    $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'url' => $x->makeURL(),
                    'username' => $username,
                    'cdate' => $x->getCdate(),
                    'size' => $x->makeSize(),
                    'urlDelete' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('filedelete' => $x->getId())),
                    );
                }
                $this->setValue('fileArray', $a);

                $this->setValue('commentTemplateArray', Shop::Get()->getShopService()->getCommentTemplatesArray());
            }

            // исполнители
            $oes = Shop::Get()->getShopService()->getEmployersByOrder($order);
            $a = array();
            while ($x = $oes->getNext()) {
                try {
                    $user = $x->getUser();
                    if (!$user->getLevel()) {
                        continue;
                    }

                    $a[$user->getId()] = array(
                    'id' => $user->getId(),
                    'name' => $user->makeName(true, 'lfm'),
                    'url' => $user->makeURLEdit(),
                    );
                } catch (Exception $e) {

                }
            }
            try {
                $user = $order->getAuthor();
                if (!$user->getLevel()) {
                    throw new ServiceUtils_Exception();
                }

                $a[$user->getId()] = array(
                'id' => $user->getId(),
                'name' => $user->makeName(true, 'lfm'),
                'url' => $user->makeURLEdit(),
                );
            } catch (Exception $e) {

            }
            try {
                $user = $order->getManager();
                if (!$user->getLevel()) {
                    throw new ServiceUtils_Exception();
                }

                $a[$user->getId()] = array(
                'id' => $user->getId(),
                'name' => $user->makeName(true, 'lfm'),
                'url' => $user->makeURLEdit(),
                );
            } catch (Exception $e) {

            }
            $this->setValue('watcherArray', $a);

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }
}