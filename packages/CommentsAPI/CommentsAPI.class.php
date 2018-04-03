<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.com.ua>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU LESSER GENERAL PUBLIC LICENSE
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 */

/**
 * CommentsAPI - самое базовое линейное API для комментариев.
 * Реализовано по паттерну singleton, т.е. наследование запрещено.
 *
 * CommentsAPI предназначен для инкапсуляции (аггрегации) в другие сервисы
 * и классы.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package CommentsAPI
 */
class CommentsAPI {

    private $_classnameComments = 'CommentsAPI_XComment';

    /**
     * Задать имя класса, которым будет оперировать CommentsAPI.
     * По умолчанию CommentsAPI_XComment
     *
     * @param string $classname
     */
    public function setClassnameCommens($classname) {
        $this->_classnameComments = $classname;
    }

    /**
     * Получить все комментарии по ключу
     *
     * @return CommentsAPI_XComment
     * @param string $key
     */
    public function getComments($key = false) {
        $classname = $this->_classnameComments;
        $x = new $classname();
        if ($key) {
            $x->setKey($key);
        }
        $x->setOrder('cdate', 'ASC');
        return $x;
    }

    /**
     * Добавить комментарий.
     * Обязательных полей, кроме комментария ($content) - нет.
     *
     * Если вам нужны проверки полей - инкапсулируйте CommentsAPI
     * в свой класс(-сервис) и описывайте проверки самостоятельно.
     *
     * @param string $key
     * @param string $content
     * @param int $userID
     * @param int $sessionID
     * @param int $ip
     * @return CommentsAPI_XComment
     */
    public function addComment($key, $content, $userID = false, $sessionID = false, $ip = false) {
        $content = trim($content);
        if (!$content) {
            throw new CommentsAPI_Exception();
        }

        $classname = $this->_classnameComments;
        $x = new $classname();
        $x->setKey($key);
        $x->setId_user($userID);
        $x->setSessionid($sessionID);
        $x->setIp($ip);
        $x->setContent($content);
        $x->setCdate(date('Y-m-d H:i:s'));
        $x->insert();

        return $x;
    }

    /**
     * Удалить все комментарии по ключу
     *
     * @param string $key
     */
    public function deleteComments($key) {
        try {
            SQLObject::TransactionStart();

            $comments = $this->getComments($key);
            while ($x = $comments->getNext()) {
            	$x->delete();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    private static $_Instance = null;

    /**
     * Получить CommentsAPI
     *
     * @return CommentsAPI
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

}