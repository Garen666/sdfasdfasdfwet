<?php
class textpages_index extends Engine_Class {

    public function process() {
        $this->setValue('pagesArray', $this->_makeTree(0));
        PackageLoader::Get()->import('CKFinder');
        CKFinder_Configuration::Get()->setAuthorized(true);
        $pageID = $this->getArgumentSecure('open');
        if ($pageID) {
            try {
                $form = new Forms_ContentForm(new Datasource_TextPages(false));
                $form->denyInsert();
                try {
                    Shop::Get()->getTextPageService()->getTextPageByParentID($pageID);
                    $form->denyDelete();
                } catch (Exception $e) {

                }

                $va = $form->getField('parentid')->getValidatorsArray();
                $va[0]->setDisallowID($pageID);

                $this->setValue('form', $form->render($pageID));
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }

                Engine::Get()->getRequest()->setContentNotFound();
            }
        }
    }

    private function _makeTree($parentID) {
        $pages = new XShopTextPage();
        $pages->setOrder('sort', 'ASC');
        $pages->setParentid($parentID);
        $a = array();
        while ($x = $pages->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => htmlspecialchars($x->getName()),
            'url' => Engine::GetLinkMaker()->makeURLByContentIDParam($this->getContentID(), $x->getId(), 'open'),
            'childsArray' => $this->_makeTree($x->getId()),
            );
        }
        return $a;
    }

}