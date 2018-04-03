<?php
class products_add extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->registerJSFile('/_js/jquery.cookie.js');
        PackageLoader::Get()->import('CKFinder');

        $this->setValue('cropper', Engine::GetContentDriver()->getContent('imagecropper')->render());

        $actionForm = Engine::Get()->GetLinkMaker()->makeURLByContentID('shop-admin-products-add');
        $this->setValue('actionForm', $actionForm);

        if($categoryId = $this->getArgumentSecure('categoryid')) {
            $this->setControlValue('category', $categoryId);
        }
        if ($newProductId = $this->getArgumentSecure('new_product_id')) {
            $this->setValue('message', 'ok');
            $newProduct = Shop::Get()->getShopService()->getProductByID($newProductId);
            $this->setValue('urlEdit', $newProduct->makeURLEdit());
            $this->setValue('productURL', $newProduct->makeURL());
        }

        if ($this->getControlValue('ok') || $this->getControlValue('ok_continue')) {
            try {
                SQLObject::TransactionStart();

                $name = $this->getControlValue('name');
                if (is_array($name)) {
                    $name = implode(' / ', $name);
                }
                $this->setControlValue('name', $name);


                $product = Shop::Get()->getShopService()->addProduct(
                $name,
                $this->getControlValue('code')
                );

                if ($this->getArgumentSecure('imageSave') && $this->getControlValue('big-image-main')) {
                    $image = PackageLoader::Get()->getProjectPath().$this->getControlValue('big-image-main');
                } else {
                    $image = '';
                }

                $downloadFile = $this->getControlValue('downloadfile');
                $downloadFile = @$downloadFile['tmp_name'];

                Shop::Get()->getShopService()->updateProduct(
                $product,
                $product->getName(),
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
                false,
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
                $this->getControlValue('icon'),
                $downloadFile,
                false, // не удалять скачиваемый файл
                $this->getControlValue('datelifefrom'),
                $this->getControlValue('datelifeto'),
                $this->getControlValue('articul')
                );

                $imageCrop = '';
                if ($this->getControlValue('imagecropper-name') != 'noChange') {
                    $file = $this->getControlValue('imagecropper-name');
                    $x1 = $this->getControlValue('imagecropper-x1');
                    $y1 = $this->getControlValue('imagecropper-y1');
                    $x2 = $this->getControlValue('imagecropper-x2');
                    $y2 = $this->getControlValue('imagecropper-y2');

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
                            $imageCrop = '';
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

                // обновляем фильтры
                try {
                    $filter_count = Engine::Get()->getConfigField('filter_count');
                } catch (Exception $e) {
                    $filter_count = 10;
                }
                for ($j = 1; $j <= $filter_count; $j++) {
                    $filterID = $this->getControlValue('filter'.$j.'id');
                    $filterValue = $this->getControlValue('filter'.$j.'value');
                    $filterUse = $this->getControlValue('filter'.$j.'use');
                    $filterActual = $this->getControlValue('filter'.$j.'actual');
                    $filterOption = $this->getControlValue('filter'.$j.'option');

                    $product->setField('filter'.$j.'id', $filterID);
                    $product->setField('filter'.$j.'value', $filterValue);
                    $product->setField('filter'.$j.'use', $filterUse);
                    $product->setField('filter'.$j.'actual', $filterActual);
                    $product->setField('filter'.$j.'option', $filterOption);
                }

                // обновляем уровни цен
                for ($j = 1; $j <= 5; $j++) {
                    $product->setField('price'.$j, $this->getControlValue('price'.$j));
                }

                $tagsArray = $this->getControlValue('tags');
                if( !empty($tagsArray) ){
                    $tagsArray = $this->_checkTags($tagsArray);
                    $product->setTags(implode(',',$tagsArray));
                }

                $product->setPricebase($this->getControlValue('pricebase'));
                $product->setSource($this->getControlValue('source'));
                $product->setTerm($this->getControlValue('term'));
                $product->setSeriesname($this->getControlValue('seriesname'));

                $product->update();

                SQLObject::TransactionCommit();

                if ($this->getControlValue('ok_continue')) {
                    header ("Location: ".Engine_LinkMaker::Get()->makeURLByContentID('shop-admin-products-add')."/?new_product_id=".$product->getId());
                    exit();
                } else {
                    header ("Location: ".$product->makeURLEdit());
                    exit();
                }
            } catch (ServiceUtils_Exception $addEx) {
                SQLObject::TransactionRollback();
                print $addEx;
                if (PackageLoader::Get()->getMode('debug')) {
                    print $addEx;
                }

                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $addEx->getErrorsArray());
            }


        } else {
            $this->setControlValue('syncable', true);
            $this->setControlValue('currency', Shop::Get()->getCurrencyService()->getCurrencySystem()->getId());
        }

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

        // значения фильтро по данному товару
        $a = array();
        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }
        for ($j = 1; $j <= $filter_count; $j++) {
            if (isset($product)) {
                $filterID = $product->getField('filter'.$j.'id');
                $filterValue = $product->getField('filter'.$j.'value');
                $filterUse = $product->getField('filter'.$j.'use');
                $filterActual = $product->getField('filter'.$j.'actual');
                $filterOption = $product->getField('filter'.$j.'option');
            } else {
                $filterID = 0;
                $filterValue = '';
                $filterUse = 0;
                $filterActual = 0;
                $filterOption = 0;
            }
            $a[$j] = array(
            'id' => $filterID,
            'value' => $filterValue,
            'use' => $filterUse,
            'actual' => $filterActual,
            'option' => $filterOption,
            );
        }
        $this->setValue('valuesArray', $a);

        // список валют
        $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
        $this->setValue('currencyArray', $currency->toArray());

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
