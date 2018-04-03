<?php
class structure_index extends Engine_Class {

    public function process() {
        $block = Engine::GetContentDriver()->getContent('structure-block');
        $block->setValue('parentid', 0);
        $this->setValue('block_structure', $block->render());
    }

}