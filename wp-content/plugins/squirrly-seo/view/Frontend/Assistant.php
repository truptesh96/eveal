<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<style>
    body ul.sq_notification {
        top: 4px !important;
    }
    #postsquirrly {
        display: none;
    }

    .components-squirrly-icon{
        display: none;
        position: fixed;
        right: 20px;
        bottom: 10px;
        z-index: 10;
        border: 1px solid #999;
        margin: 0 !important;
        padding: 3px;
        cursor: pointer;
    }
    #sq_blocksearch #sq_types,
    #sq_blocksearch #sq_search_img_filter,
    #sq_blocksearch .sq_search{
        display: none !important;
    }
</style>
<div id="postsquirrly" class="sq_sticky sq_frontend">
    <?php if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') { ?>
        <div class="sq_frontend_noapi">
            <div class="sq_frontend_noapi_inner">
                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>">
                    <img src="<?php echo _SQ_ASSETS_URL_ . 'img/editor/sla.png'; ?>"/>
                </a>
            </div>
            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>"><?php echo esc_html__("To load Squirrly Live Assistant and optimize this page, click to connect to Squirrly Data Cloud.", _SQ_PLUGIN_NAME_); ?></a>
        </div>
    <?php } else { ?>
        <?php SQ_Classes_RemoteController::loadJsVars(); ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
        <?php echo $view->getView('Blocks/SLASearch'); ?>
        <?php echo $view->getView('Blocks/SLASeo'); ?>
    <?php } ?>
</div>
<?php SQ_Classes_RemoteController::loadJsVars(); ?>
