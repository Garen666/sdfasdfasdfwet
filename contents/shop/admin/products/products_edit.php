<?php
class products_edit extends Engine_Class {

    public function process() {
        header("X-XSS-Protection: 0"); // for chrome
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->registerJSFile('/_js/jquery.cookie.js');
        PackageLoader::Get()->import('CKFinder');

        $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
        $menu->setValue('selected', 'edit');
        $this->setValue('menu', $menu->render());

        $this->setValue('cropper', Engine::GetContentDriver()->getContent('imagecropper')->render());

        try {
            $product = Shop::Get()->getShopService()->getProductByID(
            $this->getArgument('id')
            );

            $user = $this->getUser();
            $isOwner = ($user->getId() == $product->getUserid());

            $this->setValue('productid', $product->getId());
            Engine::GetHTMLHead()->setTitle('Редактирование товара - #' . $product->getId() . " " . htmlspecialchars($product->getName()));

            if (!($user->isAllowed('products-edit') || ($isOwner && $user->isAllowed('products-owner-edit')))) {
                $this->setValue('canEdit', false);
                throw new ServiceUtils_Exception();
            }

            $this->setValue('canEdit', true);

            if ($this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    if ($this->getArgumentSecure('imageSave') && $this->getControlValue('big-image-main')) {
                        $image = PackageLoader::Get()->getProjectPath().$this->getControlValue('big-image-main');
                    } else {
                        $image = '';
                    }
                    if ($this->getControlValue('icon')){
                        if ($this->getControlValue('icon') != 0){
                            $iconid = Shop::Get()->getShopService()->getProductIconByID($this->getControlValue('icon'))->getId();
                        }
                    } else {
                        $iconid = false;
                    }

                    $downloadFile = $this->getControlValue('downloadfile');
                    $downloadFile = @$downloadFile['tmp_name'];

                    Shop::Get()->getShopService()->updateProduct(
                    $product,
                    $this->getControlValue('name'),
                    $this->getControlValue('description'),
                    $this->getControlValue('category'),
                    $this->getControlValue('brand'),
                    $this->getControlValue('model'),
                    $this->getControlValue('price'),
                    $this->getControlValue('priceold'),
                    $this->getControlValue('currency'),
                    $this->getControlValue('unit'),
                    $this->getControlValue('barcode'),
                    $this->getControlValue('discount'),
                    $this->getControlValue('preorderDiscount'),
                    $this->getControlValue('warranty'),
                    $this->getControlValue('hidden'),
                    $this->getControlValue('deleted'),
                    $this->getControlValue('avail'),
                    $this->getControlValue('availtext'),
                    $this->getControlValue('syncable'),
                    $this->getControlValue('url'),
                    $image,
                    $this->getControlValue('deleteimagemain'),
                    0,
                    $this->getControlValue('width'),
                    $this->getControlValue('height'),
                    $this->getControlValue('length'),
                    $this->getControlValue('weight'),
                    $this->getControlValue('unitbox'),
                    $this->getControlValue('delivery'),
                    $this->getControlValue('payment'),
                    $this->getControlValue('divisibility'),
                    $this->getControlValue('userid'),
                    $this->getControlValue('denycomments'),
                    $this->getControlValue('siteurl'),
                    $this->getControlValue('tax'),
                    $this->getControlValue('descriptionshort'),
                    $this->getControlValue('name1'),
                    $this->getControlValue('name2'),
                    $this->getControlValue('code1c'),
                    0,
                    $this->getControlValue('characteristics'),
                    $this->getControlValue('share'),
                    $this->getControlValue('seotitle'),
                    $this->getControlValue('seodescription'),
                    $this->getControlValue('seocontent'),
                    $this->getControlValue('seokeywords'),
                    $iconid,
                    $downloadFile,
                    $this->getControlValue('deleteDownloadfile'),
                    $this->getControlValue('datelifefrom'),
                    $this->getControlValue('datelifeto'),
                    $this->getControlValue('articul')
                    );

                    $imageCrop = '';
                    if ($this->getControlValue('imagecropper-name') != 'noChange') {
                        $file = $this->getControlValue('imagecropper-name');
                        $koef = $this->getControlValue('imagecropper-koef');
                        $x1 = $this->getControlValue('imagecropper-x1')*$koef;
                        $y1 = $this->getControlValue('imagecropper-y1')*$koef;
                        $x2 = $this->getControlValue('imagecropper-x2')*$koef;
                        $y2 = $this->getControlValue('imagecropper-y2')*$koef;

                        $width = $x2 - $x1;
                        $height = $y2 - $y1;

                        // проверка, чтобы кроппер не сделал больше чем надо
                        $tmp = @getimagesize(PackageLoader::Get()->getProjectPath().$file);
                        $widthOriginal = $tmp[0];
                        $heightOriginal = $tmp[1];

                        if ($width <= $widthOriginal || $height <= $heightOriginal) {
                            try {
                                $ip = new ImageProcessor(PackageLoader::Get()->getProjectPath().$file);
                                // выполняем вырезку
                                $ip->addAction(new ImageProcessor_ActionCut($x1, $y1, $width, $height));
                                if ($this->getControlValue('imagecropper-ext') == 'jpg') {
                                    $ip->addAction(new ImageProcessor_ActionToJPEG(PackageLoader::Get()->getProjectPath().$file));
                                } else {
                                    $ip->addAction(new ImageProcessor_ActionToPNG(PackageLoader::Get()->getProjectPath().$file));
                                }
                                $ip->process();

                                $imageCrop = PackageLoader::Get()->getProjectPath().$file;
                            } catch (Exception $e) {

                            }
                        }
                    }

                    // Добавляем кроп-изображение.
                    if ($imageCrop) {
                        Shop::Get()->getShopService()->updateProductImageCrop($product, $imageCrop);
                        unlink($imageCrop);
                    }

                    // Удаляем временное изображение.
                    @unlink($image);


                    // удаляем картинки
                    $deleteArray = $this->getArgumentSecure('deleteimage');
                    if ($deleteArray) {
                        foreach ($deleteArray as $imageID) {
                            try {
                                $image = Shop::Get()->getShopService()->getProductImageByID(
                                $imageID
                                );

                                Shop::Get()->getShopService()->deleteProductImage(
                                $product,
                                $image
                                );
                            } catch (Exception $e) {

                            }
                        }
                    }


                    // обновляем уровни цен
                    for ($j = 1; $j <= 5; $j++) {
                        $product->setField('price'.$j, $this->getControlValue('price'.$j));
                    }

                    $product->setPricebase($this->getControlValue('pricebase'));
                    $product->setSource($this->getControlValue('source'));
                    $product->setTerm($this->getControlValue('term'));
                    $product->setSeriesname($this->getControlValue('seriesname'));

                    // Установка тегов товара
                    $tagsArray = $this->getControlValue('tags');
                    if ( !empty($tagsArray) ){
                        $product->setTags(implode(',',$this->_checkTags($tagsArray)));
                    }else {
                        $product->setTags('');
                    }

                    $product->update();

                    $this->setValue('message', 'ok');

                    SQLObject::TransactionCommit();
                } catch (ServiceUtils_Exception $e) {
                    SQLObject::TransactionRollback();  //echo'<pre>'; print_r($e);echo'<pre>'; exit;

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            $this->setControlValue('name', $product->getName());
            $this->setControlValue('description', $product->getDescription());
            $this->setControlValue('price', $product->getPrice());
            $this->setControlValue('currency', $product->getCurrencyid());
            $this->setControlValue('category', $product->getCategoryid());
            $this->setControlValue('model', $product->getModel());
            $this->setControlValue('articul', $product->getArticul());
            $this->setControlValue('seriesname', $product->getSeriesname());
            $this->setControlValue('discount', $product->getDiscount());
            $this->setControlValue('preorderDiscount',$product->getPreorderDiscount());
            $this->setControlValue('hidden', $product->getHidden());
            $this->setControlValue('deleted', $product->getDeleted());
            $this->setControlValue('unit', $product->getUnit());
            $this->setControlValue('url', $product->getUrl());
            $this->setControlValue('barcode', $product->getBarcode());
            $this->setControlValue('warranty', $product->getWarranty());
            $this->setControlValue('width', $product->getWidth());
            $this->setControlValue('height', $product->getHeight());
            $this->setControlValue('length', $product->getLength());
            $this->setControlValue('weight', $product->getWeight());
            $this->setControlValue('unitbox', $product->getUnitbox());
            $this->setControlValue('payment', $product->getPayment());
            $this->setControlValue('divisibility', $product->getDivisibility());
            $this->setControlValue('syncable', !$product->getUnsyncable());
            $this->setControlValue('avail', $product->getAvail());
            $this->setControlValue('availtext', $product->getAvailtext());
            $this->setControlValue('userid', $product->getUserid());
            $this->setControlValue('siteurl', $product->getSiteurl());
            $this->setControlValue('denycomments', $product->getDenycomments());
            $this->setControlValue('tax', $product->getTaxid());
            $this->setControlValue('descriptionshort', $product->getDescriptionshort());
            $this->setControlValue('name1', $product->getName1());
            $this->setControlValue('name2', $product->getName2());
            $this->setControlValue('characteristics', $product->getCharacteristics());
            $this->setControlValue('share', $product->getShare());
            $this->setControlValue('seotitle', $product->getSeotitle());
            $this->setControlValue('seodescription', $product->getSeodescription());
            $this->setControlValue('seocontent', $product->getSeocontent());
            $this->setControlValue('seokeywords', $product->getSeokeywords());
            $this->setControlValue('priceold', $product->getPriceold());
            $this->setControlValue('icon', $product->getIconid());
            $this->setControlValue('datelifefrom', $product->getDatelifefrom());
            $this->setControlValue('datelifeto', $product->getDatelifeto());
            $this->setControlValue('source', $product->getSource());
            $this->setControlValue('term', $product->getTerm());
            $this->setControlValue('pricebase', $product->getPricebase());

            $this->setControlValue( 'tags',$product->getTags() );
            for ($j =1; $j <= 5; $j++) {
                $this->setControlValue('price'.$j, $product->getField('price'.$j));
            }
            $this->setValue('productURL', $product->makeURL());

            try {
                $downloadfileURL = Shop::Get()->getShopService()->makeProductDownloadURL(
                $product
                );

                $this->setValue('downloadfileURL', $downloadfileURL);
            } catch (Exception $e) {

            }

            $this->setValue('imagemainsrc', $product->getImage());
            $this->setValue('imagemain', $product->makeImageThumb(200));
            $this->setValue('imagemainBig', $product->makeImageThumb(1600));

            // дополнительные изображения
            $images = $product->getImages();
            $a = array();
            while ($x = $images->getNext()) {
                try {
                    $a[] = array(
                    'id' => $x->getId(),
                    'image' => $x->makeImageThumb(200),
                    'imageBig' => $x->makeImageThumb(1600),
                    );
                } catch (Exception $e) {

                }
            }
            $this->setValue('imagesArray', $a);

            // список категорий
            $category = Shop::Get()->getShopService()->makeCategoryTree();
            $a = array();
            foreach ($category as $x) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'hidden' => $x->getHidden(),
                'level' => $x->getField('level'),
                );
            }
            $this->setValue('categoryArray', $a);

            // список валют
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $this->setValue('currencyArray', $currency->toArray());

        } catch (ServiceUtils_Exception $ge) {
            if ($ge->getMessage() == 'Shop-object by id not found') {
                $this->setValue('message', 'product_not_fount');
            }
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }
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