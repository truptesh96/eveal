<?php

class SQ_Models_Services_Verify extends SQ_Models_Abstract_Seo {


    public function __construct() {
        parent::__construct();

        if (isset($this->_post->sq->doseo) && $this->_post->sq->doseo) {
            add_filter('sq_verify', array($this, 'generateVerify'));
            add_filter('sq_verify', array($this, 'packVerify'), 99);
        } else {
            add_filter('sq_verify', array($this, 'returnFalse'));
        }
    }

    public function generateVerify($metas = array()) {
        $codes = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('codes')));

        if ($this->_post->post_type == 'home') {
            if (isset($codes->google_wt) && $codes->google_wt <> '') {
                $metas['google-site-verification'] = $codes->google_wt;
            }
            if (isset($codes->bing_wt) && $codes->bing_wt <> '') {
                $metas['msvalidate.01'] = $codes->bing_wt;
            }
            if (isset($codes->baidu_wt) && $codes->baidu_wt <> '') {
                $metas['baidu-site-verification'] = $codes->baidu_wt;
            }
            if (isset($codes->yandex_wt) && $codes->yandex_wt <> '') {
                $metas['yandex-verification'] = $codes->yandex_wt;
            }
            if (isset($codes->pinterest_verify) && $codes->pinterest_verify <> '') {
                $metas['p:domain_verify'] = $codes->pinterest_verify;
            }
            if (isset($codes->norton_verify) && $codes->norton_verify <> '') {
                $metas['norton-safeweb-site-verification'] = $codes->norton_verify;
            }
        }

        if (isset($codes->alexa_verify) && $codes->alexa_verify <> '') {
            $metas['alexaVerifyID'] = $codes->alexa_verify;
        }

        return $metas;
    }

    public function packVerify($metas = array()) {
        if (!empty($metas)) {
            foreach ($metas as $key => &$value) {
                $value = '<meta name="' . $key . '" content="' . $value . '" />';
            }
            return "\n" . join("\n", array_values($metas));
        }

        return false;
    }
}