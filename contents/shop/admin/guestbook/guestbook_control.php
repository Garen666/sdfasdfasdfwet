<?php
class guestbook_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_GuestBook());
            $id = $this->getArgumentSecure('id');
            if($id){
                $form->denyInsert();
            }
            $this->setValue('form', $form->render($id));

            if ($id) {
                Engine::GetHTMLHead()->setTitle('Отзыв о магазине #'.$id);
            } else {
                Engine::GetHTMLHead()->setTitle('Добавить отзыв о магазине ');
            }

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}