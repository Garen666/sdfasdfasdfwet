<?php
class calendar_block_load_ajax extends Engine_Class {

    public function process() {
        $argumentArray = $this->getArgumentSecure('arguments', 'array');
        $whereArray = $this->getArgumentSecure('where', 'array');

        // получаем задачи
        $issues = IssueService::Get()->getIssuesAll($this->getUser());
        
        // фильтруем задачи согласно переданным аргументам и where
        foreach ($argumentArray as $argument) {
            if (isset($argument['value'])) {
                $issues->filterField($argument['name'], $argument['value']);
            }
        }

        $connection = ConnectionManager::Get()->getConnectionDatabase();

        foreach ($whereArray as $where) {
            if (isset($where['value'])) {
                $query = $connection->escapeString($where['value']);
                $issues->addWhereQuery($query);
            }
        }

        // Календарь
        $render = Engine::GetContentDriver()->getContent('calendar-block');
        $render->setValue('issue', $issues);
        echo $render->render();
    }

}