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
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_webmaster', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_webmaster"/>

                    <div class="card col-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-7 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_websites_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php echo esc_html__("Webmaster Tools", _SQ_PLUGIN_NAME_); ?>
                                    <div class="sq_help_question d-inline">
                                        <a href="https://howto.squirrly.co/kb/webmasters-settings/" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                    </div>
                                </h3>
                            </div>
                            <div class="col-5 text-right">
                                <div class="checker row my-4 py-2 mx-0 px-0 justify-content-end">
                                    <div class="sq-switch redgreen sq-switch-sm ">
                                        <label for="sq_auto_webmasters" class="mr-2"><?php echo esc_html__("Activate Webmasters", _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_webmasters" value="0"/>
                                        <input type="checkbox" id="sq_auto_webmasters" name="sq_auto_webmasters" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_webmasters') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_webmasters"></label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="sq_seosettings" class="card col-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_webmasters') ? '' : 'sq_deactivated') ?>">

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
                                                    <?php echo esc_html__("Google Search Console", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/webmaster-tools-settings/#gsc" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(esc_html__("Add the Google META verification code to connect to %sGoogle Search Console%s", _SQ_PLUGIN_NAME_), '<a href="https://www.google.com/webmasters/verification/verification?siteUrl='.home_url().'&priorities=vmeta" target="_blank">', '</a>'); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input id="google_wt" type="text" class="form-control bg-input" name="codes[google_wt]" value="<?php echo((isset($codes->google_wt)) ? esc_attr($codes->google_wt) : '') ?>" />
                                                    <?php if (!$connect->google_search_console) { ?>
                                                        <div class="sq_step1 my-0 mx-2">
                                                            <a href="<?php echo SQ_Classes_RemoteController::getApiLink('gscoauth'); ?>" onclick="jQuery('.sq_step1').hide();jQuery('.sq_step2').show();" target="_blank" type="button" class="btn btn-block btn-social btn-google text-info connect-button connect btn-lg">
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
                                                            <button id="sq_webmaster_button" type="button" class=" btn btn-block btn-warning btn-lg">
                                                                <?php echo esc_html__("Get GSC Code", _SQ_PLUGIN_NAME_); ?>
                                                            </button>
                                                        </div>
                                                    <?php }?>
                                                </div>

                                                <div class="col-12 text-center py-3 mx-auto my-0">
                                                    <h6><?php echo sprintf(esc_html__("Need Help Connecting Google Search Console? %sClick Here%s", _SQ_PLUGIN_NAME_),'<a href="https://howto.squirrly.co/faq/need-help-connecting-google-search-console-both-tracking-code-and-api-connection/" target="_blank">','</a>') ?></h6>
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Bing Webmaster Tools", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/webmaster-tools-settings/#bing_webmaster" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(esc_html__("Add the Bing META verification code to connect to %sBing Webmaster Tool%s", _SQ_PLUGIN_NAME_), '<a href="http://www.bing.com/toolbox/webmaster/" target="_blank">', '</a>'); ?></div>
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="codes[bing_wt]" value="<?php echo((isset($codes->bing_wt)) ? esc_attr($codes->bing_wt) : '') ?>" />
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Baidu Webmaster Tools", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/webmaster-tools-settings/#baidu_webmaster" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(esc_html__("Add the Baidu META verification code to connect to %sBaidu Webmaster Tool%s", _SQ_PLUGIN_NAME_), '<a href="https://ziyuan.baidu.com/site/" target="_blank">', '</a>'); ?></div>
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="codes[baidu_wt]" value="<?php echo((isset($codes->baidu_wt)) ? esc_attr($codes->baidu_wt) : '') ?>" />
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Yandex Webmaster Code", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/webmaster-tools-settings/#yandex_webmaster" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(esc_html__("Add the Yandex META verification code to connect to %sYandex Webmaster Tool%s", _SQ_PLUGIN_NAME_), '<a href="https://webmaster.yandex.com/sites/" target="_blank">', '</a>'); ?></div>
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="codes[yandex_wt]" value="<?php echo((isset($codes->yandex_wt)) ? esc_attr($codes->yandex_wt) : '') ?>" />
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Alexa META Code", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/webmaster-tools-settings/#alexa_code" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(esc_html__("Add the Alexa META code to analyze your entire website. Visit the %sAlexa Marketing Tool%s", _SQ_PLUGIN_NAME_), '<a href="http://www.alexa.com/" target="_blank">', '</a>'); ?></div>
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="codes[alexa_verify]" value="<?php echo((isset($codes->alexa_verify)) ? esc_attr($codes->alexa_verify) : '') ?>" />
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Pinterest Website Validator Code", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/webmaster-tools-settings/#pinterest_validation" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(esc_html__("Add the Pinterest verification code to connect your website to your Pinterest account. Visit the %sRich Pins Validator%s", _SQ_PLUGIN_NAME_), '<a href="https://developers.pinterest.com/tools/url-debugger/" target="_blank">', '</a>'); ?></div>
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="codes[pinterest_verify]" value="<?php echo((isset($codes->pinterest_verify)) ? esc_attr($codes->pinterest_verify) : '') ?>" />
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Norton Safe Web Code", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/webmaster-tools-settings/#norton_safe_code" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(esc_html__("Add the Norton Safe Web verification code or ID to connect your website to Norton Safe Web. Visit the %sNorton Ownership Verification Page%s", _SQ_PLUGIN_NAME_), '<a href="https://support.norton.com/sp/en/in/home/current/solutions/kb20090410134005EN" target="_blank">', '</a>'); ?></div>
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="codes[norton_verify]" value="<?php echo((isset($codes->norton_verify)) ? esc_attr($codes->norton_verify) : '') ?>" />
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
