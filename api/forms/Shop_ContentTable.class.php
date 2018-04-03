<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ContentTable extends Forms_ContentTable {

    public function __construct($datasource) {
        parent::__construct($datasource);
        $this->getStepper()->setFileHTML(dirname(__FILE__).'/Shop_ContentTable_Stepper.html');
        $this->getStepper()->setTranslateArray(Shop::Get()->getTranslateService()->getTranslateArray());
        $this->setFileHTML(dirname(__FILE__).'/Shop_ContentTable.html');
        $this->setCSSClassName('shop-table');

        $this->setRow(new Shop_ContentTableRow());

        $filter = Engine::GetContentDriver()->getContent('datasource-filter');
        $filter->setValue('datasource', $datasource);
        $this->setValue('filter', $filter->render());
        $this->_makeVisibleFildsArray();
    }



    public function makeFiltersArray() {
        $operationsArray = array();
        $operationsArray[] = 'equals';
        $operationsArray[] = 'lt';
        $operationsArray[] = 'gt';
        $operationsArray[] = 'lte';
        $operationsArray[] = 'gte';
        $operationsArray[] = 'search'; // like
        $operationsArray[] = 'searchstart'; // like starts
        $operationsArray[] = 'searchend'; // like ends

        $filtersArray = array();
        $filtersSavesArray = array();
        $arguments = Engine::GetURLParser()->getArguments();

        // получаем connection для escape-функции
        $connection = ConnectionManager::Get()->getConnectionDatabase();

        foreach ($arguments as $k => $v) {
            // массив только по фильтрам
            if (preg_match('/^filter(\d+)_/uis', $k)) {
                $filtersSavesArray[$k] = $v;
            }

            if (preg_match('/^filter(\d+)_key$/uis', $k, $r)) {
                try {
                    $key = $v;
                    $type = @$arguments['filter'.$r[1].'_type'];
                    $value = @$arguments['filter'.$r[1].'_value'];

                    if (!in_array($type, $operationsArray)) {
                        $type = $operationsArray[0];
                    }

                    // пропускаем пустые значения
                    if ($value === '' || $value === false) {
                        continue;
                    }

                    // @todo: переписать на обработчики
                    // @todo: refactoring

                    if ($type == 'equals') {
                        $field = $this->getDataSource()->getField($key);
                        if ($field instanceof Forms_ContentFieldInt
                        || $field instanceof Forms_ContentFieldNumeric
                        ) {
                            $value = (float) $value;
                        } else {
                            $value = $connection->escapeString($value);
                            $value = "'{$value}'";
                        }

                        $filter = new Forms_FilterObject(
                        $key,
                        "= $value",
                        true
                        );
                    } elseif ($type == 'lt') {
                        $field = $this->getDataSource()->getField($key);
                        if ($field instanceof Forms_ContentFieldInt
                        || $field instanceof Forms_ContentFieldNumeric
                        ) {
                            $value = (float) $value;
                        } elseif ($field instanceof Forms_ContentFieldDatetime) {
                            $value = DateTime_Corrector::CorrectDateTime($value);
                            $value = "'{$value}'";
                        } else {
                            $value = $connection->escapeString($value);
                            $value = "'{$value}'";
                        }

                        $filter = new Forms_FilterObject(
                        $key,
                        "<= $value",
                        true
                        );
                    } elseif ($type == 'lte') {
                        $field = $this->getDataSource()->getField($key);
                        if ($field instanceof Forms_ContentFieldInt
                        || $field instanceof Forms_ContentFieldNumeric
                        ) {
                            $value = (float) $value;
                        } elseif ($field instanceof Forms_ContentFieldDatetime) {
                            $value = DateTime_Corrector::CorrectDateTime($value);
                            $value = "'{$value}'";
                        } else {
                            $value = $connection->escapeString($value);
                            $value = "'{$value}'";
                        }

                        $filter = new Forms_FilterObject(
                        $key,
                        "<= $value",
                        true
                        );
                    } elseif ($type == 'gt') {
                        $field = $this->getDataSource()->getField($key);
                        if ($field instanceof Forms_ContentFieldInt
                        || $field instanceof Forms_ContentFieldNumeric
                        ) {
                            $value = (float) $value;
                        } elseif ($field instanceof Forms_ContentFieldDatetime) {
                            $value = DateTime_Corrector::CorrectDateTime($value);
                            $value = "'{$value}'";
                        } else {
                            $value = $connection->escapeString($value);
                            $value = "'{$value}'";
                        }

                        $filter = new Forms_FilterObject(
                        $key,
                        "> $value",
                        true
                        );
                    } elseif ($type == 'gte') {
                        $field = $this->getDataSource()->getField($key);
                        if ($field instanceof Forms_ContentFieldInt
                        || $field instanceof Forms_ContentFieldNumeric
                        ) {
                            $value = (float) $value;
                        } elseif ($field instanceof Forms_ContentFieldDatetime) {
                            $value = DateTime_Corrector::CorrectDateTime($value);
                            $value = "'{$value}'";
                        } else {
                            $value = $connection->escapeString($value);
                            $value = "'{$value}'";
                        }

                        $filter = new Forms_FilterObject(
                        $key,
                        ">= $value",
                        true
                        );
                    } elseif ($type == 'search') {
                        $value = str_replace(' ', '%', $value);

                        $filter = new Forms_FilterObject(
                        $key,
                        "LIKE '%".$connection->escapeString($value)."%'",
                        true
                        );
                    } elseif ($type == 'searchstart') {
                        $value = str_replace(' ', '%', $value);

                        $filter = new Forms_FilterObject(
                        $key,
                        "LIKE '".$connection->escapeString($value)."%'",
                        true
                        );
                    } elseif ($type == 'searchend') {
                        $value = str_replace(' ', '%', $value);

                        $filter = new Forms_FilterObject(
                        $key,
                        "LIKE '%".$connection->escapeString($value)."'",
                        true
                        );
                    }

                    $filtersArray[] = $filter;
                } catch (Exception $filterException) {

                }
            }
        }

        $tablelike = Engine::GetURLParser()->getArgumentSecure('tablelike');
        if ($tablelike) {
            $filter = new Forms_FilterObject(
            'tablelike',
            $tablelike,
            true
            );
            $filtersArray[] = $filter;
        }

        // сохраняем фильтр в сессию/COOKIE
        $_SESSION['filters'.Engine::Get()->getRequest()->getContentID()] = serialize($filtersSavesArray);

        return $filtersArray;
    }

    public function render($assignsArray = array()) {
        // прячим лишние колонки
        $datasource = $this->getDataSource();
        $datasourceName = get_class($datasource);
        $user = Shop::Get()->getUserService()->getUser();

        $fieldsArray = $this->getFieldsArray();
        foreach ($fieldsArray as $field) {
            try {
                if (isset($this->_visibleFildsArray[$field->getKey()])
                    && !$this->_visibleFildsArray[$field->getKey()]
                    && $field->getKey() != $datasource->getFieldPrimary()->getKey()
                ) {
                    $this->removeField($field->getKey());
                }
            } catch (Exception $e) {

            }
        }

        $this->setTranslateArray(Shop::Get()->getTranslateService()->getTranslateArray());

        $result = parent::render();

        return $result;
    }

    /**
     * Получить количество строк на одной странице
     *
     * @return int
     */
    public function getLinesOnPage() {
        // пытаемся достать параметр из COOKIE
        $rowsCount = (int) @$_COOKIE['rowscount_'.get_class($this->getDataSource())];
        if (!$rowsCount && $rowsCount <= 0) {
            return 50;
        }
        if ($rowsCount <= 10) {
            $rowsCount = 10;
        }
        if ($rowsCount >= 100) {
            $rowsCount = 100;
        }
        return $rowsCount;
    }

    /**
     * Записываем в масив видимость колонок
     */
    private function _makeVisibleFildsArray() {
        $user = Shop::Get()->getUserService()->getUser();
        $link = new XShopTableColumn();
        $link->setUserid($user->getId());
        $link->setDatasource(get_class($this->getDataSource()));
        while ($x = $link->getNext())
            $this->_visibleFildsArray[$x->getKey()] = $x->getVisible();
    }
    private $_visibleFildsArray = array();

}