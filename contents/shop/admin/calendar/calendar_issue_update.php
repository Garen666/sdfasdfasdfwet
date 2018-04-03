<?php
class calendar_issue_update extends Engine_Class {

    public function process() {
        try {
            $issue = IssueService::Get()->getIssueByID(
            $this->getArgument('id')
            );

            $employerId = $this->getArgumentSecure('employerId');

            // открыть или закыть задачу
            try {
                $status = $this->getArgument('status', 'bool');

                if ($status) {
                    // закрыть задачу
                    $status = $issue->getWorkflow()->getStatusClosed();
                } else {
                    // открыть задачу
                    $status = $issue->getWorkflow()->getStatusDefault();
                }

                // обновляем задачу
                Shop::Get()->getShopService()->updateOrderStatus(
                $this->getUser(),
                $issue,
                $status->getId()
                );
            } catch (Exception $e) {

            }

            // переместить задачу на другую дату
            // перемещается due date
            try {
                $date = $this->getArgument('date');
                $time = DateTime_Object::FromString($issue->getDateto())->setFormat('H:i:s')->__toString();
                $date = DateTime_Formatter::DateISO9075($date).' '.$time;

                if ($employerId) {
                    $employer = new XShopOrderEmployer($employerId);
                    $employer->setTerm($date);
                    $employer->update();
                } else {
                    $issue->setDateto($date);
                    $issue->update();
                }

            } catch (Exception $e) {

            }

            // переместить задачу на другое время
            // перемещается due date
            try {
                $time = $this->getArgument('time');
                $date = DateTime_Formatter::DateISO9075($issue->getDateto()).' '.$time;

                if ($employerId) {
                    $employer = new XShopOrderEmployer($employerId);
                    $employer->setTerm($date);
                    $employer->update();
                } else {
                    $issue->setDateto($date);
                    $issue->update();
                }
            } catch (Exception $e) {

            }
        } catch (Exception $ge) {
            print $ge;
            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}