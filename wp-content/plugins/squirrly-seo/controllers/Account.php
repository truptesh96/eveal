<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * User Account
 */
class SQ_Controllers_Account extends SQ_Classes_FrontController {

    /** @var object Checkin process */
    public $checkin;

    public function action() {

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_ajax_account_getaccount':
                $json = array();

                $this->checkin = SQ_Classes_RemoteController::checkin();

                if (!is_wp_error($this->checkin)) {

                    $json['html'] = $this->getView('Blocks/Account');

                    if (SQ_Classes_Helpers_Tools::isAjax()) {
                        SQ_Classes_Helpers_Tools::setHeader('json');

                        if (SQ_Classes_Error::isError()) {
                            $json['error'] = SQ_Classes_Error::getError();
                        }

                        echo wp_json_encode($json);
                        exit();
                    }

                }
                break;
        }
    }
}
