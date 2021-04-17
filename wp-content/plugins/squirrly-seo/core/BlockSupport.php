<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockSupport extends SQ_Classes_BlockController {

    public function init() {
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('support');

        echo $this->getView('Blocks/Support');
    }

    /**
     * Called when Post action is triggered
     *
     * @return void
     */
    public function action() {
        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_feedback':
                $return = array();

                $feedback = SQ_Classes_Helpers_Tools::getValue('feedback', false);

                if ($feedback) {
                    SQ_Classes_Helpers_Tools::saveOptions('sq_feedback', 1);

                    $args['action'] = 'feedback';
                    $args['value'] = $feedback;
                    SQ_Classes_RemoteController::saveFeedback($args);

                    $return['message'] = esc_html__("Thank you for your feedback.", _SQ_PLUGIN_NAME_);
                    $return['success'] = true;

                } else {
                    $return['message'] = esc_html__("No message.", _SQ_PLUGIN_NAME_);
                    $return['error'] = true;
                }

                SQ_Classes_Helpers_Tools::setHeader('json');
                echo wp_json_encode($return);
                exit();

            case 'sq_uninstall_feedback':
                $reason['select'] = SQ_Classes_Helpers_Tools::getValue('reason_key', false);
                $reason['plugin'] = SQ_Classes_Helpers_Tools::getValue('reason_found_a_better_plugin', false);
                $reason['other'] = SQ_Classes_Helpers_Tools::getValue('reason_other', false);

                $args['action'] = 'deactivate';
                $args['value'] = json_encode($reason);
                SQ_Classes_RemoteController::saveFeedback($args);

                if (SQ_Classes_Helpers_Tools::getValue('option_remove_records', false)) {
                    SQ_Classes_Helpers_Tools::saveOptions('sq_api', false);
                }

                SQ_Classes_Helpers_Tools::setHeader('json');
                echo wp_json_encode(array());
                exit();
        }
        exit();
    }

}
