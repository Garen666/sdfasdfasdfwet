<?php
class event_download extends Engine_Class {

    public function process() {
        try {
            $file = new XShopEventAttachment(
            $this->getArgument('id')
            );

            if (!$file->getId()) {
                throw new ServiceUtils_Exception();
            }

            // @todo: check ACL

            $filePath = PackageLoader::Get()->getProjectPath().'media/email/'.$file->getFile();
            if (!file_exists($filePath)) {
                throw new ServiceUtils_Exception();
            }

            $name = $file->getName();
            if (!$name) {
                $name = 'file-'.$file->getId();
            }

            $size = @filesize($filePath);

            header('Content-Type: '.$file->getContenttype());
            if (!substr_count($file->getContenttype(), 'image/')) {
                // заставляем браузер показать окно сохранения файла
                header('Content-Description: File Transfer');
                header('Content-Disposition: attachment; filename=' . $name);
                header('Content-Transfer-Encoding: binary');
            }

            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            if ($size) {
                header('Content-Length: ' . $size);
            }
            // читаем файл и отправляем его пользователю
            readfile($filePath);
            exit();
        } catch (Exception $ge) {
            Engine::GetQuery()->setContentNotFound();
        }
    }

}