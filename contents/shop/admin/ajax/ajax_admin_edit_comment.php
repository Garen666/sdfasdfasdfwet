<?php
class ajax_admin_edit_comment extends Engine_Class {

    public function process() {
        $id = $this->getArgumentSecure('id');
        $action =  $this->getArgumentSecure('action');
        $text = $this->getArgumentSecure('text');

        try{
            SQLObject::TransactionStart();

            $comment = new CommentsAPI_XComment($id);
            if ($action == 'delete') {
                $comment->setContent('Сообщение удалено');
            } else {
                $comment->setContent($text);
            }
            $comment->update();

            SQLObject::TransactionCommit();
            $resultArray['id'] = $comment->getId();
            $resultArray['status'] = 'success';
            $resultArray['text'] = $comment->getContent();
        } catch( Exception $e ) {
            SQLObject::TransactionRollback();
            $resultArray['status'] = 'error';
        }
        echo json_encode($resultArray);
        exit;
    }

}