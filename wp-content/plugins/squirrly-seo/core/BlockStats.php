<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockStats extends SQ_Classes_BlockController {
    var $stats = array();

    function init() {
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('global');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('stats');

        parent::init();

        $dbtasks = json_decode(get_option(SQ_TASKS), true);
        if(isset($dbtasks['sq_stats'])) {
            $this->stats = $dbtasks['sq_stats'];

            echo $this->getView('Blocks/Stats');
        }
    }

}
