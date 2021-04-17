<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * Uninstall Options
 */
class SQ_Controllers_Uninstall extends SQ_Classes_FrontController {

    public function hookHead() {
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('uninstall');
    }

    public function hookFooter() {
        echo $this->getView('Blocks/Uninstall');
    }
}
