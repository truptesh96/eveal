<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_settings')) {
            echo '<div class="col-12 alert alert-success text-center m-0 p-3">'. esc_html__("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_).'</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_seosettings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">
                <?php do_action('sq_form_notices'); ?>
                <form method="POST">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_robots', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_robots"/>

                    <div class="card col-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-7 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_robots_icon m-2"></div>
                                </div>
                                <h3 class="card-title"><?php echo esc_html__("Robots File", _SQ_PLUGIN_NAME_); ?>
                                    <div class="sq_help_question d-inline">
                                        <a href="https://howto.squirrly.co/kb/robots-txt-settings/" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                    </div>
                                </h3>
                                <div class="col-12 text-left m-0 p-0">
                                    <div class="card-title-description m-2"><?php echo esc_html__("A robots.txt file tells search engine crawlers which pages or files the crawler can or can't request from your site.", _SQ_PLUGIN_NAME_); ?></div>
                                </div>
                            </div>
                            <div class="col-5 text-right">
                                <div class="checker row my-4 py-2 mx-0 px-0 justify-content-end">
                                    <div class="sq-switch redgreen sq-switch-sm ">
                                        <label for="sq_auto_robots" class="mr-2"><?php echo esc_html__("Activate Robots", _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_robots" value="0"/>
                                        <input type="checkbox" id="sq_auto_robots" name="sq_auto_robots" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_robots') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_robots"></label>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div id="sq_seosettings" class="card col-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_robots') ? '' : 'sq_deactivated') ?>">
                            <div class="card-body p-0">
                                <div class="col-12 m-0 p-0">
                                    <div class="card col-12 p-0 border-0 ">


                                        <div class="col-12 pt-0 pb-4 border-bottom tab-panel">

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Edit the Robots.txt data", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/robots-txt-settings/#default_robots" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(esc_html__("Does not physically create the robots.txt file. The best option for Multisites.", _SQ_PLUGIN_NAME_), '<a href="https://developers.facebook.com/apps/" target="_blank"><strong>', '</strong></a>'); ?></div>
                                                </div>
                                                <div class="col-8 p-0 form-group">
                                                    <textarea class="form-control" name="robots_permission" rows="10"><?php
                                                        $robots = '';
                                                        $robots_permission = SQ_Classes_Helpers_Tools::getOption('sq_robots_permission');
                                                        if (!empty($robots_permission)) {
                                                            echo implode(PHP_EOL, (array)SQ_Classes_Helpers_Tools::getOption('sq_robots_permission'));
                                                        }

                                                        ?></textarea>

                                                    <div class="col-12 py-3 px-0 font-weight-bold text-danger">
                                                        <?php echo esc_html__("Edit the Robots.txt only if you know what you're doing. Adding wrong rules in Robots can lead to SEO ranking errors or block your posts in Google.", _SQ_PLUGIN_NAME_); ?>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-12 p-0 py-3 bg-light">
                            <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php echo esc_html__("Save Settings", _SQ_PLUGIN_NAME_); ?></button>
                        </div>

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
