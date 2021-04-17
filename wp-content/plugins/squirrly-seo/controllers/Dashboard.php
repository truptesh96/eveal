<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * Show on the WordPress Dashboard
 * Class SQ_Controllers_Dashboard
 */
class SQ_Controllers_Dashboard extends SQ_Classes_FrontController {


    public function dashboard() {

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('dashboard');
        if (is_rtl()) {
            SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('rtl');
        }

        add_action('sq_form_notices', array($this, 'getNotificationBar'));

        echo $this->getView('Blocks/Dashboard');
    }

    public function action() {
        parent::action();

        if (!current_user_can('sq_manage_snippets')) {
            return;
        }

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_ajaxcheckseo':
                SQ_Classes_Helpers_Tools::setHeader('json');

                //Check all the SEO
                //Process all the tasks and save the report
                SQ_Classes_ObjController::getClass('SQ_Models_CheckSeo')->checkSEO();

                echo wp_json_encode(array('data' => $this->getView('Blocks/Dashboard')));
                exit();

        }
    }
}