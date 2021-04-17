<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php echo (string)$view->getScripts(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_focuspages')) {
            echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_) . '</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'audits'), 'sq_audits'); ?>

        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-12 p-0">

                    <div class="card-body p-2 bg-title rounded-top row">
                        <div class="col-10 text-left m-0 p-0">
                            <div class="sq_icons_content p-3 py-4">
                                <div class="sq_icons sq_audit_icon m-2"></div>
                            </div>
                            <h3 class="card-title"><?php echo esc_html__("Audits", _SQ_PLUGIN_NAME_); ?>
                                <div class="sq_help_question d-inline">
                                    <a href="https://howto.squirrly.co/kb/seo-audit/" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                </div>
                            </h3>
                            <div class="card-title-description m-2"><?php echo esc_html__("Verifies the online presence of your website by knowing how your website is performing in terms of Blogging, SEO, Social, Authority, Links, and Traffic", _SQ_PLUGIN_NAME_); ?></div>
                        </div>
                        <div class="col-2 text-right">
                            <i class="fa fa-refresh m-2 sq_auditpages_refresh" style="font-size: 20px !important; cursor: pointer;"></i>

                        </div>
                    </div>

                    <div id="sq_audits" class="card col-12 p-0 tab-panel border-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <?php
                        $connect = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('connect')));
                        if (!$connect->google_analytics) { ?>
                            <div class="form-group my-2 col-8 offset-2">
                                <?php echo $view->getView('Connect/GoogleAnalytics'); ?>
                            </div>
                        <?php } ?>

                        <div class="card col-12 p-0 m-0 border-0 shadow-none">
                            <div class="card-content sq_auditstatus_content m-0">
                                <?php echo $view->getView('Audits/AuditStats'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="card col-12 border-0 m-0 p-0">
                        <div class="sq_auditpages_content">
                            <?php
                            $content = $view->getView('Audits/AuditPages');
                            if (function_exists('iconv')) {
                                $content = iconv('UTF-8', 'UTF-8//IGNORE', $content);
                            }
                            echo (string)$content;
                            ?>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="col-12 my-2 text-black-50">
                            <em><?php echo sprintf(esc_html__("%sNote:%s remember that it takes anywhere between %s1 minute to 5 minutes%s to generate the new audit for each page. There is a lot of processing involved.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<strong>', '</strong>'); ?></em>
                        </div>
                    </div>

                    <div class="card col-12 bg-light rounded-0 py-0">
                        <div class="card-body">
                            <h4 class="text-center text-dark">
                                <?php echo sprintf(esc_html__("Learn how to improve your SEO Audit score over time %sClick Here%s", _SQ_PLUGIN_NAME_), '<a href="https://plugin.squirrly.co/wordpress-seo/what-is-the-site-visibility-score/" target="_blank">', '</a>') ?>
                            </h4>
                        </div>
                    </div>
                </div>
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
<div id="sq_previewurl_modal" tabindex="-1" class="modal" role="dialog">
    <div class="modal-dialog modal-lg" style="max-width: 100% !important;">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo esc_html__("Squirrly Inspect URL", _SQ_PLUGIN_NAME_); ?></h4>
                <i class="fa fa-refresh" style="font-family: FontAwesome, Arial, sans-serif;font-size: 20px !important;cursor: pointer;margin: 2px 10px !important;" onclick="jQuery('#sq_previewurl_modal').sq_inspectURL()"></i>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="min-height: 200px; height:calc(100vh - 120px); overflow-y: auto;">
            </div>
        </div>
    </div>
</div>