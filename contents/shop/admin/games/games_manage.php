<?php
class games_manage extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->registerJSFile('/_js/categorySortable.js');

        if ($this->getControlValue('delete')){
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                foreach ($r[1] as $categoryID) {
                    try {
                        SQLObject::TransactionStart();
                        $currentCategory = Shop::Get()->getGameService()->getGameByID($categoryID);
                        $currentCategory->delete();
                        $this->setValue('successDel', 1);
                        $this->setValue('successName', 'Удаление успешно выполнено!');
                        SQLObject::TransactionCommit();
                    } catch (Exceprion $e) {
                        SQLObject::TransactionRollback();
                    }
                }
                header('Refresh: 3;');
            }
        }


        if ($this->getControlValue('do-action')){
            try {

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $categoryID) {
                        try {
                            SQLObject::TransactionStart();
                            $currentCategory = Shop::Get()->getGameService()->getGameByID($categoryID);
                            $currentCategory->setHidden(0);
                            $currentCategory->update();
                            $this->setValue('success', 1);
                            $this->setValue('successName', 'Видимость изменена успешно!');
                            SQLObject::TransactionCommit();
                        } catch (Exceprion $e) {
                            SQLObject::TransactionRollback();
                        }
                    }
                }

            } catch (Exception $e) {

            }
        }

        if ($this->getControlValue('do-action-hidden')){
            try {

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $categoryID) {
                        try {
                            SQLObject::TransactionStart();
                            $currentCategory = Shop::Get()->getGameService()->getGameByID($categoryID);
                            $currentCategory->setHidden(1);
                            $currentCategory->update();
                            $this->setValue('success', 1);
                            $this->setValue('successName', 'Видимость изменена успешно!');
                            SQLObject::TransactionCommit();
                        } catch (Exceprion $e) {
                            SQLObject::TransactionRollback();
                        }
                    }
                }

            } catch (Exception $e) {

            }
        }


        ////////////////////////////////////////////////////////////////////////

        $this->setValue('categoryArray', $this->_makeCategoryArray());
    }

    private function _makeCategoryArray() {
        $games = Shop::Get()->getGameService()->getAllGames();
        $a = array();

        while ($x = $games->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'hidden' => $x->getHidden(),
                'selected' => $x->getId() == $this->getValue('categorySelected'),
                'editURL' => $x->makeURLEdit()
            );
        }
        return $a;
    }

}