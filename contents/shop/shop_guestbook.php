<?php
class shop_guestbook extends Engine_Class {

    public function process() {
        Engine::GetHTMLHead()->setTitle(Shop::Get()->getTranslateService()->getTranslate('translate_shop_opinions'));

        $this->setValue('isUserAuthorized', $this->isUserAuthorized());

        // добавление отзыва

        //если нажатая кнопка
        if ($this->getArgumentSecure('guestbook')) {
            try {
                //получить тзыв
                $response = $this->getArgument('response');
                //проверка на авторизацию пользователя
                if ($this->isUserAuthorized()) {
                    //получить зарегистрированного пользователя
                    $user = $this->getUser();
                    // можно ли оставлять отзывы незарегистрированным пользователям
                } else {
                    throw new Exception('error');
                }
                //метод добавления отзыва оторому передаются два параметра: отзыв и юзер
                Shop::Get()->getGuestBookService()->addGuestBook(
                    $response,
                    $user
                );
                $this->setValue('message', 'ok');
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', $e->getMessage());
            }
        }

        // вывод всех отзывов
        $guestbook = Shop::Get()->getGuestBookService()->getGuestBookAll();
        $guestbook->setOrder('cdate', 'DESC');
        $guestbook->addWhere('done', 0, '>');
        $guestbook->addWhere('text', '', '!=');
        $a = array();
        while ($g = $guestbook->getNext()) {
            $name = $g->getName();
            $login = "";
            if (!$name) {
                try{
                    $name = htmlspecialchars(Shop::Get()->getUserService()->getUserByID($g->getUserid())->getName());
                    $login = htmlspecialchars(Shop::Get()->getUserService()->getUserByID($g->getUserid())->getLogin());
                } catch (Exception $e) {

                }
            }
                $a[] = array(
                'response' => nl2br(htmlspecialchars($g->getText())),
                'name' => $name,
                'login' => $login,
                'cdate' => $g->getCdate()
                );

        }
        $this->setValue('guestBookArray', $a);
    }

}