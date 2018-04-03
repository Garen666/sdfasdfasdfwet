<?php
class role_control extends Engine_Class {

    public function process() {
        try {
            $form = new Forms_ContentForm(new Datasource_Role());
            $key = $this->getArgumentSecure('key');
            $this->setValue('form', $form->render($key));
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}