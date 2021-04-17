<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_stats">
    <?php
    $dbtasks = json_decode(get_option(SQ_TASKS), true);

    /////////////////// Check the SEO Protection in real time
    $settings = array();
    $settings[] = SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->checkSettingsMetas();
    $settings[] = SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->checkSettingsJsonld();
    $settings[] = SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->checkSettingsSocialOG();
    $settings[] = SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->checkSettingsSocialTWC();
    $settings[] = SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->checkSettingsSitemap();
    $settings[] = SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->checkSettingsPatterns();

    $valid = 0;
    foreach ($settings as $setting) {
        if ($setting) {
            $valid += 1;
        }
    }

    $view->stats['seo_percent'] = 0;
    if ($valid > 0) {
        $view->stats['seo_percent'] = number_format((($valid * 100) / count($settings)), 0, '.', ',');
    }

    //Get the user name
    $username = '';
    if (get_current_user_id()) {
        $user_info = get_userdata(get_current_user_id());
        if (!$username = $user_info->first_name) {
            $username = $user_info->user_login;
        }
    }
    ////////////////////////////////////////////////////////////
    ?>
    <div class="card col-12 m-0 mt-2 p-0">
        <div class="card-body m-0 p-0 bg-title">
            <div class="row text-left m-0 p-0">
                <div class="col p-4">
                    <div class="text-left m-0 p-0 py-1">
                        <div class="col m-0 p-0">
                            <h2 class="m-0 p-0" style="font-size: 40px;font-weight: bold;"><?php echo esc_html__("Hello", _SQ_PLUGIN_NAME_); ?> <?php echo ucfirst($username) ?>,</h2>
                        </div>
                    </div>
                    <div class="sq_separator"></div>
                    <div class="row text-left m-0 p-0 py-3" style="max-width: 1200px;">
                        <div class="col-8 m-0 p-0">
                            <h3 class="card-title m-0 mt-2 p-0"><?php echo sprintf(esc_html__("%s SEO Protection", _SQ_PLUGIN_NAME_), '<strong class="' . ((int)$view->stats['seo_percent'] == 100 ? 'text-success' : 'text-info') . '" style="font-size: 55px; text-shadow: 1px 1px white;">' . (int)$view->stats['seo_percent'] . '%' . '</strong>'); ?></h3>
                            <div class="card-title-description m-0 p-0 text-black-50">
                                <?php if ((int)$view->stats['seo_percent'] == 100) { ?>
                                    <a href="https://howto.squirrly.co/faq/how-does-seo-protection-work/" target="_blank"><?php echo esc_html__("All protection layers are activated.", _SQ_PLUGIN_NAME_); ?></a>
                                <?php } else { ?>
                                    <?php echo sprintf(esc_html__("Power up the SEO from %sSquirrly > SEO Settings%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>'); ?>
                                    <br><a href="https://howto.squirrly.co/faq/how-does-seo-protection-work/" target="_blank">(<?php echo esc_html__("How does this work?", _SQ_PLUGIN_NAME_); ?>)</a>
                                <?php } ?>
                            </div>

                            <div class="row text-left m-0 p-0 pt-4">
                                <div class="col-5 m-0 p-0">
                                    <h5 class="m-0 p-0 text-info" style="text-shadow: 1px 1px white;"><?php echo (int)$view->stats['post_count'] ?>
                                        <span class="small"><?php echo(isset($view->stats['all_post_count']) ? " (" . (int)$view->stats['all_post_count'] . " total)" : '') ?></span>
                                    </h5>
                                    <div class="card-title-description m-0 p-0 text-black-50"><?php echo esc_html__("Pages SEO'ed", _SQ_PLUGIN_NAME_); ?></div>
                                </div>
                                <div class="col-7 m-0 p-0" style="min-width: 100px">
                                    <h5 class="m-0 p-0 text-info" style="text-shadow: 1px 1px white;"><?php echo (int)$view->stats['post_types_count'] ?>
                                        <span class="small"><?php echo(isset($view->stats['all_post_types_count']) ? " (" . (int)$view->stats['all_post_types_count'] . " total)" : '') ?></span>
                                    </h5>
                                    <div class="card-title-description m-0 p-0 text-black-50"><?php echo esc_html__("Post Types Covered", _SQ_PLUGIN_NAME_); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 m-0 p-0" py-2 style="min-width: 100px">
                            <h3 class="card-title m-0 p-0 text-nowrap"><?php echo esc_html__("What's included", _SQ_PLUGIN_NAME_); ?></h3>
                            <div class="card-title-description m-0 p-0 text-black-50"><?php echo sprintf(esc_html__("Over %s400%s free in-depth features", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></div>
                            <div class="card-title-description m-0 p-0 ">
                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_features') ?>"><?php echo esc_html__("See All Tools", _SQ_PLUGIN_NAME_); ?> >></a>
                            </div>
                            <?php if (current_user_can('sq_manage_snippets')) { ?>
                                <?php if (SQ_Classes_Helpers_Tools::getMenuVisible('show_seogoals')) { ?>
                                    <button type="button" class="btn btn-warning m-0 mt-4 py-1 px-4 center-block sq_seocheck_submit">
                                    <?php echo esc_html__("Run SEO Test", _SQ_PLUGIN_NAME_) ?> >>
                                    </button>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="pl-2 pr-0">
                    <div class="sq_coffee">
                        <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/squirrly_coffee.png' ?>" style="width: 300px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>