<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * Overview
 */
class SQ_Controllers_Overview extends SQ_Classes_FrontController {
    /** @var object Checkin process with Squirrly Cloud */
    public $checkin;

    public function init() {

        if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') {
            echo $this->getView('Errors/Connect');
            return;
        }

        //Checkin to API V2
        $this->checkin = SQ_Classes_RemoteController::checkin();

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap-reboot');
        if (is_rtl()) {
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('popper');
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap.rtl');
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('rtl');
        } else {
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('bootstrap');
        }
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('fontawesome');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('switchery');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('global');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('research');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('navbar');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('dashboard');
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('account');

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('assistant');

        add_action('sq_form_notices', array($this, 'getNotificationBar'));
        add_action('sq_form_notices', array($this, 'getNotificationCompatibility'));

        //@ob_flush();
        parent::init();

    }

    public function getJourneyNotification() {
        if (!current_user_can('sq_manage_snippets')) {
            return;
        }

        //Get the user name
        $username = '';
        if(get_current_user_id()) {
            $user_info = get_userdata(get_current_user_id());
            if(!$username = $user_info->first_name){
                $username = $user_info->user_login;
            }
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_seojourney') && SQ_Classes_Helpers_Tools::getOption('sq_alert_journey')) {
            if ((time() - strtotime(SQ_Classes_Helpers_Tools::getOption('sq_installed'))) / (3600 * 24) > 4) { ?>
                <div class="alert alert-warning text-center m-0 mt-2 p-2">
                    <form method="post" class="p-0 m-0">
                        <?php SQ_Classes_Helpers_Tools::setNonce('sq_alerts_close', 'sq_nonce'); ?>
                        <input type="hidden" name="action" value="sq_alerts_close"/>
                        <input type="hidden" name="alert" value="sq_alert_journey"/>
                        <button type="submit" class="btn float-right bg-transparent p-0 m-0">x</button>
                    </form>
                    <?php echo sprintf(esc_html__("%s, why don't you start a two weeks journey for better rankings? %sStart driving your most valuable pages to Better Rankings today with your current plan.%s", _SQ_PLUGIN_NAME_), '<strong>' . $username . '</strong>', '<br /><a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'journey1') . '" style="font-weight: bold;" >', '</a>'); ?>
                </div>
                <?php
            }
        }
    }


    public function getNotificationCompatibility() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_alert_overview') && SQ_Classes_Helpers_Tools::getOption('sq_api')) {
            add_filter('sq_plugins', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'getActivePlugins'));
            $platforms = apply_filters('sq_importList', false);
            if ($platforms && count((array)$platforms) > 0) {
                foreach ($platforms as $platform => $data) {
                    $plugin = SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($platform);
                    ?>
                    <div class="sq_offer alert alert-warning text-center m-0 mt-2 p-2">
                        <form method="post" class="p-0 m-0">
                            <?php SQ_Classes_Helpers_Tools::setNonce('sq_alerts_close', 'sq_nonce'); ?>
                            <input type="hidden" name="action" value="sq_alerts_close"/>
                            <input type="hidden" name="alert" value="sq_alert_overview"/>
                            <button type="submit" class="btn float-right bg-transparent p-0 m-0">x</button>
                        </form>
                        <?php echo sprintf(esc_html__("Detected %s: We encourage you to %sImport the Settings and SEO%s from %s and deactivate %s to increase the page loading speed for better Google ranking.", _SQ_PLUGIN_NAME_), '<strong>' . $plugin . '</strong>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'backup') . '" style="font-weight: bold;" >', '</a>', $plugin, $plugin); ?>
                    </div>
                    <?php
                    break;
                }
            }
        }
    }

}
