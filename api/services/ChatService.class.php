<?php
class ChatService extends ServiceUtils_AbstractService {

    /**
     * @param int $id
     * @return XChat
     */
    public function getChatByID($id) {
        return $this->getObjectByID($id, 'XChat');
    }

    /**
     * @return XChat
     */
    public function getAllChat() {
        $chat = new XChat();
        return $chat;
    }

    /**
     * @return XChat
     */
    public function getChatByUserIdTo($userId) {
        $chat = $this->getAllChat();
        $chat->setToUserId($userId);
        return $chat;
    }

    /**
     * @return XChat
     */
    public function getChatByUserIdFrom($userId) {
        $chat = $this->getAllChat();
        $chat->setFromUserId($userId);
        return $chat;
    }

    /**
     * @return XChatList
     */
    public function getChatListByUserId($userId) {
        $chatList = new XChatList();
        $chatList->setToUserId($userId);
        return $chatList;
    }

}