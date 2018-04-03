<?php
class issue_add_workflow_preview extends Engine_Class {

    public function process() {
        try {
            $workflow = Shop::Get()->getShopService()->getOrderCategoryByID(
            $this->getArgument('workflowid')
            );

            $block = Engine::GetContentDriver()->getContent('issue-workflow-preview');
            $block->setValue('workflow', $workflow);

            echo json_encode(array('userid' => $workflow->getManagerid(), 'html' => $block->render()));
            exit();
        } catch (Exception $ge) {

        }
    }

}