<?php

class Shop_ModuleLoader {

    /**
     * Подключить модуль
     *
     * @param strind $moduleName
     * @param bool $isTemplate //deprecated
     * @return bool
     */
    public function import($moduleName, $isTemplate = false) {
        // проверяем, подключен ли модуль
        if ($this->isImported($moduleName)) {
            return false;
        }

        if ($isTemplate) {
            // @deprecated
            $includePath = PackageLoader::Get()->getProjectPath() . '/templates/' . $moduleName . '/include.php';
        } else {
            // module
            $includePath = PackageLoader::Get()->getProjectPath() . '/modules/' . $moduleName . '/include.php';
        }

        if (file_exists($includePath)) {
            include_once($includePath);
        }

        // запоминаем, какие модули подключены
        if (!isset($this->_importedArray[$moduleName])) {
            $this->_importedArray[$moduleName] = $moduleName;
        }

        return true;
    }

    /**
     * Проверить, подключен ли модуль
     *
     * @param string $packageName
     * @return bool
     */
    public function isImported($moduleName) {
        return (isset($this->_importedArray[$moduleName]));
    }

    /**
     * Получить массив зарегистрированных модулей
     *
     * @return array
     */
    public function getImportedModules() {
        return $this->_importedArray;
    }

    /**
     * Получить пункты верхнего меню
     *
     * @return array
     */
    public function getTopMenuArray() {
        return $this->_topMenuItemArray;
    }

    /**
     * Получить пункты меню "Настройки"
     *
     * @return array
     */
    public function getSettingMenuArray() {
        $result = $this->_settingMenuItemArray;
        usort($result, array($this, '_sortMenu'));
        return $result;
    }

    /**
     * Получить пункты меню "Отчеты"
     *
     * @return array
     */
    public function getReportMenuArray() {
        $result = $this->_reportMenuItemArray;
        usort($result, array($this, '_sortMenu'));
        return $result;
    }

    /**
     * Получить пункты табов юзера
     *
     * @return array
     */
    public function getUserTabArray() {
        return $this->_userTabItemArray;
    }

    /**
     * Получить пункты табов товара
     *
     * @return array
     */
    public function getProductTabArray() {
        return $this->_productTabItemArray;
    }

    /**
     * Получить пункты табов заказа
     *
     * @return array
     */
    public function getOrderTabArray() {
        return $this->_orderTabItemArray;
    }

    /**
     * Добавить пункт в верхнее меню
     *
     * @param string $name
     * @param string $url
     */
    public function registerTopMenuItem($name, $url) {
        $this->_topMenuItemArray[] = array(
        'name' => $name,
        'url' => $url
        );
    }

    /**
     * Добавить пункт в "Настройки"
     *
     * @param string $name
     * @param string $url
     */
    public function registerSettingMenuItem($name, $url) {
        $this->_settingMenuItemArray[] = array(
        'name' => $name,
        'url' => $url
        );
    }

    /**
     * Добавить пункт в "Отчеты"
     *
     * @param string $name
     * @param string $url
     */
    public function registerReportMenuItem($name, $url) {
        $this->_reportMenuItemArray[] = array(
        'name' => $name,
        'url' => $url
        );
    }

    /**
     * Добавить пункт в табы юзера
     *
     * @param string $name
     * @param string $contentID
     * @param string $moduleName
     */
    public function registerUserTabItem($name, $contentID, $moduleName) {
        $this->_userTabItemArray[] = array(
        'name' => $name,
        'contentID' => $contentID,
        'moduleName' => $moduleName
        );
    }

    /**
     * Добавить пункт в табы товара
     *
     * @param string $name
     * @param string $contentID
     * @param string $moduleName
     */
    public function registerProductTabItem($name, $contentID, $moduleName) {
        $this->_productTabItemArray[] = array(
        'name' => $name,
        'contentID' => $contentID,
        'moduleName' => $moduleName
        );
    }

    /**
     * Добавить пункт в табы заказа
     *
     * @param string $name
     * @param string $contentID
     * @param string $moduleName
     */
    public function registerOrderTabItem($name, $contentID, $moduleName) {
        $this->_orderTabItemArray[] = array(
        'name' => $name,
        'contentID' => $contentID,
        'moduleName' => $moduleName
        );
    }

    /**
     * @return Shop_ModuleLoader
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private static $_Instance = null;

    /**
     * Список модулей, которые уже подключены
     *
     * @var array
     */
    private $_importedArray = array();

    /**
     * Зарегистрированные пункты меню
     *
     * @var array
     */
    private $_topMenuItemArray = array();
    private $_settingMenuItemArray = array();
    private $_reportMenuItemArray = array();

    /**
     * Зарегистрированные табы
     *
     * @var array
     */
    private $_userTabItemArray = array();
    private $_productTabItemArray = array();
    private $_orderTabItemArray = array();

    private function _sortMenu($a, $b) {
        return $a['name'] > $b['name'];
    }
}