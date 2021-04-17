<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Classes_Error extends SQ_Classes_FrontController {

    /** @var array */
    private static $errors = array();
    private static $switch_off = array();

    public function __construct() {
        parent::__construct();

        add_action('sq_notices', array('SQ_Classes_Error', 'hookNotices'));
    }

    /**
     * Get the error message
     * @return int
     */
    public static function getError() {
        if (count(self::$errors) > 0) {
            return self::$errors[0]['text'];
        }

        return false;
    }

    /**
     * Clear all the Errors from Squirrly SEO
     */
    public static function clearErrors() {
        self::$errors = array();
    }

    /**
     * Show the error in wrodpress
     *
     * @param string $error
     * @param string $type
     * @param string $id
     */
    public static function setError($error = '', $type = 'notice', $id = '') {
        self::$errors[] = array(
            'id' => $id,
            'type' => $type,
            'text' => $error);
    }

    /**
     * Check if there is a Squirrly Error triggered
     * @return bool
     */
    public static function isError() {
        if(!empty(self::$errors)){
            foreach (self::$errors as $error){
                if($error['type'] <> 'success' ){
                    return true;
                }
            }
        }
    }

    /**
     * Set a success message
     * @param string $message
     * @param string $id
     */
    public static function setMessage($message = '', $id = '') {
        self::$errors[] = array(
            'id' => $id,
            'type' => 'success',
            'text' => $message);
    }

    /**
     * This hook will show the error in WP header
     */
    public static function hookNotices() {
        if (is_array(self::$errors))
            foreach (self::$errors as $error) {

                switch ($error['type']) {
                    case 'fatal':
                        self::showError(ucfirst(_SQ_PLUGIN_NAME_ . " " . $error['type']) . ': ' . $error['text'], $error['id']);
                        die();
                        break;
                    case 'settings':
                        /* switch off option for notifications */
                        self::showError($error['text'] . " ", $error['id']);
                        break;

                    case 'success':
                        self::showError($error['text'] . " ", $error['id'], 'sq_success');
                        break;

                    default:
                        self::showError($error['text'], $error['id']);
                }
            }
    }

    /**
     * Show the notices to WP
     *
     * @param $message
     * @param string $type
     * @return string
     */
    public static function showNotices($message, $type = 'sq_notices') {
        if (file_exists(_SQ_THEME_DIR_ . 'Notices.php')) {
            ob_start();
            include(_SQ_THEME_DIR_ . 'Notices.php');
            $message = ob_get_contents();
            ob_end_clean();
        }

        return (string)$message;
    }

    /**
     * Show the notices to WP
     *
     * @param $message
     * @param string $id
     * @param string $type
     *
     * return void
     */
    public static function showError($message, $id = '', $type = 'sq_error') {
        if (file_exists(_SQ_THEME_DIR_ . 'Notices.php')) {
            include(_SQ_THEME_DIR_ . 'Notices.php');
        }
    }


}
