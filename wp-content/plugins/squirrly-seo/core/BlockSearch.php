<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockSearch extends SQ_Classes_BlockController {

    public function init() {
        SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('search');

        echo $this->getView('Blocks/Search');
    }

    public function action() {
        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_ajax_search':

                //SQ_Classes_Helpers_Tools::setHeader('json');
                $search_query = SQ_Classes_Helpers_Tools::getValue('search_query', '');

                $args = array();
                $args['action'] = 'lsvr-lore-ajax-search';
                $args['nonce'] = 'plugin_search';
                $args['search_query'] = $search_query;

                $parameters = "";
                foreach ($args as $key => $value) {
                    if ($value <> '') {
                        $parameters .= ($parameters == "" ? "" : "&") . $key . "=" . urlencode($value);
                    }
                }
                $url = 'https://howto.squirrly.co/wp-admin/admin-ajax.php' . "?" . $parameters;
                echo SQ_Classes_RemoteController::sq_wpcall($url, array('sslverify' => false, 'timeout' => 10));
                exit();
        }
    }

}
