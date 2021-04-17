<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_focuspages')) {
            echo '<div class="col-12 alert alert-success text-center m-0 p-3">'. esc_html__("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_).'</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'settings'), 'sq_focuspages'); ?>
        <div class="sq_row d-flex flex-row bg-white px-3">
            <div class="flex-grow-1 px-1 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons_content p-3 py-4">
                            <div class="sq_icons sq_settings_icon m-2"></div>
                        </div>
                        <h3 class="card-title"><?php echo esc_html__("Focus Pages Settings", _SQ_PLUGIN_NAME_); ?></h3>
                        <div class="card-title-description m-2"></div>
                    </div>
                    <div id="sq_focuspages" class="card col-12 p-0 tab-panel border-0">
                        <div class="card-body p-0">
                            <div class="col-12 m-0 p-0">
                                <div class="card col-12 my-4 p-0 border-0 ">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sq_col sq_col_side ">
                <div class="card col-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
