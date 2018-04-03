<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Golub Oleksii <avator@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_SettingsService extends ServiceUtils_AbstractService {

    /**
     * Получить заказные звонки
     *
     * @return XShopSettings
     */
    public function getSettingsAll() {
        $x = new XShopSettings();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * @return XShopSettings
     */
    public function getSettingsByID($id) {
        return $this->getObjectByID($id, 'XShopSettings');
    }

    /**
     * Получить значение по ключу.
     *
     * @param string $key
     * @return mixed
     */
    public function getSettingValue($key) {
        $key = trim($key);

        // если уже есть кеш
        if ($this->_settingsArray !== 0) {
            if (isset($this->_settingsArray[$key])) {
                return $this->_settingsArray[$key];
            } else {
                return false;
            }
        }

        // вычитываем кеш
        $a = array();

        $settings = new XShopSettings();
        while ($x = $settings->getNext()) {
            $a[$x->getKey()] = $x->getValue();
        }
        $this->_settingsArray = $a;

        if (isset($a[$key])) {
            return $a[$key];
        } else {
            return false;
        }
    }

    /**
     * Обновить значение настройки
     *
     * @param XShopSettings $setting
     * @param string $value
     * @param bool $checkImage
     */
    public function updateSettings(XShopSettings $setting, $value, $checkImage = true) {
        try {
            SQLObject::TransactionStart();

            $value = trim($value);
            $oldValue = $setting->getValue();

            if ($setting->getType() == 'image' && $checkImage) {
                if ($setting->getKey() == 'favicon') {
                    $format = 'ico';
                } else
                if($setting->getKey() == 'background') {
                    $format = 'jpg';
                }
                 else {
                    $format = false;
                }
                $file = Shop::Get()->getShopService()->makeImagesUploadUrl($value, '/upload/', $format);
                copy($value, MEDIA_PATH.'/upload/'.$file);
                $value = '/media/upload/'.$file;
            }

            $setting->setValue($value);
            $setting->update();
            // Если есть кеш, обновляем значение
            if ($this->_settingsArray !== 0) {
                $this->_settingsArray[$setting->getKey()] = $setting->getValue();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить значение свойства
     */
    public function deleteSettingsValue($settingID) {
        try {
            SQLObject::TransactionStart();

            $settings = $this->getSettingsByID($settingID);

            $settings->setValue('');
            $settings->update();
            // Если есть кеш, удаляем значение
            if ($this->_settingsArray !== 0) {
                $this->_settingsArray[$settings->getKey()] = '';
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    private $_settingsArray = 0;

}