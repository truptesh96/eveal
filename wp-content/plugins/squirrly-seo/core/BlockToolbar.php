<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockToolbar extends SQ_Classes_BlockController {

    function init() {
        echo $this->getView('Blocks/Toolbar');
    }

}
