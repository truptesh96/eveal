<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockConnect extends SQ_Classes_BlockController {

    public $message;

    public function init() {
        /* If logged in, then return */
        if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') {
            return;
        }

        echo $this->getView('Blocks/Connect');
    }

    /**
     * Called for sq_login on Post action
     * Login or register a user
     */
    public function action() {
        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            //sign-up action
            case 'sq_cloud_connect':
                $this->connectToCloud();
                break;

            case 'sq_cloud_disconnect':
                $this->disconnectFromCloud();
                break;
        }
    }

    public function connectToCloud() {
        if(function_exists('rest_get_url_prefix')){
            $apiUrl = trim(rest_get_url_prefix(),'/');
        }elseif(function_exists('rest_url')){
            $apiUrl = trim(parse_url(rest_url(),PHP_URL_PATH),'/');
        }

        if ($token = SQ_Classes_RemoteController::getCloudToken(array('wp-json' => $apiUrl))) {
            if(isset($token->token) && $token->token <> '') {
                SQ_Classes_Helpers_Tools::saveOptions('sq_cloud_token', $token->token);
                SQ_Classes_Helpers_Tools::saveOptions('sq_cloud_connect', 1);
            }
        }
    }

    public function disconnectFromCloud() {
        SQ_Classes_Helpers_Tools::saveOptions('sq_cloud_connect', 0);
    }
}
