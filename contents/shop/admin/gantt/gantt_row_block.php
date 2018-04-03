<?php
class gantt_row_block extends Engine_Class {

    public function process() {
        $parentID = $this->getValue('parentid');
        $issue = $this->getValue('issue');
        $dateFrom = $this->getValue('dateFrom');
        if (!$issue) {
            $issue = IssueService::Get()->getIssuesAll($this->getUser());
            $issue->setOrder('id', 'ASC');
        } else {
            $issue = clone $issue;
        }
        if ($parentID) {
            $issue->setParentid($parentID);
        }

        $a = array();
        while ($x = $issue->getNext()) {
            $issueStart = $x->getCdate();
            $issueEnd = $x->getDateto();
            $issueClosed = $x->getDateclosed();

            $allowEdit = true;

            // если есть внутренние задачи - то start не может быть позже
            // а завершение раньше внутренних
            $childs = IssueService::Get()->getIssuesAll();
            $childs->setParentid($x->getId());
            while ($child = $childs->getNext()) {
                $allowEdit = false;

                if (Checker::CheckDate($child->getCdate()) && $child->getCdate() < $issueStart) {
                    $issueStart = $child->getCdate();
                }

                if (Checker::CheckDate($child->getDateto()) && $child->getDateto() > $issueEnd) {
                    $issueEnd = $child->getDateto();
                }
            }

            $issueStart = DateTime_Formatter::DateISO9075($issueStart);
            $issueEnd = DateTime_Formatter::DateISO9075($issueEnd);
            $issueClosed = DateTime_Formatter::DateISO9075($issueClosed);

            $startDay = 0;
            $width = 0;
            try {
                $color = $x->getStatus()->getColour();
                $statusName = $x->getStatus()->getName();
            } catch (Exception $colorEx) {
                $statusName = false;
                $color = false;
            }

            if (!$color) {
                $color = 'lightgreen';
            }

            // если нет даты завершения - считать это 1 день
            // (для старых задач)
            if (!Checker::CheckDate($issueEnd)) {
                // если есть реальная дата закрытия
                // - то считаем что задача перлась аж сюда
                if (Checker::CheckDate($issueClosed)) {
                    $issueEnd = $issueClosed;
                } else {
                    $issueEnd = $issueStart;
                }
            }

            if (Checker::CheckDate($issueStart)) {
                // нужно посчитать начиная с какой ячейки красить
                $startDay = DateTime_Differ::DiffDay($issueStart, $dateFrom);

                // и какой длинны будет полоска
                $width = DateTime_Differ::DiffDay($issueEnd, $issueStart) + 1;

                // просрочили задачу
                if ($issueEnd < date('Y-m-d')) {
                    //$color = 'red';
                }
            }

            if ($width <= 0) {
                $startDay = 0;
                $width = 1;
                $color = 'gray';
            }

            if ($startDay < 0) {
                $width -= -$startDay;
                $startDay = 0;
            }

            if ($x->isClosed()) {
                $color = 'lightgray';
            }

            if (!$allowEdit) {
                $color = 'lightgray';
            }

            $block = Engine::GetContentDriver()->getContent('gantt-row-block');
            $block->setValue('parentid', $x->getId());
            $block->setValue('issue', false);

            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'url' => $x->makeURLEdit(),
            'startDay' => $startDay,
            'width' => $width * 20, // x20px
            'left' => $startDay * 20, // x20px
            'color' => $color,
            'status' => $statusName,
            'block_row' => $block->render(),
            'allowEdit' => $allowEdit,
            );
        }
        $this->setValue('issueArray', $a);
    }

}