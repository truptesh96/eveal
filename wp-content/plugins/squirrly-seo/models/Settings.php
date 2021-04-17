<?php

class SQ_Models_Settings {

    /**
     * Save the Values in database
     * @param $params
     */
    public function saveValues($params) {
        //Save the option values
        foreach ($params as $key => $value) {
            if (in_array($key, array_keys(SQ_Classes_Helpers_Tools::$options))) {

                //Initialize the array for some options
                if (in_array($key, array('sq_sla_exclude_post_types'))) {
                    SQ_Classes_Helpers_Tools::$options[$key] = array();
                }

                if (is_array(SQ_Classes_Helpers_Tools::$options[$key])) {

                    //Sanitize each value from subarray
                    $array = SQ_Classes_Helpers_Tools::getValue($key);

                    //Save the array values
                    if (is_array($array)) {
                        if (!empty($array)) {
                            foreach ($array as $subkey => $subvalue) {
                                switch ($subkey) {
                                    case 'google_wt':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkGoogleWTCode($value[$subkey]);
                                        break;
                                    case 'bing_wt':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkBingWTCode($value[$subkey]);
                                        break;
                                    case 'baidu_wt':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkBaiduWTCode($value[$subkey]);
                                        break;
                                    case 'yandex_wt':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkYandexWTCode($value[$subkey]);
                                        break;
                                    case 'pinterest_verify':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkPinterestCode($value[$subkey]);
                                        break;
                                    case 'google_analytics':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkGoogleAnalyticsCode($value[$subkey]);
                                        break;
                                    case 'alexa_verify':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkAlexaCode($value[$subkey]);
                                        break;
                                    case 'facebook_pixel':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkFacebookPixel($value[$subkey]);
                                        break;
                                    case 'twitter_site':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkTwitterAccount($value[$subkey]);
                                        SQ_Classes_Helpers_Tools::$options[$key]['twitter'] = SQ_Classes_Helpers_Sanitize::checkTwitterAccountName($value[$subkey]);
                                        break;
                                    case 'facebook_site':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkFacebookAccount($value[$subkey]);
                                        break;
                                    case 'pinterest_url':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkPinterestAccount($value[$subkey]);
                                        break;
                                    case 'instagram_url':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkInstagramAccount($value[$subkey]);
                                        break;
                                    case 'linkedin_url':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkLinkeinAccount($value[$subkey]);
                                        break;
                                    case 'youtube_url':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkYoutubeAccount($value[$subkey]);
                                        break;
                                    case 'fb_admins':
                                        if (is_array($value[$subkey]) && !empty($value[$subkey])) {
                                            foreach ($value[$subkey] as $index => $admin) {
                                                $value[$subkey][$index] = SQ_Classes_Helpers_Sanitize::checkFacebookAdminCode($admin);
                                            }

                                            $subvalue = $value[$subkey];
                                        }
                                        break;
                                    case 'fbadminapp':
                                        $subvalue = SQ_Classes_Helpers_Sanitize::checkFacebookApp($value[$subkey]);
                                        break;
                                }
                                SQ_Classes_Helpers_Tools::$options[$key][$subkey] = $subvalue;
                            }
                        }
                    }

                    //print_R(SQ_Classes_Helpers_Tools::$options[$key]);
                    //sanitize the value and save it
                    SQ_Classes_Helpers_Tools::saveOptions();
                } else {

                    //sanitize the value and save it
                    SQ_Classes_Helpers_Tools::saveOptions($key, SQ_Classes_Helpers_Tools::getValue($key));
                }
            }
        }
    }


}