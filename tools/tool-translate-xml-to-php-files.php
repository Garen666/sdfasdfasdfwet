<?php

include_once dirname(__FILE__).'/../packages/Engine/include.2.6.php';
$convert = new Convert();
$convert->StartConvert();

Class Convert {

    public function __construct() {

    }

    private $_convertFilesArray = array();
    public function StartConvert() {
        $dirsArray = $this->_getDirArray();

        foreach ($dirsArray as $dir) {
            $this->getXmlFilesArrayInDir($dir);
        }

        foreach ($this->_convertFilesArray as $filePath) {
            $this->convertXmlToPhpFile($filePath);
        }
    }

    private function convertXmlToPhpFile ($filePath) {
        $data = file_get_contents($filePath);
        $xml = (array) simplexml_load_string($data);

        $text = "<?php";
        $text .= "\n\n";
        $text .= '$translate = array();';
        $text .= "\n";
        foreach ($xml as $key => $value) {
            $key = trim($key.'');

            if (is_array($value)) {
                $v = $value[0].'';
            } else {
                $v = $value.'';
            }

            $v = str_replace('"', '\"', $v);

            $text .= '$translate["'.$key.'"] = "'.$v.'";'."\n";
        }
        file_put_contents(str_replace('.xml', '.php', $filePath), $text);
    }

    private function _getDirArray () {
        $rootPath = PackageLoader::Get()->getProjectPath();

        return array (
            $rootPath.'/media/translate/',
            $rootPath.'/packages/DateTime/translate/',
            $rootPath.'/packages/Forms/translate/',
        );
    }

    function getXmlFilesArrayInDir($dir) {
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($this->getExtension($file) == 'xml') {
                        $this->_convertFilesArray[] = $dir.$file;
                    }
                }
                closedir($dh);
            }
        }
    }

    private function getExtension($filename) {
        return substr(strrchr($filename, '.'), 1);
    }
}


