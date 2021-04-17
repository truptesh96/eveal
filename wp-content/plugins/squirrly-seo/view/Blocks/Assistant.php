<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php $page = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', '')); ?>
<div class="card-text">
    <div id="sq_assistant_<?php echo esc_attr($page) ?>" class="sq_assistant">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->getAssistant($page); ?>
    </div>

    <div class="border my-1"></div>

    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockKnowledgeBase')->init(); ?>
</div>