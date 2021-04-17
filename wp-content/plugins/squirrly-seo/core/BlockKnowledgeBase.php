<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockKnowledgeBase extends SQ_Classes_BlockController {

    public function init(){
        echo $this->getView('Blocks/KnowledgeBase');
    }
}
