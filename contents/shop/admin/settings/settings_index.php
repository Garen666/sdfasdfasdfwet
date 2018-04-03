<?php
class settings_index extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->import('CKFinder');
        PackageLoader::Get()->registerJSFile('/_js/jQueryTabs.js');
        CKFinder_Configuration::Get()->setAuthorized(true);

        if ($this->getArgumentSecure('ok')) {
            try {
                SQLObject::TransactionStart();

                $settings = Shop::Get()->getSettingsService()->getSettingsAll();
                while ($s = $settings->getNext()) {
                    $value = $this->getControlValue('setting'.$s->getId());

                    if ($s->getType() == 'image' || $s->getType() == 'file') {
                        $value = @$value['tmp_name'];
                        if (!$value) {
                            continue;
                        }
                    }
                    
                    if ($s->gettype() == 'chzn-select-time') {
                        $value = serialize($value);
                    }

                    Shop::Get()->getSettingsService()->updateSettings(
                    $s,
                    $value
                    );
                }

                // удаляем файлы
                $deleteArray = (array) $this->getArgumentSecure('delete');
                foreach ($deleteArray as $settingID) {
                    try {
                        Shop::Get()->getSettingsService()->deleteSettingsValue(
                        $settingID
                        );
                    } catch (Exception $e) {

                    }
                }

                $this->setValue('message', 'ok');
                SQLObject::TransactionCommit();
            } catch (Exception $e) {
                SQLObject::TransactionStart();
                $this->setValue('message', 'error');

                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        } elseif ($this->getArgumentSecure('cash')) {
            $this->setValue('message', 'cash');
        }

        // выводим все настройки
        $settings = Shop::Get()->getSettingsService()->getSettingsAll();
        $settings->setOrderBy('name');
        $a = array();

        while ($s = $settings->getNext()) {
            $tabname = $s->getTabname();
            if (!$tabname) {
                $tabname = 'Общие настройки';
            }

            $info['name'] = $s->getName();
            $info['value'] = $s->getValue();
            $info['type'] = $s->getType();
            $info['id'] = $s->getId();
            $info['description'] = $s->getDescription();
            
            // unserialize для селектов с множественным вводом
            if ($info['type'] == 'chzn-select-time') {
                $info['value'] = unserialize($info['value']);
            }
            
            $a[$tabname][] = $info;
        }

        ksort($a);
        $this->setValue('tabsArray', $a);

        $this->setValue('tabSelect', 'false');
        if ($this->getArgumentSecure('tabname')) {
            $this->setValue('tabSelected', urldecode($this->getArgumentSecure('tabname')));
            $this->setValue('tabSelect', 'true');
        }
    }

}