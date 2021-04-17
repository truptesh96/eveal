<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php
SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap-reboot');
SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap');
SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fontawesome');
SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('global');
SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('navbar');
?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">

                <div class="col-12 p-0">
                    <div class="col-12 px-2 py-3 text-center" >
                        <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/noconnection.jpg' ?>" style="width: 300px">
                    </div>
                    <div id="sq_error" class="card col-12 p-0 tab-panel border-0">
                        <div class="col-12 alert alert-success text-center m-0 p-3"><i class="fa fa-exclamation-triangle" style="font-size: 18px !important;"></i> <?php echo sprintf(esc_html__("There is a connection error with Squirrly Cloud. Please check the connection and %srefresh the page%s.", _SQ_PLUGIN_NAME_),'<a href="javascript:void(0);" onclick="location.reload();" >','</a>')?></div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
