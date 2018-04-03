<?php
Engine::GetContentDataSource()->registerContent('shop-help', array(
'url' => array('/help/', '/help/{file}/'),
'filehtml' => dirname(__FILE__).'/help_index.html',
'filephp' => dirname(__FILE__).'/help_index.php',
'filecss' => dirname(__FILE__).'/help_index.css',
'moveto' => 'shop-tpl',
'moveas' => 'content',
), 'override');