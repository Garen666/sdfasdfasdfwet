<?php
class workflow_status_edit extends Engine_Class {

    public function process() {
        try {
            $isBox = Engine::Get()->getConfigFieldSecure('project-box');
            $this->setValue('box', $isBox);

            $status = Shop::Get()->getShopService()->getStatusByID($statusID =
            $this->getArgument('id')
            );
            $this->setValue('statusid',$statusID);

            $category = $status->getCategory();

            // сохранение формы
            if ($this->getArgumentSecure('send_edit')) {
                try {
                    Shop::Get()->getShopService()->editStatus(
                    $status,
                    $this->getControlValue('name'),
                    $this->getControlValue('description'),
                    $this->getControlValue('term'),
                    $this->getControlValue('period'),
                    $this->getControlValue('roleid'),
                    $this->getControlValue('managerid'),
                    $this->getControlValue('jumpmanager'),
                    $this->getControlValue('colour'),
                    $this->getControlValue('smart'),
                    $this->getControlValue('onlyauto'),
                    $this->getControlValue('onlyissue'),
                    $this->getControlValue('notify_sms_client'),
                    $this->getControlValue('notify_sms_admin'),
                    $this->getControlValue('notify_sms_manager'),
                    $this->getControlValue('notify_email_client'),
                    $this->getControlValue('notify_email_admin'),
                    $this->getControlValue('notify_email_manager'),
                    $this->getControlValue('need_payment'),
                    $this->getControlValue('need_prepayment'),
                    $this->getControlValue('need_content'),
                    $this->getControlValue('need_document'),
                    $this->getControlValue('closed'),
                    $this->getControlValue('saled'),
                    $this->getControlValue('shipped'),
                    $this->getControlValue('autorepeat_period'),
                    $this->getControlValue('autorepeat_term'),
                    $this->getControlValue('storage_incoming'),
                    $this->getControlValue('storagenameid_incoming'),
                    $this->getControlValue('storage_sale'),
                    $this->getControlValue('storage_reserve'),
                    $this->getControlValue('storage_unreserve'),
                    $this->getControlValue('storage_return'),
                    $this->getControlValue('orderSupplier')
                    );

                    $status->setMessage($this->getControlValue('text_notify_email_client'));
                    $status->setMessageadmin($this->getControlValue('text_notify_email_admin'));
                    $status->setSms($this->getControlValue('text_notify_sms_client'));
                    $status->setSmsadmin($this->getControlValue('text_notify_sms_admin'));

                    for ($j = 1; $j <= 10; $j++) {
                        try {
                            $subWorkflowID = $this->getArgument('subworkflow'.$j);
                            $subWorkflowName = $this->getArgument('subworkflow'.$j.'name');

                            $status->setField('subworkflow'.$j, $subWorkflowID);
                            $status->setField('subworkflow'.$j.'name', $subWorkflowName);
                            $status->update();
                        } catch (Exception $subEx) {

                        }
                    }

                    $this->setValue('edit_ok', true);
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('error_edit', $e->getErrors());
                }
            }

            $this->setControlValue('name', htmlspecialchars($status->getName()));
            $this->setControlValue('colour', $status->getColour());
            $this->setControlValue('smart', $status->getSmart());

            $this->setControlValue('notify_sms_client', $status->getNotifysmsclient());
            $this->setControlValue('notify_sms_admin', $status->getNotifysmsadmin());
            $this->setControlValue('notify_sms_manager', $status->getNotifysmsmanager());
            $this->setControlValue('notify_email_client', $status->getNotifyemailclient());
            $this->setControlValue('notify_email_admin', $status->getNotifyemailadmin());
            $this->setControlValue('notify_email_manager', $status->getNotifyemailmanager());

            $this->setControlValue('text_notify_email_client', $status->getMessage());
            $this->setControlValue('text_notify_email_admin', $status->getMessageadmin());
            $this->setControlValue('text_notify_sms_client', $status->getSms());
            $this->setControlValue('text_notify_sms_admin', $status->getSmsadmin());

            $this->setControlValue('closed', $status->getClosed());
            $this->setControlValue('saled', $status->getSaled());
            $this->setControlValue('shipped', $status->getShipped());
            if ($status->getCancelOrderSupplier()) {
                $this->setControlValue('orderSupplier', 'cancel');
            } elseif ($status->getCreateOrderSupplier()) {
                $this->setControlValue('orderSupplier', 'create');
            }


            if (Shop_ModuleLoader::Get()->isImported('storage')) {
                $this->setValue('storage', 1);
                $this->setControlValue('storagenameid_incoming', $status->getStoragenameid_incoming());
                $this->setControlValue('storage_incoming', $status->getStorage_incoming());
                $this->setControlValue('storage_sale', $status->getStorage_sale());
                $this->setControlValue('storage_reserve', $status->getStorage_reserve());
                $this->setControlValue('storage_unreserve', $status->getStorage_unreserve());
                $this->setControlValue('storage_return', $status->getStorage_return());

                $storageNamesIncoming = StorageNameService::Get()->getStorageNamesForTransfers();
                $storageNameIncomingArray = array();
                while ($storageNameIncoming = $storageNamesIncoming->getNext()) {
                    $storageNameIncomingArray[] = array(
                    'id' => $storageNameIncoming->getId(),
                    'name' => $storageNameIncoming->getName()
                    );
                }
                $this->setValue('storageNameIncomingArray', $storageNameIncomingArray);

                $storageName = StorageNameService::Get()->getStorageNamesForSale()->getNext();
                if ($storageName) {
                    $this->setValue('storageName', $storageName->getName());
                }
            }

            $this->setValue('name', htmlspecialchars($status->getName()));
            $this->setValue('categoryid', $category->getId());
            $this->setValue('categoryName', $category->makeName());
            $this->setValue('issue', $category->getIssue());







            if ($isBox) {
                $this->setControlValue('description', htmlspecialchars($status->getContent()));

                $this->setControlValue('term', $status->getTerm());

                $this->setControlValue('roleid', $status->getRoleid());
                $this->setControlValue('period', $status->getTermperiod());

                $this->setControlValue('jumpmanager', $status->getJumpmanager());
                $this->setControlValue('managerid', $status->getManagerid());

                $this->setControlValue('onlyauto', $status->getOnlyauto());
                $this->setControlValue('onlyissue', $status->getOnlyissue());
                $this->setControlValue('need_payment', $status->getPayed());
                $this->setControlValue('need_prepayment', $status->getPrepayed());
                $this->setControlValue('need_content', $status->getNeedcontent());
                $this->setControlValue('need_document', $status->getNeeddocument());
                $this->setControlValue('autorepeat_period', $status->getAutorepeatperiod());
                $this->setControlValue('autorepeat_term', $status->getAutorepeatterm());

                $a = array();
                $b = array();
                for ($j = 1; $j <= 10; $j++) {
                    $a[$j] = $status->getField('subworkflow'.$j);
                    $b[$j] = $status->getField('subworkflow'.$j.'name');
                }
                $this->setValue('subworkflowArray', $a);
                $this->setValue('subworkflowNameArray', $b);

                // список workflow
                $workflow = Shop::Get()->getShopService()->getOrderCategoryAll();
                $a = array();
                while ($x = $workflow->getNext()) {
                    $a[$x->getId()] = $x->makeName();
                }
                $this->setValue('workflowArray', $a);

                // список менеджеров
                $a = array();
                $manager = Shop::Get()->getUserService()->getUsersManagers();
                while ($x = $manager->getNext()) {
                    $a[] = array(
                        'id' => $x->getId(),
                        'name' => $x->makeName(true, 'lfm'),
                    );
                }
                $this->setValue('managerArray', $a);

                // список ролей
                $this->setValue('roleArray', RoleService::Get()->makeRoleListArray());
            }
        } catch (Exception $e) {
            print $e;
        }
    }

}