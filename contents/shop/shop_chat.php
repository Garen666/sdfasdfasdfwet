<?php
class shop_chat extends Engine_Class {

    public function process() {

        try {
            $user = $this->getUser();

            $to = $this->getArgumentSecure("to");

            $chatList = Shop::Get()->getChatService()->getChatListByUserId($user->getId());
            $chatList->setLimitCount(100);

            $chatListArray = array();
            while ($x = $chatList->getNext()) {
                $chatListArray[] = array(
                    "id" => $x->getFromUserId(),
                    "name" => $x->getFromUserName(),
                    "selected" => $x->getFromUserId() == $to ? true : false
                );
            }

            $this->setValue("chatListArray", $chatListArray);


            if (!$to) {
                $to = $chatListArray[count($chatListArray)]["id"];
                $chatListArray[count($chatListArray)]["selected"] = true;
            }

            if ($to) {
                $chat = Shop::Get()->getChatService()->
            }
        } catch (Exception $e) {

        }

    }

}