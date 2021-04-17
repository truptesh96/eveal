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
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_tracking', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_tracking"/>

                    <div class="card col-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-7 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_traffic_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php echo esc_html__("Tracking Tools", _SQ_PLUGIN_NAME_); ?>
                                    <div class="sq_help_question d-inline">
                                        <a href="https://howto.squirrly.co/kb/tracking-tools-settings/" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                    </div>
                                </h3>
                            </div>
                            <div class="col-5 text-right">
                                <div class="checker row my-4 py-2 mx-0 px-0 justify-content-end">
                                    <div class="sq-switch redgreen sq-switch-sm ">
                                        <label for="sq_auto_tracking" class="mr-2"><?php echo esc_html__("Activate Trackers", _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_tracking" value="0"/>
                                        <input type="checkbox" id="sq_auto_tracking" name="sq_auto_tracking" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_tracking"></label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="sq_seosettings" class="card col-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking') ? '' : 'sq_deactivated') ?>">

                            <div class="card-body p-0">
                                <div class="col-12 m-0 p-0">
                                    <div class="card col-12 p-0 border-0 ">
                                        <?php
                                        $codes = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('codes')));
                                        $connect = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('connect')));
                                        ?>

                                        <div class="col-12 pt-0 pb-4 border-bottom tab-panel">

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Google Analytics ID", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/google-analytics-tracking-tool/#google_analytics" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(esc_html__("Squirrly adds the Google Tracking script for your Analytics ID. %sGet the Analytics ID%s", _SQ_PLUGIN_NAME_), '<a href="https://analytics.google.com/analytics/web/" target="_blank"><strong>', '</strong></a>'); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input id="google_analytics" type="text" class="form-control bg-input" name="codes[google_analytics]" value="<?php echo((isset($codes->google_analytics)) ? esc_attr($codes->google_analytics) : '') ?>" placeholder="UA-XXXX or G-XXXX"/>
                                                    <?php if (!$connect->google_analytics) { ?>
                                                        <div class="sq_step1 my-0 mx-2">
                                                            <a href="<?php echo SQ_Classes_RemoteController::getApiLink('gaoauth'); ?>" onclick="jQuery('.sq_step1').hide();jQuery('.sq_step2').show();" target="_blank" type="button" class="btn btn-block btn-social btn-google text-info connect-button connect btn-lg">
                                                                <span class="fa fa-google"></span> <?php echo esc_html__("Sign in", _SQ_PLUGIN_NAME_); ?>
                                                            </a>
                                                        </div>
                                                        <div class="sq_step2 my-0 mx-2" style="display: none">
                                                            <button id="sq_connection_check_button" type="button" class="btn btn-block btn-social btn-warning btn-lg">
                                                                <span class="fa fa-google"></span> <?php echo esc_html__("Check connection", _SQ_PLUGIN_NAME_); ?>
                                                            </button>
                                                        </div>
                                                    <?php }else{?>
                                                        <div class="my-0 mx-2">
                                                            <button id="sq_ga_button" type="button" class=" btn btn-block btn-warning btn-lg">
                                                                <?php echo esc_html__("Get GA Code", _SQ_PLUGIN_NAME_); ?>
                                                            </button>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Google Tracking Mode", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/google-analytics-tracking-tool/#receive_tracking_code" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(esc_html__("Choose gtag.js if you use %sGoogle Tag Manager%s or the %sGoogle Analytics 4%s. Otherwise select analytics.js to track the website traffic.", _SQ_PLUGIN_NAME_), '<a href="https://tagmanager.google.com/" target="_blank"><strong>', '</strong></a>', '<a href="https://support.google.com/analytics/answer/10089681" target="_blank"><strong>', '</strong></a>'); ?></div>
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-lg">
                                                    <select name="sq_analytics_google_js" class="form-control bg-input mb-1">
                                                        <option value="analytics" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_analytics_google_js') == 'analytics') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("analytics.js", _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="gtag" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_analytics_google_js') == 'gtag') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("gtag.js", _SQ_PLUGIN_NAME_); ?></option>
                                                    </select>
                                                </div>

                                                <div class="col-12 text-center pt-3 my-0">
                                                    <h6><?php echo sprintf(esc_html__("Need Help Connecting Google Analytics? %sClick Here%s", _SQ_PLUGIN_NAME_),'<a href="https://howto.squirrly.co/faq/how-do-i-connect-google-analytics-both-tracking-code-and-the-api-connection/" target="_blank">','</a>') ?></h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 py-4 border-bottom tab-panel">

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Facebook Pixel", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/google-analytics-tracking-tool/#facebook_pixel" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(esc_html__("Use FB Pixel to track the visitors events and to use Facebook Ads more efficient. %sLearn More%s", _SQ_PLUGIN_NAME_), '<a href="https://developers.facebook.com/docs/facebook-pixel" target="_blank"><strong>', '</strong></a>'); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="codes[facebook_pixel]" value="<?php echo((isset($codes->facebook_pixel)) ? esc_attr($codes->facebook_pixel) : '') ?>" />
                                                </div>
                                            </div>

                                        </div>


                                        <div class="col-12 py-4 border-bottom tab-panel">
                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_amp" value="0"/>
                                                        <input type="checkbox" id="sq_auto_amp" name="sq_auto_amp" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_amp') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_amp" class="ml-2"><?php echo esc_html__("Load the AMP Support on AMP pages", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/google-analytics-tracking-tool/#amp_support" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo sprintf(esc_html__("Load the Accelerate Mobile Pages (AMP) support for plugins like %sAMP for WP%s or %sAMP%s detected", _SQ_PLUGIN_NAME_),'<a href="https://wordpress.org/plugins/accelerated-mobile-pages/" target="_blank">','</a>','<a href="https://wordpress.org/plugins/amp/" target="_blank">','</a>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_tracking_logged_users" value="0"/>
                                                        <input type="checkbox" id="sq_tracking_logged_users" name="sq_tracking_logged_users" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_tracking_logged_users') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_tracking_logged_users" class="ml-2"><?php echo esc_html__("Load Tracking for Logged Users", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/google-analytics-tracking-tool/#logged_users" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Load the tracking codes for logged users too.", _SQ_PLUGIN_NAME_); ?></div>
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
