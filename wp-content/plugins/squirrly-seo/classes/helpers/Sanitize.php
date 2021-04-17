<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Classes_Helpers_Sanitize {
    /**
     * Clear the title string
     * @param $title
     * @return mixed|null|string|string[]
     */
    public static function clearTitle($title) {
        if ($title <> '') {
            if (function_exists('preg_replace')) {
                $search = array(
                    "/[\n\r]/si",
                    "/[\n]/si",
                    "/&nbsp;/si",
                    "/\[[^\]]+\]/si",
                    "/\s{2,}/",
                );
                $title = preg_replace($search, " ", $title);
            }

            $title = SQ_Classes_Helpers_Sanitize::i18n(trim(esc_html(ent2ncr(strip_tags($title)))));

        }
        return $title;
    }

    /**
     * Clear description
     * @param $description
     * @return null|string|string[]
     */
    public static function clearDescription($description) {
        if ($description <> '') {
            if (function_exists('preg_replace')) {
                $search = array("'<script[^>]*?>.*?<\/script>'si", // strip out javascript
                    "/<form.*?<\/form>/si",
                    "/<iframe.*?<\/iframe>/si",
                );
                $description = preg_replace($search, "", $description);
                $search = array(
                    "/[\n\r]/si",
                    "/[\n]/si",
                    "/&nbsp;/si",
                    "/\[[^\]]+\]/si",
                    "/\s{2,}/",
                );
                $description = preg_replace($search, " ", $description);
            }

            $description = SQ_Classes_Helpers_Sanitize::i18n(trim(esc_html(ent2ncr(strip_tags($description)))));
        }

        return $description;
    }

    /**
     * Clear the keywords
     * @param $keywords
     * @return mixed|null|string|string[]
     */
    public static function clearKeywords($keywords) {
        return self::clearTitle($keywords);
    }

    /**
     * Escape the keyword for tags and urls
     * @param $keyword
     * @param string $for
     * @return string|void
     */
    public static function escapeKeyword($keyword, $for = 'all') {
        switch ($for){
            case 'url':
                $keyword = urlencode(esc_attr($keyword));
                break;
            case 'attr':
                $keyword = htmlspecialchars(str_replace('"', '\"', $keyword));
                break;
            default:
                $keyword = esc_attr($keyword);
        }
        return $keyword;
    }

    /**
     * Truncate the text
     *
     * @param $text
     * @param int $min
     * @param int $max
     * @return bool|mixed|null|string|string[]
     */
    public static function truncate($text, $min = 100, $max = 110) {
        //make sure they are values
        $max = (int)$max;
        $min = (int)$min;

        if ($max > 0 && $text <> '' && strlen($text) > $max) {
            if (function_exists('strip_tags')) {
                $text = strip_tags($text);
            }

            $text = str_replace(']]>', ']]&gt;', $text);
            $text = preg_replace('/\[(.+?)\]/is', '', $text);

            if ($max < strlen($text)) {
                while ($text[$max] != ' ' && $max > $min) {
                    $max--;
                }
            }

            //Use internation truncate
            if (function_exists('mb_substr')) {
                $text = mb_substr($text, 0, $max);
            } else {
                $text = substr($text, 0, $max);
            }

            return trim(stripcslashes($text));
        }

        return $text;
    }

    /**
     * Replace language-specific characters by ASCII-equivalents.
     * @param string $s
     * @return string
     */
    public static function normalizeChars($s) {
        $replace = array(
            'ъ'=>'-', 'Ь'=>'-', 'Ъ'=>'-', 'ь'=>'-',
            'Ă'=>'A', 'Ą'=>'A', 'À'=>'A', 'Ã'=>'A', 'Á'=>'A', 'Æ'=>'A', 'Â'=>'A', 'Å'=>'A', 'Ä'=>'Ae',
            'Þ'=>'B',
            'Ć'=>'C', 'ץ'=>'C', 'Ç'=>'C',
            'È'=>'E', 'Ę'=>'E', 'É'=>'E', 'Ë'=>'E', 'Ê'=>'E',
            'Ğ'=>'G',
            'İ'=>'I', 'Ï'=>'I', 'Î'=>'I', 'Í'=>'I', 'Ì'=>'I',
            'Ł'=>'L',
            'Ñ'=>'N', 'Ń'=>'N',
            'Ø'=>'O', 'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'Oe',
            'Ş'=>'S', 'Ś'=>'S', 'Ș'=>'S', 'Š'=>'S',
            'Ț'=>'T',
            'Ù'=>'U', 'Û'=>'U', 'Ú'=>'U', 'Ü'=>'Ue',
            'Ý'=>'Y',
            'Ź'=>'Z', 'Ž'=>'Z', 'Ż'=>'Z',
            'â'=>'a', 'ǎ'=>'a', 'ą'=>'a', 'á'=>'a', 'ă'=>'a', 'ã'=>'a', 'Ǎ'=>'a', 'а'=>'a', 'А'=>'a', 'å'=>'a', 'à'=>'a', 'א'=>'a', 'Ǻ'=>'a', 'Ā'=>'a', 'ǻ'=>'a', 'ā'=>'a', 'ä'=>'ae', 'æ'=>'ae', 'Ǽ'=>'ae', 'ǽ'=>'ae',
            'б'=>'b', 'ב'=>'b', 'Б'=>'b', 'þ'=>'b',
            'ĉ'=>'c', 'Ĉ'=>'c', 'Ċ'=>'c', 'ć'=>'c', 'ç'=>'c', 'ц'=>'c', 'צ'=>'c', 'ċ'=>'c', 'Ц'=>'c', 'Č'=>'c', 'č'=>'c', 'Ч'=>'ch', 'ч'=>'ch',
            'ד'=>'d', 'ď'=>'d', 'Đ'=>'d', 'Ď'=>'d', 'đ'=>'d', 'д'=>'d', 'Д'=>'D', 'ð'=>'d',
            'є'=>'e', 'ע'=>'e', 'е'=>'e', 'Е'=>'e', 'Ə'=>'e', 'ę'=>'e', 'ĕ'=>'e', 'ē'=>'e', 'Ē'=>'e', 'Ė'=>'e', 'ė'=>'e', 'ě'=>'e', 'Ě'=>'e', 'Є'=>'e', 'Ĕ'=>'e', 'ê'=>'e', 'ə'=>'e', 'è'=>'e', 'ë'=>'e', 'é'=>'e',
            'ф'=>'f', 'ƒ'=>'f', 'Ф'=>'f',
            'ġ'=>'g', 'Ģ'=>'g', 'Ġ'=>'g', 'Ĝ'=>'g', 'Г'=>'g', 'г'=>'g', 'ĝ'=>'g', 'ğ'=>'g', 'ג'=>'g', 'Ґ'=>'g', 'ґ'=>'g', 'ģ'=>'g',
            'ח'=>'h', 'ħ'=>'h', 'Х'=>'h', 'Ħ'=>'h', 'Ĥ'=>'h', 'ĥ'=>'h', 'х'=>'h', 'ה'=>'h',
            'î'=>'i', 'ï'=>'i', 'í'=>'i', 'ì'=>'i', 'į'=>'i', 'ĭ'=>'i', 'ı'=>'i', 'Ĭ'=>'i', 'И'=>'i', 'ĩ'=>'i', 'ǐ'=>'i', 'Ĩ'=>'i', 'Ǐ'=>'i', 'и'=>'i', 'Į'=>'i', 'י'=>'i', 'Ї'=>'i', 'Ī'=>'i', 'І'=>'i', 'ї'=>'i', 'і'=>'i', 'ī'=>'i', 'ĳ'=>'ij', 'Ĳ'=>'ij',
            'й'=>'j', 'Й'=>'j', 'Ĵ'=>'j', 'ĵ'=>'j', 'я'=>'ja', 'Я'=>'ja', 'Э'=>'je', 'э'=>'je', 'ё'=>'jo', 'Ё'=>'jo', 'ю'=>'ju', 'Ю'=>'ju',
            'ĸ'=>'k', 'כ'=>'k', 'Ķ'=>'k', 'К'=>'k', 'к'=>'k', 'ķ'=>'k', 'ך'=>'k',
            'Ŀ'=>'l', 'ŀ'=>'l', 'Л'=>'l', 'ł'=>'l', 'ļ'=>'l', 'ĺ'=>'l', 'Ĺ'=>'l', 'Ļ'=>'l', 'л'=>'l', 'Ľ'=>'l', 'ľ'=>'l', 'ל'=>'l',
            'מ'=>'m', 'М'=>'m', 'ם'=>'m', 'м'=>'m',
            'ñ'=>'n', 'н'=>'n', 'Ņ'=>'n', 'ן'=>'n', 'ŋ'=>'n', 'נ'=>'n', 'Н'=>'n', 'ń'=>'n', 'Ŋ'=>'n', 'ņ'=>'n', 'ŉ'=>'n', 'Ň'=>'n', 'ň'=>'n',
            'о'=>'o', 'О'=>'o', 'ő'=>'o', 'õ'=>'o', 'ô'=>'o', 'Ő'=>'o', 'ŏ'=>'o', 'Ŏ'=>'o', 'Ō'=>'o', 'ō'=>'o', 'ø'=>'o', 'ǿ'=>'o', 'ǒ'=>'o', 'ò'=>'o', 'Ǿ'=>'o', 'Ǒ'=>'o', 'ơ'=>'o', 'ó'=>'o', 'Ơ'=>'o', 'œ'=>'oe', 'Œ'=>'oe', 'ö'=>'oe',
            'פ'=>'p', 'ף'=>'p', 'п'=>'p', 'П'=>'p',
            'ק'=>'q',
            'ŕ'=>'r', 'ř'=>'r', 'Ř'=>'r', 'ŗ'=>'r', 'Ŗ'=>'r', 'ר'=>'r', 'Ŕ'=>'r', 'Р'=>'r', 'р'=>'r',
            'ș'=>'s', 'с'=>'s', 'Ŝ'=>'s', 'š'=>'s', 'ś'=>'s', 'ס'=>'s', 'ş'=>'s', 'С'=>'s', 'ŝ'=>'s', 'Щ'=>'sch', 'щ'=>'sch', 'ш'=>'sh', 'Ш'=>'sh', 'ß'=>'ss',
            'т'=>'t', 'ט'=>'t', 'ŧ'=>'t', 'ת'=>'t', 'ť'=>'t', 'ţ'=>'t', 'Ţ'=>'t', 'Т'=>'t', 'ț'=>'t', 'Ŧ'=>'t', 'Ť'=>'t', '™'=>'tm',
            'ū'=>'u', 'у'=>'u', 'Ũ'=>'u', 'ũ'=>'u', 'Ư'=>'u', 'ư'=>'u', 'Ū'=>'u', 'Ǔ'=>'u', 'ų'=>'u', 'Ų'=>'u', 'ŭ'=>'u', 'Ŭ'=>'u', 'Ů'=>'u', 'ů'=>'u', 'ű'=>'u', 'Ű'=>'u', 'Ǖ'=>'u', 'ǔ'=>'u', 'Ǜ'=>'u', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'У'=>'u', 'ǚ'=>'u', 'ǜ'=>'u', 'Ǚ'=>'u', 'Ǘ'=>'u', 'ǖ'=>'u', 'ǘ'=>'u', 'ü'=>'ue',
            'в'=>'v', 'ו'=>'v', 'В'=>'v',
            'ש'=>'w', 'ŵ'=>'w', 'Ŵ'=>'w',
            'ы'=>'y', 'ŷ'=>'y', 'ý'=>'y', 'ÿ'=>'y', 'Ÿ'=>'y', 'Ŷ'=>'y',
            'Ы'=>'y', 'ž'=>'z', 'З'=>'z', 'з'=>'z', 'ź'=>'z', 'ז'=>'z', 'ż'=>'z', 'ſ'=>'z', 'Ж'=>'zh', 'ж'=>'zh'
        );
        return strtr($s, $replace);
    }

    /**
     * Check the google code saved at settings
     *
     * @param string $code
     * @return string
     */
    public static function checkGoogleWTCode($code) {
        if ($code <> '') {
            $code = stripslashes($code);
            if (strpos($code, 'content') !== false) {
                preg_match('/content\\s*=\\s*[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }
            if (strpos($code, '"') !== false) {
                preg_match('/[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if ($code == '') SQ_Classes_Error::setError(esc_html__("The code for Google Webmaster Tool is incorrect.", _SQ_PLUGIN_NAME_));
        }
        return $code;
    }

    /**
     * Check the google code saved at settings
     *
     * @param string $code
     * @return string
     */
    public static function checkGoogleAnalyticsCode($code) {
        if ($code <> '') {
            $code = stripslashes($code);

            if (strpos($code, 'GoogleAnalyticsObject') !== false) {
                preg_match('/ga\(\'create\',[^\'"]*[\'"]([^\'"]+)[\'"],/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if (strpos($code, '"') !== false) {
                preg_match('/[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if (strpos($code, 'UA-') === false && strpos($code, 'G-') === false) {
                $code = '';
                SQ_Classes_Error::setError(esc_html__("The code for Google Analytics is incorrect.", _SQ_PLUGIN_NAME_));
            }
        }
        return trim($code);
    }

    /**
     * Check the Facebook code saved at settings
     *
     * @param string $code
     * @return string
     */
    public static function checkFacebookAdminCode($code) {
        if ($code <> '') {
            $code = trim($code);

            if (strpos($code, 'facebook.com/') !== false) {
                preg_match('/facebook.com\/([^\/]+)/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) {
                    if (is_string($result[1])) {
                        $response = SQ_Classes_RemoteController::getFacebookApi(array('profile' => $result[1]));
                        if (!is_wp_error($response) && isset($response->code)) {
                            return $response->code;
                        }
                    } elseif (is_numeric($result[1])) {
                        return $result[1];
                    }
                }
            } elseif ($code <> (int)$code) {
                $response = SQ_Classes_RemoteController::getFacebookApi(array('profile' => $code));
                if (!is_wp_error($response) && isset($response->code)) {
                    return $response->code;
                }
            } else {
                return $code;
            }

            SQ_Classes_Error::setError(esc_html__("The code for Facebook is incorrect.", _SQ_PLUGIN_NAME_));

        }
        return false;
    }

    /**
     * Check the Pinterest code saved at settings
     *
     * @param string $code
     * @return string
     */
    public static function checkPinterestCode($code) {
        if ($code <> '') {
            $code = stripslashes($code);

            if (strpos($code, 'content') !== false) {
                preg_match('/content\\s*=\\s*[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if (strpos($code, '"') !== false) {
                preg_match('/[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if ($code == '') SQ_Classes_Error::setError(esc_html__("The code for Pinterest is incorrect.", _SQ_PLUGIN_NAME_));
        }
        return $code;
    }

    /**
     * Check the Bing code saved at settings
     *
     * @return string
     */
    public static function checkBingWTCode($code) {
        if ($code <> '') {
            $code = stripslashes($code);


            if (strpos($code, 'content') !== false) {
                preg_match('/content\\s*=\\s*[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if (strpos($code, '"') !== false) {
                preg_match('/[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if ($code == '') SQ_Classes_Error::setError(esc_html__("The code for Bing is incorrect.", _SQ_PLUGIN_NAME_));
        }
        return $code;
    }

    /**
     * Check the Baidu code saved at settings
     *
     * @return string
     */
    public static function checkBaiduWTCode($code) {
        if ($code <> '') {
            $code = stripslashes($code);


            if (strpos($code, 'content') !== false) {
                preg_match('/content\\s*=\\s*[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if (strpos($code, '"') !== false) {
                preg_match('/[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if ($code == '') SQ_Classes_Error::setError(esc_html__("The code for Baidu is incorrect.", _SQ_PLUGIN_NAME_));
        }
        return $code;
    }

    /**
     * Check the Yandex code saved at settings
     *
     * @return string
     */
    public static function checkYandexWTCode($code) {
        if ($code <> '') {
            $code = stripslashes($code);


            if (strpos($code, 'content') !== false) {
                preg_match('/content\\s*=\\s*[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if (strpos($code, '"') !== false) {
                preg_match('/[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if ($code == '') SQ_Classes_Error::setError(esc_html__("The code for Yandex is incorrect.", _SQ_PLUGIN_NAME_));
        }
        return $code;
    }

    /**
     * Check the Alexa code saved at settings
     *
     * @return string
     */
    public static function checkAlexaCode($code) {
        if ($code <> '') {
            $code = stripslashes($code);


            if (strpos($code, 'content') !== false) {
                preg_match('/content\\s*=\\s*[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if (strpos($code, '"') !== false) {
                preg_match('/[\"]([^\"]+)[\"]/i', $code, $result);
                if (isset($result[1]) && !empty($result[1])) $code = $result[1];
            }

            if ($code == '') SQ_Classes_Error::setError(esc_html__("The code for Alexa is incorrect.", _SQ_PLUGIN_NAME_));
        }
        return $code;
    }

    /**
     * Check the twitter account
     *
     * @param string $account
     * @return string
     */
    public static function checkTwitterAccount($account) {
        if ($account <> '' && strpos($account, '//') === false) {
            $account = 'https://twitter.com/' . $account;
        }

        return $account;
    }

    /**
     * Check the twitter account
     *
     * @param string $account
     * @return string
     */
    public static function checkTwitterAccountName($account) {
        if ($account <> '' && strpos($account, '//') !== false) {
            $account = parse_url($account, PHP_URL_PATH);
            if ($account <> '') {
                $account = str_replace('/', '', $account);
            }
            if (strpos($account, '@') == false) {
                $account = '@' . $account;
            }
        }

        return $account;
    }

    /**
     * Check the google + account
     *
     * @param string $account
     * @return string
     */
    public static function checkGoogleAccount($account) {
        if ($account <> '' && strpos($account, '//') === false) {
            $account = 'https://plus.google.com/' . $account;
        }
        return str_replace(" ", "+", $account);
    }

    /**
     * Check the google + account
     *
     * @param string $account
     * @return string
     */
    public static function checkLinkeinAccount($account) {
        if ($account <> '' && strpos($account, '//') === false) {
            $account = 'https://www.linkedin.com/in/' . $account;
        }
        return $account;
    }

    /**
     * Check the facebook account
     *
     * @param string $account
     * @return string
     */
    public static function checkFacebookAccount($account) {
        if ($account <> '' && strpos($account, '//') === false) {
            $account = 'https://www.facebook.com/' . $account;
        }
        return $account;
    }

    /**
     * Check the Pinterest account
     * @param $account
     * @return string
     */
    public static function checkPinterestAccount($account) {
        if ($account <> '' && strpos($account, '//') === false) {
            $account = 'https://www.pinterest.com/' . $account;
        }
        return $account;
    }

    /**
     * Check the Instagram
     *
     * @param $account
     * @return string
     */
    public static function checkInstagramAccount($account) {
        if ($account <> '' && strpos($account, '//') === false) {
            $account = 'https://www.instagram.com/' . $account;
        }
        return $account;
    }

    /**
     * Check the Youtube account
     *
     * @param $account
     * @return string
     */
    public static function checkYoutubeAccount($account) {
        if ($account <> '' && strpos($account, '//') === false) {
            if (strpos($account, 'user/') === false && strpos($account, 'channel/') === false) {
                $account = 'https://www.youtube.com/channel/' . $account;
            }
        }
        return $account;
    }

    /**
     * Check the Facebook Pixel code
     *
     * @return string
     */
    public static function checkFacebookPixel($code) {
        if ($code <> '') {
            if ((int)$code == 0) {
                SQ_Classes_Error::setError(esc_html__("The code for Facebook Pixel must only contain numbers.", _SQ_PLUGIN_NAME_));
                $code = '';
            }
        }
        return $code;
    }

    /**
     * Check the Facebook App code
     *
     * @return string
     */
    public static function checkFacebookApp($code) {
        if ($code <> '') {
            if ((int)$code == 0) {
                SQ_Classes_Error::setError(esc_html__("The code for Facebook App must only contain numbers.", _SQ_PLUGIN_NAME_));
                $code = '';
            }
        }
        return $code;
    }

    /**
     * Support for i18n with wpml, polyglot or qtrans
     *
     * @param string $in
     * @return string $in localized
     */
    public static function i18n($in) {
        if (function_exists('langswitch_filter_langs_with_message')) {
            $in = langswitch_filter_langs_with_message($in);
        }
        if (function_exists('polyglot_filter')) {
            $in = polyglot_filter($in);
        }
        if (function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')) {
            $in = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($in);
        }
        $in = apply_filters('localization', $in);
        return $in;
    }
}