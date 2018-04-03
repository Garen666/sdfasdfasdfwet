<?php

class Shop_TranslateService extends ServiceUtils_AbstractService {

    /**
     * Получить перевод
     *
     * @param $key
     * @return string
     * @throws Forms_Exception
     */
    public function getTranslate($key) {
        if (!$key) {
            throw new Forms_Exception("Empty key");
        }

        $key = str_replace('-', '_', $key);

        if (isset($this->_translateArray[$key])) {
            return $this->_translateArray[$key];
        }
        throw new Forms_Exception("Empty value for key '{$key}'");
    }

    /**
     * Получить перевод (безопастно)
     *
     * @param $key
     * @return string
     */
    public function getTranslateSecure($key) {
        try {
            return $this->getTranslate($key);
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * @param $key
     * @param $value
     * @throws Forms_Exception
     */
    public function setTranslate($key, $value) {
        if (!$key) {
            throw new Forms_Exception("Empty key");
        }
        $this->_translateArray[$key] = trim($value);
    }

    /**
     * @param $translateArray
     */
    public function setTranslateArray($translateArray) {
        $this->_translateArray = array_merge($this->_translateArray, $translateArray);
    }

    /**
     * Получить все переводы
     * (массив в формате key-value)
     *
     * @return array
     */
    public function getTranslateArray () {
        return $this->_translateArray;
    }

    /**
     * Добавить переводов в систему
     *
     * @param array $a
     */
    public function addTranslateArray($a) {
        if (!$a) {
            throw new Forms_Exception('Empty translate array');
        }

        $this->_translateArray = array_merge($this->_translateArray, $a);
    }

    /**
     * Добавить переводов из XML-файла
     * @deprecated
     * USE addTranslateFromPHP
     * @param string $file
     */
    public function addTranslateFromXML($file) {
        $data = file_get_contents($file);
        $xml = (array) simplexml_load_string($data);

        foreach ($xml as $key => $value) {
            $key = trim($key.'');

            if (is_array($value)) {
                // issue #42291 - array bugfix
                $this->setTranslate($key, $value[0].'');
            } else {
                $this->setTranslate($key, $value.'');
            }
        }
    }

    /**
     * Добавить переводов из PHP-файла
     *
     * @param string $file
     */
    public function addTranslateFromPHP($file) {
        include_once($file);
        if (empty($translateArray)) {
            throw new Exception ("No translates in php file");
        }
        $this->setTranslateArray($translateArray);
    }

    /**
     * @return Shop_TranslateService
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private static $_Instance = null;

    private $_translateArray = array();

}