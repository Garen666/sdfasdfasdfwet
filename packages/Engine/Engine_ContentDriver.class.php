<?php
/**
 * WebProduction Packages
 * @copyright (C) 2007-2014 WebProduction <webproduction.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * Класс управления выводом контентов
 *
 * @copyright WebProduction
 * @author DFox
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @package Engine
 */
class Engine_ContentDriver {

    /**
     * Получить содержимое контента
     *
     * @param mixed $contentID
     * @return string
     */
    public function getString($contentID) {
        $queryStartID = $contentID;

        $contentData = Engine::GetContentDataSource()->getDataByID($contentID);

        $ttl = @$contentData['cache']['ttl'];
        $type = @$contentData['cache']['type'];

        // специальный тип кеша:
        // кешировать всю страницу полностью,
        // если есть юзер - то только контент (для всех юзеров)
        if ($type == 'page-content') {
            try {
                Engine::GetAuth()->getUser();
                $type = 'content';
            } catch (Exception $userEx) {
                $type = 'page';
            }
        }

        if (empty($html)) {
            // по заголовку X-engine-render определяем, показывать весь
            // контент или нет
            if (!empty($_SERVER['HTTP_X_ENGINE_RENDER'])) {
                $headerRenderType = $_SERVER['HTTP_X_ENGINE_RENDER'];
            } else {
                $headerRenderType = false;
            }

            if ($headerRenderType == 'content') {
                $html = $this->displayOne($contentID);
            } else {
                $html = $this->display($contentID);
            }
        }

        if (Engine::Get()->getRequest()->getContentID() != $queryStartID) {
            // если в процессе обработки контента поменялся указатель contentID,
            // значит повторяем вызов рекурсивно, пока не будет изменений
            return $this->getString(Engine::Get()->getRequest()->getContentID());
        }

        return $html;
    }

    /**
     * Вернуть готовое html-содержимое контента и всех его вложений
     * с учетом иерархии
     *
     * @author DFox
     * @author Max
     * @param mixed $contentID
     * @return string
     */
    public function display($contentID) {
        $str = $this->displayOne($contentID);
        $m = $this->getContent($contentID)->getField('moveto');
        if ($m) {
            $this->getContent($m)->setValue($this->getContent($contentID)->getField('moveas'), $str);
            return $this->display($m);
        }
        return $str;
    }

    /**
     * Вернуть объект контента по его ID
     *
     * @author Maxim Miroshnichenko
     * @param string $contentID
     * @param bool $cacheObject Сохранить ли объект во внутреннем кеш-pool'e?
     * @return Engine_Class
     */
    public function getContent($contentID, $cacheObject = true) {
        // @todo: returns Engine_Content

        if (empty($this->_contentsArray[$contentID])) {
            $data = Engine_ContentDataSource::Get()->getDataByID($contentID);
            if (!$data) {
                throw new Engine_Exception("Content #{$contentID} not found in ContentDataSource", 1);
            }

            $classname = $data['fileclass'];
            if (!class_exists($classname) && $data['filephp']) {
                // если задан php-файл
                include_once($data['filephp']);
            }

            if (!class_exists($classname)) {
                throw new Engine_Exception("Content class '{$classname}' not found", 2);
            }

            $obj = new $classname($contentID);

            // устанавливаем все поля как значения из DataSource'a
            $obj->setFieldArray((array) $data);

            // для того, что-бы были объект, а не строки
            $obj->setField('filephp', $data['filephp']);
            $obj->setField('filehtml', $data['filehtml']);

            // обрабатываем CSS-файлы
            $cssfile = $data['filecss'];
            foreach ($cssfile as $cssfileOne) {
                // подключаем CSS-файл
                PackageLoader::Get()->registerCSSFile($cssfileOne, true, false);
            }

            // обрабатываем JS-файлы
            $jsfile = $data['filejs'];
            foreach ($jsfile as $jsfileOne) {
                // подключаем JS-файл
                PackageLoader::Get()->registerJSFile($jsfileOne, true, false);
            }

            // кешируем объект
            if ($cacheObject) {
                $this->_contentsArray[$contentID] = $obj;
            }

            // вызываем все пре-процессоры
            $event = Events::Get()->generateEvent('beforeContentProcess');
            $event->setContent($obj);
            $event->notify();

            return $obj;
        }

        return $this->_contentsArray[$contentID];
    }

    /**
     * Узнать, был ли загружен/вызван контент
     *
     * @param string $contentID
     * @return bool
     */
    public function isContentLoaded($contentID) {
        return isset($this->_contentsArray[$contentID]);
    }

    /**
     * Обработать и вернуть содержимое контента $contentID
     *
     * @deprecated
     * @see render() in class Engine_Content
     *
     * @param int $contentID
     * @return string
     */
    public function displayOne($contentID) {
        $data = Engine::GetContentDataSource()->getDataByID($contentID);
        if (!$data) {
            throw new Engine_Exception("Content #{$contentID} not found in ContentDataSource", 1);
        }

        $ttl = @$data['cache']['ttl'];
        $type = @$data['cache']['type'];
        $modifiersArray = @$data['cache']['modifiers'];

        // специальный тип кеша:
        // кешировать всю страницу полностью,
        // если есть юзер - то только контент (для всех юзеров)
        if ($type == 'page-content') {
            try {
                Engine::GetAuth()->getUser();
                $type = 'content';
            } catch (Exception $userEx) {
                $type = 'page';
            }
        }

        $obj = $this->getContent($contentID);

        // если события выше стерли файл - то значит запускать процессор
        // нельзя
        // @todo: это похоже на костыль
        if ($obj->getField('filephp')) {
            $obj->process();
        }

        // вызываем все пост-процессоры
        $event = Events::Get()->generateEvent('afterContentProcess');
        $event->setContent($obj);
        $event->notify();

        // если html-файла нет - то нет смысла продолжать
        $file = $obj->getField('filehtml');
        if (!$file) {
            return '';
        }

        $a = $obj->getValuesArray();

        $arguments = Engine::GetURLParser()->getArguments();
        foreach ($arguments as $name => $value) {
            if (is_array($value)) {
                continue;
            }
            $a['arg_'.$name] = $value;
            if ($obj->isControlValue($name)) {
                $a['control_'.$name] = htmlspecialchars($value);
            }
        }

        // рендерим контент
        $html = Engine::GetSmarty()->fetch($file, $a);

        // генерируем событие afterRender
        $event = Events::Get()->generateEvent('afterContentRender');
        $event->setContent($obj);
        $event->setRenderHTML($html);
        $event->notify();

        // достаем новый $html
        $html = $event->getRenderHTML();

        return $html;
    }

    /**
     * Получить объект Engine_ContentDriver'a
     *
     * @author DFox
     * @return Engine_ContentDriver
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    /**
     * @var Engine_ContentDriver
     */
    private static $_Instance = null;

    /**
     * Массив созданных контентов
     * array of Engine_Content
     *
     * @var array
     */
    private $_contentsArray = array();

}