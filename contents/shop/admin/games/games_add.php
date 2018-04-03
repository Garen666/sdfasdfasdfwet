<?php
class games_add extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->registerJSFile('/_js/jquery.cookie.js');
        PackageLoader::Get()->import('CKFinder');

        $this->setValue('cropper', Engine::GetContentDriver()->getContent('imagecropper')->render());

        if ($this->getControlValue('ok')) {
            try {
                SQLObject::TransactionStart();

                $name = $this->getControlValue('name');
                if (is_array($name)) {
                    $name = implode(' / ', $name);
                }
                $this->setControlValue('name', $name);

                $game = Shop::Get()->getGameService()->addGame($name);

                if ($this->getArgumentSecure('imageSave') && $this->getControlValue('big-image-main')) {
                    $image = PackageLoader::Get()->getProjectPath().$this->getControlValue('big-image-main');
                } else {
                    $image = '';
                }

                Shop::Get()->getGameService()->updateGame(
                    $game,
                    $name,
                    $this->getControlValue('description'),
                    $image,
                    $this->getControlValue('hidden'),
                    $this->getControlValue('seodescription'),
                    $this->getControlValue('seotitle'),
                    "",
                    $this->getControlValue('seocontent'),
                    $this->getControlValue('seokeywords')
                );

                SQLObject::TransactionCommit();

                header ("Location: ".$game->makeURLEdit());
            } catch(ServiceUtils_Exception $addEx) {
                SQLObject::TransactionRollback();
                print $addEx;
                if (PackageLoader::Get()->getMode('debug')) {
                    print $addEx;
                }

                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $addEx->getErrorsArray());
            }
        }

        /////////////////////////////////////////////////////////////////////

        // список категорий
        $games = Shop::Get()->getGameService()->getAllGames();
        $a = array();
        foreach ($games as $x) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'hidden' => $x->getHidden(),
            );
        }
        $this->setValue('gamesArray', $a);

        if (!$this->getControlValue('ok')) {
            $this->setControlValue('divisibility', 0);
        }
    }

    private function _checkTags($tags) {
        $tags = explode(',', $tags);
        $trimedTags = array();
        if ( !empty($tags) ){
            foreach ($tags as $a) {
                $a = trim($a);
                if ($a) {
                    $trimedTags[] = $a;
                }
            }
        }
        return array_unique($trimedTags);
    }

}