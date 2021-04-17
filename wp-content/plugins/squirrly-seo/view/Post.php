<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php
SQ_Classes_RemoteController::loadJsVars();
SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('slaseo', array('trigger' => true, 'media' => 'all'));
SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('slasearch', array('trigger' => true, 'media' => 'all'));

echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init();

echo $view->getView('Blocks/SLASearch');
echo $view->getView('Blocks/SLASeo');
