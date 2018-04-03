<?php
class users_issue extends Engine_Class {

    public function process() {
        try {
            $user = Shop::Get()->getUserService()->getUserByID(
            $this->getArgument('id')
            );

            if (!Shop::Get()->getUserService()->isUserViewAllowed($user, $this->getUser())) {
                throw new ServiceUtils_Exception('user');
            }

            $menu = Engine::GetContentDriver()->getContent('shop-admin-users-menu');
            $menu->setValue('selected', 'issue');
            $menu->setValue('userid', $user->getId());
            $this->setValue('menu', $menu->render());

            Engine::GetHTMLHead()->setTitle('Задачи '.$user->makeName());

            // задачи
            $issues = IssueService::Get()->getIssuesAll($this->getUser());
            $issues->addWhereQuery("(authorid={$user->getId()} OR userid={$user->getId()} OR managerid={$user->getId()})");

            $list = Engine::GetContentDriver()->getContent('issue-list');
            try {
                $this->getArgument('filtershowclosed');
            } catch (Exception $e) {
                Engine::GetURLParser()->setArgument('filtershowclosed', true);
            }
            $list->setValue('issues', $issues);
            $this->setValue('block_issue', $list->render());

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}