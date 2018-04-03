<?php

class jQueryUI_Loader implements PackageLoader_ILoader {

    public function __construct($paramsArray) {
        if (!empty($paramsArray[0])) {
            $cssClass = $paramsArray[0];
            $cssClass = str_replace(' ', '-', strtolower($cssClass));
        } else {
            $cssClass = 'smoothness';
        }

        if (!file_exists(dirname(__FILE__)."/css/$cssClass/jquery-ui-1.9.0.custom.css")) {
            throw new PackageLoader_Exception("incorrect jQueryUI theme \"$cssClass\"");
        }

        PackageLoader::Get()->registerCSSFile(dirname(__FILE__)."/css/$cssClass/jquery-ui-1.9.0.custom.css", true);
        PackageLoader::Get()->registerJSFile(dirname(__FILE__)."/jquery-ui-1.9.0.min.js", true);
    }
}