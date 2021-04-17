<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_Blocklogin extends SQ_Classes_BlockController {

    public $message;

    public function init() {
        /* If logged in, then return */
        if (SQ_Classes_Helpers_Tools::getOption('sq_api') <> '') {
            return;
        }

        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('login');
        SQ_Classes_Error::hookNotices();
        echo $this->getView('Blocks/Login');
    }

    /**
     * Called for sq_login on Post action
     * Login or register a user
     */
    public function action() {
        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            //login action
            case 'sq_login':
                $this->squirrlyLogin();
                break;

            //sign-up action
            case 'sq_register':
                $this->squirrlyRegister();
                break;
        }
    }

    /**
     * Register a new user to Squirrly and get the token
     * @global string $current_user
     */
    public function squirrlyRegister() {
        //if email is set
        if (SQ_Classes_Helpers_Tools::getIsset('email')) {
            //post arguments
            $args = array();
            $args['name'] = '';
            $args['user'] = SQ_Classes_Helpers_Tools::getValue('email');

            //create an object from json responce
            $responce = SQ_Classes_RemoteController::register($args);
            if (is_wp_error($responce)) {
                switch ($responce->get_error_message()) {
                    case 'alreadyregistered':
                        SQ_Classes_Error::setError(sprintf(esc_html__("We found your email, so it means you already have a Squirrly.co account. %sClick %sI already have an account%s and login. If you forgot your password, click %shere%s", _SQ_PLUGIN_NAME_), '<br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard', 'login') . '" style="color:yellow">', '</a>', '<a href="' . _SQ_DASH_URL_ . '/login?action=lostpassword" target="_blank" style="color:yellow">', '</a>'));
                        break;
                    case 'invalidemail':
                        SQ_Classes_Error::setError(esc_html__("Your email is not valid. Please enter a valid email.", _SQ_PLUGIN_NAME_));
                        break;
                    default:
                        if (!SQ_Classes_Error::isError()) {
                            SQ_Classes_Error::setError(esc_html__("We could not create your account. Please enter a valid email.", _SQ_PLUGIN_NAME_));
                        }
                        break;
                }

            } elseif (isset($responce->token)) { //check if token is set and save it
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', $responce->token);

                //Connect to cloud with an unique Token for API access
                SQ_Classes_ObjController::getClass('SQ_Core_BlockConnect')->connectToCloud();

                //redirect users to onboarding if necessary
                if (!$onboarding = SQ_Classes_Helpers_Tools::getOption('sq_onboarding')) {
                    wp_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding'));
                    die();
                } else {
                    wp_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard'));
                    die();
                }

            } elseif (!SQ_Classes_Error::isError()) {
                //if unknown error
                SQ_Classes_Error::setError(sprintf(esc_html__("Error: Couldn't connect to host :( . Please contact your site's webhost (or webmaster) and request them to add %s to their IP whitelist.", _SQ_PLUGIN_NAME_), _SQ_APIV2_URL_));
            }
        } else {
            SQ_Classes_Error::setError(esc_html__("Your email is not set. Please enter a valid email.", _SQ_PLUGIN_NAME_));
        }
    }

    /**
     * Login a user to Squirrly and get the token
     */
    public function squirrlyLogin() {
        //if email is set
        if (SQ_Classes_Helpers_Tools::getIsset('email') && SQ_Classes_Helpers_Tools::getIsset('password') && isset($_POST['password'])) {
            //get the user and password
            $args['user'] = SQ_Classes_Helpers_Tools::getValue('email');
            $args['password'] = $_POST['password'];

            //get the responce from server on login call
            /** @var bool|WP_Error $responce */
            $responce = SQ_Classes_RemoteController::login($args);

            /**  */
            if (is_wp_error($responce)) {
                switch ($responce->get_error_message()) {
                    case 'badlogin':
                        SQ_Classes_Error::setError(esc_html__("Wrong email or password!", _SQ_PLUGIN_NAME_));
                        break;
                    case 'multisite':
                        SQ_Classes_Error::setError(esc_html__("You can only use this account for the URL you registered first!", _SQ_PLUGIN_NAME_));
                        break;
                    case 'disconnected':
                        SQ_Classes_Error::setError(esc_html__("You disconnected your website from", _SQ_PLUGIN_NAME_) . ' ' . _SQ_DASH_URL_);
                        break;
                    default:
                        if (!SQ_Classes_Error::isError()) {
                            SQ_Classes_Error::setError(esc_html__("An error occured.", _SQ_PLUGIN_NAME_) . ':' . $responce->get_error_message());
                        }
                        break;
                }

            } elseif (isset($responce->token)) { //check if token is set and save it
                SQ_Classes_Helpers_Tools::saveOptions('sq_api', $responce->token);

                //Connect to cloud with an unique Token for API access
                SQ_Classes_ObjController::getClass('SQ_Core_BlockConnect')->connectToCloud();

                //redirect users to onboarding if necessary
                if (!$onboarding = SQ_Classes_Helpers_Tools::getOption('sq_onboarding')) {
                    wp_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding'));
                    die();
                } else {
                    wp_redirect(SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard'));
                    die();
                }

            } elseif (!SQ_Classes_Error::isError()) {
                //if unknown error
                SQ_Classes_Error::setError(sprintf(esc_html__("Error: Couldn't connect to host :( . Please contact your site's webhost (or webmaster) and request them to add %s to their IP whitelist.", _SQ_PLUGIN_NAME_), _SQ_APIV2_URL_));
            }

        } else {
            SQ_Classes_Error::setError(esc_html__("Both fields are required.", _SQ_PLUGIN_NAME_));
        }

    }

}
