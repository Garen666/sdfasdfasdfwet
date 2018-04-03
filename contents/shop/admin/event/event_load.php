<?php
class event_load extends Engine_Class {

    public function process() {
        try {
            $event = new ShopEvent($this->getArgument('id'));

            if ($event->getType() != 'call') {
                throw new ServiceUtils_Exception();
            }

            $fileSound = '/media/call/';
            $fileSound .= $event->getFile();

            $fileSound_local = PackageLoader::Get()->getProjectPath().$fileSound;

            if (!file_exists($fileSound_local)) {
                // загружаем файл по FTP

                $a = explode('/', $event->getFile());
                unset($a[count($a)-1]);
                @mkdir(PackageLoader::Get()->getProjectPath().'media/call/'.implode('/', $a), 0755, true);

                if (!isset($parser)) {
                    try {
                        $parser = Engine::Get()->getConfigField('project-box-event-call-ftp');
                    } catch (Exception $parserEx) {

                    }
                }
                if (!isset($parser)) {
                    $parser = Engine::Get()->getConfigField('project-box-event-parser-call');
                }

                $ftpHost = $parser['host'];
                $ftpLogin = $parser['login'];
                $ftpPassword = $parser['password'];
                $ftpPort = $parser['port'];
                $ftpPath = @$parser['path'];

                if (!$ftpPort) {
                    $ftpPort = 21;
                }

                $ftp = ftp_connect($ftpHost, $ftpPort, 10);
                ftp_pasv($ftp, true);
                ftp_login($ftp, $ftpLogin, $ftpPassword);

                @ftp_get($ftp, $fileSound_local, $ftpPath.$event->getFile(), FTP_BINARY);

                ftp_close($ftp);
            }

            if (file_exists($fileSound_local)) {
                $this->setValue('fileSound', $fileSound);
                $this->setValue('id', $event->getId());
            }

        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::GetQuery()->setContentNotFound();
        }
    }

}