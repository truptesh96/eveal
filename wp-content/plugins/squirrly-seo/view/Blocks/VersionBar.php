<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php $page = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', '')); ?>
<div id="sq_notification_bar" style="margin: 20px 0 -15px 0;">

    <?php if (isset($view->checkin) && isset($view->checkin->subscription_status)) {
        if(!isset($view->checkin->subscription_devkit)) $view->checkin->subscription_devkit = 0;

        if ($view->checkin->subscription_status == 'active' && $view->checkin->product_type == 'Lite') {
            $view->checkin->product_type = 'PRO';
        }
        ?>
        <?php if ($page == 'sq_rankings') { ?>
            <?php if ($view->checkin->subscription_serpcheck) { ?>
                <div class="alert alert-success text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("%sSERP Checker %s:%s We update the best ranks for each keyword, daily. 100%% accurate and objective.", _SQ_PLUGIN_NAME_), '<strong>', $view->checkin->product_type, '</strong>'); ?>
                    <?php if (!$view->checkin->subscription_serps && !$view->checkin->subscription_devkit) { ?>
                        <div class="alert alert-warning text-center m-0 p-1">
                            <?php echo sprintf(esc_html__("%sNo SERP queries remained.%s Please check your %saccount status and limits%s", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('account') . '" target="_blank"><strong>', '</strong></a>'); ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="alert alert-warning text-center m-0  p-1 small">
                    <?php echo sprintf(esc_html__("%sSERP Checker %s:%s We show ranks according to what Google shows you in Google Search Console. %sPositions shown by GSC are averages, not exact positions in SERPs. %sTo have your rankings checked daily please upgrade your plan to %sBusiness Plan%s", _SQ_PLUGIN_NAME_), '<strong>', $view->checkin->product_type, '</strong>', '<br />', '<br />', '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('plans') . '" target="_blank"><strong>', '</strong></a>'); ?>
                </div>
            <?php } ?>
        <?php } ?>
        <?php if ($page == 'sq_audits' && isset($view->checkin->subscription_max_audit_pages)) { ?>
            <?php if ($view->checkin->subscription_max_audit_pages && $view->checkin->subscription_status == 'active') { ?>
                <div class="alert alert-success text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("%sAudit %s:%s Add maximum %s page(s) in Audit and request a new audit every hour.", _SQ_PLUGIN_NAME_), '<strong>', $view->checkin->product_type, '</strong>', $view->checkin->subscription_max_audit_pages); ?>
                </div>
            <?php } elseif ($view->checkin->subscription_max_audit_pages && $view->checkin->subscription_status == 'freemium') { ?>
                <div class="alert alert-warning text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("%sAudit %s:%s Add maximum %s page(s) in Audit. The audit will be generated once a week. %sTo add more pages in Audit and refresh the audit every hour please upgrade your plan to %sPRO Plan%s", _SQ_PLUGIN_NAME_), '<strong>', $view->checkin->product_type, '</strong>', $view->checkin->subscription_max_audit_pages, '<br />', '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('plans') . '" target="_blank"><strong>', '</strong></a>'); ?>
                </div>
            <?php } ?>
        <?php } ?>
        <?php if ($page == 'sq_focuspages' && isset($view->checkin->subscription_max_focus_pages)) { ?>
            <?php if ($view->checkin->subscription_max_focus_pages && $view->checkin->subscription_status == 'active') { ?>
                <div class="alert alert-success text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("%sFocus Pages %s:%s Add maximum %s page(s) in Focus Pages and request a new audit for each page every 5 mins.", _SQ_PLUGIN_NAME_), '<strong>', $view->checkin->product_type, '</strong>', $view->checkin->subscription_max_focus_pages); ?>
                </div>
            <?php } elseif ($view->checkin->subscription_max_focus_pages && $view->checkin->subscription_status == 'freemium') { ?>
                <div class="alert alert-warning text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("%sFocus Pages %s:%s Add maximum %s page(s) in Focus Pages and request a new audit for each page every 5 mins. %sTo add more pages in Focus Pages please upgrade your plan to %sPRO Plan%s", _SQ_PLUGIN_NAME_), '<strong>', $view->checkin->product_type, '</strong>', $view->checkin->subscription_max_focus_pages, '<br />', '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('plans') . '" target="_blank"><strong>', '</strong></a>'); ?>
                </div>
            <?php } elseif ($view->checkin->subscription_onetime) { ?>
                <div class="alert alert-warning text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("Your current plan is OLD Squirrly plan: Please read the official notes about it %shttps://www.squirrly.co/you-received-access-to-all-updates-from-squirrly-seo/%s", _SQ_PLUGIN_NAME_), '<a href="https://www.squirrly.co/you-received-access-to-all-updates-from-squirrly-seo/" target="_blank"><strong>', '</strong></a>'); ?>
                </div>
            <?php } ?>
        <?php } ?>

        <?php if ($page == 'sq_assistant') { ?>
            <?php if ($view->checkin->subscription_status == 'active') { ?>
                <div class="alert alert-success text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("%sLive Assistant %s:%s Use Squirrly Live Assistant with all the optimization tasks to get 100%% optimized posts and pages.", _SQ_PLUGIN_NAME_), '<strong>', $view->checkin->product_type, '</strong>'); ?>
                </div>
            <?php } elseif ($view->checkin->subscription_status == 'freemium') { ?>
                <div class="alert alert-warning text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("%sLive Assistant %s:%s Use the main SEO tasks to optimize your posts and pages. %sTo optimize your posts to 100%% please upgrade your plan to %sPRO Plan%s", _SQ_PLUGIN_NAME_), '<strong>', $view->checkin->product_type, '</strong>', '<br />', '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('plans') . '" target="_blank"><strong>', '</strong></a>'); ?>
                </div>
            <?php } ?>
        <?php } ?>

        <?php if ($page == 'sq_research' && SQ_Classes_Helpers_Tools::getValue('tab', 'research') == 'research' && isset($view->checkin->subscription_kr) && isset($view->checkin->subscription_research)) { ?>
            <?php if ($view->checkin->subscription_status == 'active' && $view->checkin->subscription_research == 'light') { ?>
                <div class="alert alert-warning  text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("%sResearch %s:%s You have %s researches left for your account. The research will return up to 20 results for each keyword. %sFor more Researches and up to 50 results per research, please upgrade your plan to %sBusiness Plan%s", _SQ_PLUGIN_NAME_), '<strong>', $view->checkin->product_type, '</strong>', (int)$view->checkin->subscription_kr, '<br />', '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('plans') . '" target="_blank"><strong>', '</strong></a>'); ?>
                </div>
            <?php } elseif ($view->checkin->subscription_status == 'active' && $view->checkin->subscription_research == 'deep') { ?>
                <div class="alert alert-success text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("%sResearch %s:%s You have %s researches left for your account. %sYou can do Deep Keyword Research and get up to 50 results on each research.", _SQ_PLUGIN_NAME_), '<strong>', $view->checkin->product_type, '</strong>', (int)$view->checkin->subscription_kr, '<br />'); ?>
                </div>
            <?php } elseif ($view->checkin->subscription_status == 'freemium') { ?>
                <div class="alert alert-warning text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("%sResearch %s:%s You have %s researches left for your account. The research will return up to 10 results for each keyword. %sFor more Researches and up to 50 results per research, please upgrade your plan to %sBusiness Plan%s", _SQ_PLUGIN_NAME_), '<strong>', $view->checkin->product_type, '</strong>', (int)$view->checkin->subscription_kr, '<br />', '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('plans') . '" target="_blank"><strong>', '</strong></a>'); ?>
                </div>
            <?php } ?>
        <?php } ?>

        <?php if ($page == 'sq_research' && SQ_Classes_Helpers_Tools::getValue('tab', '') == 'briefcase') { ?>
            <div class="alert alert-success text-center m-0 p-1 small">
                <?php echo sprintf(esc_html__("%sSquirrly Briefcase:%s Add unlimited keywords in your Squirrly Briefcase to optimize your posts and pages.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?>
            </div>
        <?php } ?>
        <?php if ($page == 'sq_research' && SQ_Classes_Helpers_Tools::getValue('tab', '') == 'labels') { ?>
            <div class="alert alert-success text-center m-0 p-1 small">
                <?php echo sprintf(esc_html__("%sSquirrly Labels:%s Add unlimited Labels for the Squirrly Briefcase keywords to organize the keywords by your SEO strategy.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?>
            </div>
        <?php } ?>
        <?php if ($page == 'sq_research' && SQ_Classes_Helpers_Tools::getValue('tab', '') == 'suggested') { ?>
            <?php if ($view->checkin->subscription_status == 'active') { ?>
                <div class="alert alert-success text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("%sKeyword Suggestion %s:%s You'll get keyword suggestions every week if we find better matching keywords based on your research history.", _SQ_PLUGIN_NAME_), '<strong>', $view->checkin->product_type, '</strong>'); ?>
                </div>
            <?php } elseif ($view->checkin->subscription_status == 'freemium') { ?>
                <div class="alert alert-warning text-center m-0 p-1 small">
                    <?php echo sprintf(esc_html__("This feature is only available for PRO and Business accounts. %sTo get Keyword Suggections every week please upgrade your plan to %sBusiness Plan%s", _SQ_PLUGIN_NAME_), '<br />', '<a href="' . SQ_Classes_RemoteController::getMySquirrlyLink('plans') . '" target="_blank"><strong>', '</strong></a>'); ?>
                </div>
            <?php } ?>
        <?php } ?>

    <?php } ?>

    <?php if ($page == 'sq_bulkseo') { ?>
        <div class="alert alert-success text-center m-0 p-1 small">
            <?php echo sprintf(esc_html__("%sBulk SEO Settings:%s This feature is included in all versions of Squirrly SEO for free.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?>
        </div>
    <?php } ?>

    <?php if ($page == 'sq_seosettings') { ?>
        <div class="alert alert-success text-center m-0 p-1 small">
            <?php echo sprintf(esc_html__("%sOn-Page SEO Settings:%s This feature is included in all versions of Squirrly SEO for free.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?>
        </div>
    <?php } ?>

    <?php if (SQ_Classes_Helpers_Tools::getMenuVisible('show_ads') && SQ_Classes_Helpers_Tools::getOption('sq_offer') && (!isset($_COOKIE['sq_nooffer']))) { ?>
        <?php echo SQ_Classes_Helpers_Tools::getOption('sq_offer') ?>
    <?php } ?>
</div>


