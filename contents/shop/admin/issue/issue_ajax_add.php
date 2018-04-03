<?php
class issue_ajax_add extends Engine_Class {

    public function process() {
        try {
            // если не указано "Выполнить до", то берем дату на которую создавали
            $dateto = $this->getArgumentSecure('dateto');
            if (!$dateto || $dateto == '0000-00-00 00:00:00') {
                $dateto = $this->getArgumentSecure('date');
            }
            // создаем задачу
            $issue = IssueService::Get()->addIssue(
                $this->getUser(),
                $this->getArgumentSecure('name'),
                $this->getArgumentSecure('description'),
                $this->getArgumentSecure('managerid'),
                $this->getArgumentSecure('workflowid'), // workflow
                $dateto, // due date
                false, // clientid
                $this->getArgumentSecure('parentid') // parentid
            );

            echo json_encode(array("id" => $issue->getId(), "name" => $issue->makeName(), "url" => $issue->makeURLEdit(), "smart" => $smartContent));
            exit();
        } catch (ServiceUtils_Exception $e) {
            foreach ($e->getErrorsArray() as $ex) {
                if ($ex == 'workflow') {
                    echo json_encode(array("name" => 'Невозможно создать задачу. Добавьте бизнес-процесс по умолчанию.', "error" => 1));
                    exit();
                }

            }
            echo json_encode(array("name" => 'Невозможно создать задачу.', "error" => 1));
            exit();

        }


    }

}