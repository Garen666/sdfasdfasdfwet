<?php
class FilterService extends ServiceUtils_AbstractService {

    /**
     * @param $id
     * @return XGameFilter
     * @throws ServiceUtils_Exception
     */
    public function getFilterByID($id) {
        return $this->getObjectByID($id, 'XGameFilter');
    }

}