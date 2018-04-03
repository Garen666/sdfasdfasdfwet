<?php
class imagecropper_include extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jquery.imgareaselect.pack.js');
        PackageLoader::Get()->registerCSSFile('/_css/imgareaselect-default.css');
    }

}