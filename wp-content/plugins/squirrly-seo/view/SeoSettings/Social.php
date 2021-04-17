<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_settings')) {
            echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_) . '</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_seosettings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">
                <?php do_action('sq_form_notices'); ?>
                <form method="POST">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_social', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_social"/>

                    <div class="card col-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-7 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_social_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php echo esc_html__("Social Media", _SQ_PLUGIN_NAME_); ?>
                                    <div class="sq_help_question d-inline">
                                        <a href="https://howto.squirrly.co/kb/social-media-settings/" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                    </div>
                                </h3>
                            </div>

                        </div>

                        <div id="sq_seosettings" class="card col-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_social') ? '' : 'sq_deactivated') ?>">

                            <div class="card-body p-0">
                                <div class="col-12 m-0 p-0">
                                    <div class="card col-12 p-0 border-0 ">
                                        <?php
                                        $socials = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('socials')));
                                        ?>

                                        <div class="col-12 pt-0 pb-4 border-bottom tab-panel">
                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_facebook" value="0"/>
                                                        <input type="checkbox" id="sq_auto_facebook" name="sq_auto_facebook" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_facebook" class="ml-2"><?php echo esc_html__("Activate Open Graph", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/social-media-settings/#open_graph" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add the Social Open Graph protocol so that your Facebook shares look good.", _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php echo sprintf(esc_html__("You can always update an URL on Facebook if you change its Social Media Image. Visit %sOpen Graph Debugger%s", _SQ_PLUGIN_NAME_), '<a href="https://developers.facebook.com/tools/debug/?q=' . home_url() . '" target="_blank" ><strong>', '</strong></a>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 py-4 border-bottom tab-panel">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Default Open Graph Image", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50"><?php echo esc_html__("Set an Open Graph default Image to load when you don't have any image for a URL set.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input id="sq_og_image" type="text" class="form-control bg-input" name="sq_og_image" value="<?php echo((SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') <> '') ? SQ_Classes_Helpers_Tools::getOption('sq_og_image') : '') ?>"/>
                                                    <input type="button" class="sq_imageselect btn btn-primary rounded-right" data-destination="sq_og_image" value="<?php echo esc_html__("Select Image", _SQ_PLUGIN_NAME_) ?>"/>
                                                </div>
                                            </div>


                                            <div class="col-12 row py-2 mx-0 my-3 ">
                                                <div class="col-4 p-1 pr-3">
                                                    <div class="font-weight-bold"><?php echo esc_html__("Facebook Share Language", _SQ_PLUGIN_NAME_); ?>:
                                                        <a href="https://howto.squirrly.co/kb/social-media-settings/#share_language" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </div>
                                                    <div class="small text-black-50"><?php echo esc_html__("Use this so that Facebook can automatically translate the text into the reader's language", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group">
                                                    <select name="sq_og_locale" class="form-control bg-input mb-1">
                                                        <option value="en_US">English (US)</option>
                                                        <option value="af_ZA">Afrikaans</option>
                                                        <option value="ak_GH">Akan</option>
                                                        <option value="am_ET">Amharic</option>
                                                        <option value="ar_AR">Arabic</option>
                                                        <option value="as_IN">Assamese</option>
                                                        <option value="ay_BO">Aymara</option>
                                                        <option value="az_AZ">Azerbaijani</option>
                                                        <option value="be_BY">Belarusian</option>
                                                        <option value="bg_BG">Bulgarian</option>
                                                        <option value="bn_IN">Bengali</option>
                                                        <option value="br_FR">Breton</option>
                                                        <option value="bs_BA">Bosnian</option>
                                                        <option value="ca_ES">Catalan</option>
                                                        <option value="cb_IQ">Sorani Kurdish</option>
                                                        <option value="ck_US">Cherokee</option>
                                                        <option value="co_FR">Corsican</option>
                                                        <option value="cs_CZ">Czech</option>
                                                        <option value="cx_PH">Cebuano</option>
                                                        <option value="cy_GB">Welsh</option>
                                                        <option value="da_DK">Danish</option>
                                                        <option value="de_DE">German</option>
                                                        <option value="el_GR">Greek</option>
                                                        <option value="en_GB">English (UK)</option>
                                                        <option value="en_IN">English (India)</option>
                                                        <option value="en_PI">English (Pirate)</option>
                                                        <option value="en_UD">English (Upside Down)</option>
                                                        <option value="eo_EO">Esperanto</option>
                                                        <option value="es_CL">Spanish (Chile)</option>
                                                        <option value="es_CO">Spanish (Colombia)</option>
                                                        <option value="es_ES">Spanish (Spain)</option>
                                                        <option value="es_LA">Spanish</option>
                                                        <option value="es_MX">Spanish (Mexico)</option>
                                                        <option value="es_VE">Spanish (Venezuela)</option>
                                                        <option value="et_EE">Estonian</option>
                                                        <option value="eu_ES">Basque</option>
                                                        <option value="fa_IR">Persian</option>
                                                        <option value="fb_LT">Leet Speak</option>
                                                        <option value="ff_NG">Fulah</option>
                                                        <option value="fi_FI">Finnish</option>
                                                        <option value="fo_FO">Faroese</option>
                                                        <option value="fr_CA">French (Canada)</option>
                                                        <option value="fr_FR">French (France)</option>
                                                        <option value="fy_NL">Frisian</option>
                                                        <option value="ga_IE">Irish</option>
                                                        <option value="gl_ES">Galician</option>
                                                        <option value="gn_PY">Guarani</option>
                                                        <option value="gu_IN">Gujarati</option>
                                                        <option value="gx_GR">Classical Greek</option>
                                                        <option value="ha_NG">Hausa</option>
                                                        <option value="he_IL">Hebrew</option>
                                                        <option value="hi_IN">Hindi</option>
                                                        <option value="hr_HR">Croatian</option>
                                                        <option value="hu_HU">Hungarian</option>
                                                        <option value="hy_AM">Armenian</option>
                                                        <option value="id_ID">Indonesian</option>
                                                        <option value="ig_NG">Igbo</option>
                                                        <option value="is_IS">Icelandic</option>
                                                        <option value="it_IT">Italian</option>
                                                        <option value="ja_JP">Japanese</option>
                                                        <option value="ja_KS">Japanese (Kansai)</option>
                                                        <option value="jv_ID">Javanese</option>
                                                        <option value="ka_GE">Georgian</option>
                                                        <option value="kk_KZ">Kazakh</option>
                                                        <option value="km_KH">Khmer</option>
                                                        <option value="kn_IN">Kannada</option>
                                                        <option value="ko_KR">Korean</option>
                                                        <option value="ku_TR">Kurdish (Kurmanji)</option>
                                                        <option value="la_VA">Latin</option>
                                                        <option value="lg_UG">Ganda</option>
                                                        <option value="li_NL">Limburgish</option>
                                                        <option value="ln_CD">Lingala</option>
                                                        <option value="lo_LA">Lao</option>
                                                        <option value="lt_LT">Lithuanian</option>
                                                        <option value="lv_LV">Latvian</option>
                                                        <option value="mg_MG">Malagasy</option>
                                                        <option value="mk_MK">Macedonian</option>
                                                        <option value="ml_IN">Malayalam</option>
                                                        <option value="mn_MN">Mongolian</option>
                                                        <option value="mr_IN">Marathi</option>
                                                        <option value="ms_MY">Malay</option>
                                                        <option value="mt_MT">Maltese</option>
                                                        <option value="my_MM">Burmese</option>
                                                        <option value="nb_NO">Norwegian (bokmal)</option>
                                                        <option value="nd_ZW">Ndebele</option>
                                                        <option value="ne_NP">Nepali</option>
                                                        <option value="nl_BE">Dutch (België)</option>
                                                        <option value="nl_NL">Dutch</option>
                                                        <option value="nn_NO">Norwegian (nynorsk)</option>
                                                        <option value="ny_MW">Chewa</option>
                                                        <option value="or_IN">Oriya</option>
                                                        <option value="pa_IN">Punjabi</option>
                                                        <option value="pl_PL">Polish</option>
                                                        <option value="ps_AF">Pashto</option>
                                                        <option value="pt_BR">Portuguese (Brazil)</option>
                                                        <option value="pt_PT">Portuguese (Portugal)</option>
                                                        <option value="qu_PE">Quechua</option>
                                                        <option value="rm_CH">Romansh</option>
                                                        <option value="ro_RO">Romanian</option>
                                                        <option value="ru_RU">Russian</option>
                                                        <option value="rw_RW">Kinyarwanda</option>
                                                        <option value="sa_IN">Sanskrit</option>
                                                        <option value="sc_IT">Sardinian</option>
                                                        <option value="se_NO">Northern Sámi</option>
                                                        <option value="si_LK">Sinhala</option>
                                                        <option value="sk_SK">Slovak</option>
                                                        <option value="sl_SI">Slovenian</option>
                                                        <option value="sn_ZW">Shona</option>
                                                        <option value="so_SO">Somali</option>
                                                        <option value="sq_AL">Albanian</option>
                                                        <option value="sr_RS">Serbian</option>
                                                        <option value="sv_SE">Swedish</option>
                                                        <option value="sw_KE">Swahili</option>
                                                        <option value="sy_SY">Syriac</option>
                                                        <option value="sz_PL">Silesian</option>
                                                        <option value="ta_IN">Tamil</option>
                                                        <option value="te_IN">Telugu</option>
                                                        <option value="tg_TJ">Tajik</option>
                                                        <option value="th_TH">Thai</option>
                                                        <option value="tk_TM">Turkmen</option>
                                                        <option value="tl_PH">Filipino</option>
                                                        <option value="tl_ST">Klingon</option>
                                                        <option value="tr_TR">Turkish</option>
                                                        <option value="tt_RU">Tatar</option>
                                                        <option value="tz_MA">Tamazight</option>
                                                        <option value="uk_UA">Ukrainian</option>
                                                        <option value="ur_PK">Urdu</option>
                                                        <option value="uz_UZ">Uzbek</option>
                                                        <option value="vi_VN">Vietnamese</option>
                                                        <option value="wo_SN">Wolof</option>
                                                        <option value="xh_ZA">Xhosa</option>
                                                        <option value="yi_DE">Yiddish</option>
                                                        <option value="yo_NG">Yoruba</option>
                                                        <option value="zh_CN">Simplified Chinese (China)</option>
                                                        <option value="zh_HK">Traditional Chinese (Hong Kong)</option>
                                                        <option value="zh_TW">Traditional Chinese (Taiwan)</option>
                                                        <option value="zu_ZA">Zulu</option>
                                                        <option value="zz_TR">Zazaki</option>
                                                    </select>
                                                    <script>jQuery('select[name=sq_og_locale]').val('<?php echo SQ_Classes_Helpers_Tools::getOption('sq_og_locale')?>').attr('selected', true);</script>
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 my-3 ">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Facebook App ID", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/social-media-settings/#open_graph_app_id" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo sprintf(esc_html__("Add the %sFacebook App ID%s to create a connection between your Facebook Page and your Website.", _SQ_PLUGIN_NAME_), '<a href="https://developers.facebook.com/apps/" target="_blank"><strong>', '</strong></a>'); ?></div>
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="socials[fbadminapp]" value="<?php echo(($socials->fbadminapp <> '') ? esc_attr($socials->fbadminapp) : '') ?>"/>
                                                </div>
                                            </div>

                                            <?php
                                            if (!empty($socials->fb_admins)) {
                                                foreach ($socials->fb_admins as $id => $values) {
                                                    if ($id > 0 && !isset($values->id) && !$values) continue;
                                                    ?>
                                                    <div class="col-12 row py-2 mx-0 my-3 ">
                                                        <?php if ($id > 0) { ?>
                                                            <button type="button" class="close" aria-label="Close" onclick="jQuery(this).parent().remove();" style="position: absolute; float: right;right: 10px;top: 15px;left: auto;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        <?php } ?>
                                                        <div class="col-4 p-0 pr-3 font-weight-bold">
                                                            <?php echo esc_html__("Facebook Admin ID", _SQ_PLUGIN_NAME_); ?>:
                                                            <a href="https://howto.squirrly.co/kb/social-media-settings/#open_graph_admin_id" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                            <div class="small text-black-50 my-1"><?php echo esc_html__("Similar to Facebook App ID, Facebook Admin ID connects your Facebook Page to your Website.", _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                        <div class="col-6 p-0 input-group input-group-lg">
                                                            <input type="text" class="form-control bg-input" name="socials[fb_admins][]" value="<?php echo(isset($values->id) ? esc_attr($values->id) : esc_attr($values)) ?>"/>
                                                        </div>
                                                    </div>
                                                <?php }
                                            } else {
                                                ?>
                                                <div class="col-12 row py-2 mx-0 my-3 ">
                                                    <div class="col-4 p-0 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Facebook Admin ID", _SQ_PLUGIN_NAME_); ?>:
                                                        <div class="small text-black-50 my-1"><?php echo esc_html__("Similar to Facebook App ID, Facebook Admin ID connects your Facebook Page to your Website.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                    <div class="col-6 p-0 input-group input-group-lg">
                                                        <input type="text" class="form-control bg-input" name="socials[fb_admins][]" value=""/>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="col-12 row py-2 mx-0 my-3 sq_fb_admins" style="display: none">
                                                <button type="button" class="close" aria-label="Close" onclick="jQuery(this).parent().remove();" style="position: absolute; float: right;right: 10px;top: 15px;left: auto;">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Facebook Admin ID", _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-6 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="socials[fb_admins][]" value=""/>
                                                </div>
                                            </div>
                                            <div class="col-12 py-0 text-center">
                                                <button type="button" class="btn rounded-0 btn-default btn-sm p-2 m-0 m-0" onclick="var $clone = jQuery('.sq_fb_admins:last').clone(); jQuery('.sq_fb_admins:last').before($clone); $clone.show();"><?php echo esc_html__("Add multiple Facebook Admin IDs", _SQ_PLUGIN_NAME_); ?></button>
                                            </div>
                                        </div>

                                        <div class="bg-title p-2 ">
                                            <h3 class="card-title"><?php echo esc_html__("Twitter Card Settings", _SQ_PLUGIN_NAME_); ?></h3>
                                        </div>
                                        <div class="col-12 py-4 border-bottom tab-panel">
                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_twitter" value="0"/>
                                                        <input type="checkbox" id="sq_auto_twitter" name="sq_auto_twitter" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_twitter" class="ml-2"><?php echo esc_html__("Activate Twitter Card", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/social-media-settings/#twitter_card" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add the Twitter Card in your tweets so that your Twitter shares look good.", _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php echo sprintf(esc_html__("Make sure you validate the twitter card with your Twitter account. Visit %sTwitter Card Validator%s", _SQ_PLUGIN_NAME_), '<a href="https://cards-dev.twitter.com/validator?url=' . home_url() . '" target="_blank" ><strong>', '</strong></a>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 py-4 tab-panel">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Default Twitter Card Image", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50"><?php echo esc_html__("Set a Twitter Card default Image to load when you don't have any image for a URL set.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input id="sq_tc_image" type="text" class="form-control bg-input" name="sq_tc_image" value="<?php echo((SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') <> '') ? SQ_Classes_Helpers_Tools::getOption('sq_tc_image') : '') ?>"/>
                                                    <input type="button" class="sq_imageselect btn btn-primary rounded-right" data-destination="sq_tc_image" value="<?php echo esc_html__("Select Image", _SQ_PLUGIN_NAME_) ?>"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 row mb-1 ml-1">
                                            <div class="checker col-12 row my-2 py-1">
                                                <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="socials[twitter_card_type]" value="summary"/>
                                                    <input type="checkbox" id="twitter_card_type" name="socials[twitter_card_type]" class="sq-switch" <?php echo($socials->twitter_card_type == 'summary_large_image' ? 'checked="checked"' : '') ?> value="summary_large_image"/>
                                                    <label for="twitter_card_type" class="ml-2"><?php echo esc_html__("Share Large Images", _SQ_PLUGIN_NAME_); ?>
                                                        <a href="https://howto.squirrly.co/kb/social-media-settings/#twitter_card_large_images" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="offset-1 small text-black-50"><?php echo esc_html__("Activate this option only if you upload images with sizes between 500px and 4096px width in Twitter Card.", _SQ_PLUGIN_NAME_); ?></div>
                                                    <div class="offset-1 small text-black-50"><?php echo sprintf(esc_html__("This option will show the twitter card image as a shared image and not as a summary. Visit %sSummary Card with Large Image%s", _SQ_PLUGIN_NAME_), '<a href="https://developer.twitter.com/en/docs/tweets/optimize-with-cards/overview/summary-card-with-large-image.html" target="_blank" ><strong>', '</strong></a>'); ?></div>
                                                    <div class="offset-1 small text-black-50"><?php echo sprintf(esc_html__("Every change needs %sTwitter Card Validator%s", _SQ_PLUGIN_NAME_), '<a href="https://cards-dev.twitter.com/validator?url=' . home_url() . '" target="_blank" ><strong>', '</strong></a>'); ?></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="bg-title mt-4 p-2">
                                            <h3 class="card-title"><?php echo esc_html__("Social Media Accounts", _SQ_PLUGIN_NAME_); ?>
                                                <a href="https://howto.squirrly.co/kb/social-media-settings/#social_media_accounts" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                            </h3>
                                            <div class="col-12 text-left m-0 p-0">
                                                <div class="card-title-description mb-0"><?php echo esc_html__("Add your Social Media account for JSON-LD Structured data, Open Graph, and Twitter Card.", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 py-4 border-bottom tab-panel">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Twitter Profile URL", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo "https://twitter.com/XXXXXXXX"; ?></div>
                                                    <div class="small text-danger my-1"><?php echo esc_html__("Required for Twitter Card Validator", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="socials[twitter_site]" value="<?php echo((isset($socials->twitter_site)) ? esc_attr($socials->twitter_site) : '') ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Facebook Profile or Page URL", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo "https://facebook.com/XXXXXXXX"; ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="socials[facebook_site]" value="<?php echo((isset($socials->facebook_site)) ? esc_attr($socials->facebook_site) : '') ?>"/>
                                                </div>
                                            </div>


                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Linkedin Profile URL", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo "https://linkedin.com/XXXXXXXX"; ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="socials[linkedin_url]" value="<?php echo((isset($socials->linkedin_url)) ? esc_attr($socials->linkedin_url) : '') ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Pinterest Profile URL", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo "https://pinterest.com/XXXXXXXX"; ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="socials[pinterest_url]" value="<?php echo((isset($socials->pinterest_url)) ? esc_attr($socials->pinterest_url) : '') ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Instagram Profile URL", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo "https://instagram.com/XXXXXXXX"; ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="socials[instagram_url]" value="<?php echo((isset($socials->instagram_url)) ? esc_attr($socials->instagram_url) : '') ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Youtube Channel URL", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo "https://youtube.com/channel/XXXXXXXX"; ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="socials[youtube_url]" value="<?php echo((isset($socials->youtube_url)) ? esc_attr($socials->youtube_url) : '') ?>"/>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <?php $metas = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('sq_metas'))); ?>
                                    <div class="sq_advanced">
                                        <div class="bg-title p-2">
                                            <h3 class="card-title">
                                                <?php echo esc_html__("Title & Description Lengths", _SQ_PLUGIN_NAME_); ?>:
                                                <a href="https://howto.squirrly.co/kb/social-media-settings/#lengths" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                            </h3>
                                        </div>
                                        <div class="col-12 py-4 border-bottom tab-panel ">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-1 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Open Graph Title Length", _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[og_title_maxlength]" value="<?php echo (int)$metas->og_title_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-1 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Open Graph Description Length", _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[og_description_maxlength]" value="<?php echo (int)$metas->og_description_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-1 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Twitter Card Title Length", _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[tw_title_maxlength]" value="<?php echo (int)$metas->tw_title_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-1 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Twitter Card Description Length", _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[tw_description_maxlength]" value="<?php echo (int)$metas->tw_description_maxlength ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 p-0 py-3 bg-light">
                            <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) { ?>
                                <div class="py-0 float-right text-right m-2">
                                    <button type="button" class="show_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0"><?php echo esc_html__("Show Advanced Options", _SQ_PLUGIN_NAME_); ?></button>
                                    <button type="button" class="hide_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0" style="display: none"><?php echo esc_html__("Hide Advanced Options", _SQ_PLUGIN_NAME_); ?></button>
                                </div>
                            <?php } ?>
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
