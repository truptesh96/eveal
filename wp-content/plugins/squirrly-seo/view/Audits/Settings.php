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
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_audits'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">
                <div class="form-group my-4 col-10 offset-1">
                    <?php echo $view->getView('Connect/GoogleAnalytics'); ?>
                    <?php echo $view->getView('Connect/GoogleSearchConsole'); ?>
                </div>

                <form method="POST">
                    <?php do_action('sq_form_notices'); ?>
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_audits_settings', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_audits_settings"/>

                    <div class="card col-12 p-0">
                        <div class="card-body p-0 m-0 bg-title rounded-top row">
                            <div class="card-body p-2 bg-title rounded-top">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_settings_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php echo esc_html__("Audit Settings", _SQ_PLUGIN_NAME_); ?>
                                    <div class="sq_help_question d-inline">
                                        <a href="https://howto.squirrly.co/kb/seo-audit/#seo_audit_settings" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                    </div>
                                </h3>
                                <div class="card-title-description m-2"></div>
                            </div>
                        </div>

                        <div id="sq_seosettings" class="card col-12 p-0 m-0 border-0 tab-panel border-0">
                            <div class="card-body p-0">
                                <div class="col-12 m-0 p-0">
                                    <div class="card col-12 p-0 border-0 ">


                                        <div class="col-12 row py-2 mx-0 my-3">
                                            <div class="col-4 p-0 pr-3 font-weight-bold">
                                                <?php echo esc_html__("Audit Email", _SQ_PLUGIN_NAME_); ?>:
                                                <div class="small text-black-50 my-1"><?php echo esc_html__("Enter the email address on which you want to receive the weekly audits.", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                            <div class="col-8 p-0 input-group input-group-lg">
                                                <input type="text" class="form-control bg-input" name="sq_audit_email" value="<?php echo SQ_Classes_Helpers_Tools::getOption('sq_audit_email') ?>"/>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-12 my-3 p-0">
                        <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php echo esc_html__("Save Settings", _SQ_PLUGIN_NAME_); ?></button>
                    </div>
                </form>

            </div>
            <div class="sq_col_side sticky">
                <div class="card col-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
