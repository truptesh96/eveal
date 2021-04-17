<?php

class SQ_Models_Bulkseo_Metas extends SQ_Models_Abstract_Assistant {

    protected $_category = 'metas';
    protected $_patterns;

    protected $_title_length;
    protected $_description_length;
    //
    protected $_title_maxlength = 75;
    protected $_description_maxlength = 255;
    protected $_keyword = false;
    protected $_loadpatterns = true;

    const TITLE_MINLENGTH = 10;
    const DESCRIPTION_MINLENGTH = 10;
    const CHARS_ERROR = 5;

    public function init() {
        parent::init();

        $metas = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('sq_metas')));
        $this->_title_maxlength = (int)$metas->title_maxlength;
        $this->_description_maxlength = (int)$metas->description_maxlength;

        $this->_keyword = $this->_post->sq->keywords;

        //Get all the patterns
        $this->_patterns = SQ_Classes_Helpers_Tools::getOption('patterns');

        //For post types who are not in automation, add the custom patterns
        if (!isset($this->_patterns[$this->_post->post_type])) {
            $this->_patterns[$this->_post->post_type] = $this->_patterns['custom'];
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern') ||
            isset($patterns[$this->_post->post_type]['do_pattern']) && !$this->_patterns[$this->_post->post_type]['do_pattern']) {
            $this->_loadpatterns = false;
        }

        if (function_exists('mb_strlen')) {
            $this->_title_length = mb_strlen(html_entity_decode(utf8_decode($this->_post->sq->title), ENT_QUOTES));
            $this->_description_length = mb_strlen(html_entity_decode(utf8_decode($this->_post->sq->description), ENT_QUOTES));
        } else {
            $this->_title_length = mb_strlen(html_entity_decode(utf8_decode($this->_post->sq->title), ENT_QUOTES));
            $this->_description_length = mb_strlen(html_entity_decode(utf8_decode($this->_post->sq->description), ENT_QUOTES));
        }

    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $this->_tasks[$this->_category] = array(
            'title_empty' => array(
                'title' => sprintf(esc_html__("Title not empty", _SQ_PLUGIN_NAME_), '<br /><br />'),
                'value_title' => esc_html__("Current Title", _SQ_PLUGIN_NAME_),
                'value' => $this->_post->sq->getClearedTitle(),
                'description' => sprintf(esc_html__("The title for this URL must not be empty. %s Write a title for this page. The title is very important because it shows up in the browser tab and in the Google listing for your page. %s The better you write the title, the more clicks you can get when people find your page on search engines.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
            'title_length' => array(
                'title' => sprintf(esc_html__("Title up to %s chars", _SQ_PLUGIN_NAME_), $this->_title_maxlength),
                'value_title' => esc_html__("Current Title Length", _SQ_PLUGIN_NAME_),
                'value' => $this->_title_length . ' ' . esc_html__("chars", _SQ_PLUGIN_NAME_),
                'description' => sprintf(esc_html__("Title has to be longer than %s chars and up to %s chars. %s You can change the title max length from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), self::TITLE_MINLENGTH, $this->_title_maxlength, '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '">', '</a>'),
            ),
            'keyword_title' => array(
                'title' => esc_html__("Keyword in title", _SQ_PLUGIN_NAME_),
                'value_title' => esc_html__("Snippet Keyword", _SQ_PLUGIN_NAME_),
                'value' => ($this->_keyword <> '' ? $this->_keyword : '<em>' . esc_html__("no keywords", _SQ_PLUGIN_NAME_) . '</em>'),
                'description' => sprintf(esc_html__("Your keyword must be present in the title of the page. %s It's a very important element through which you make sure that you connect the searcher's intent to the content on your page. %s If I'm looking for \"buy cheap smartwatch\" and you give me a page called \"Luna Presentation\", I will never click your page. Why? Because I might not know that Luna is a smartwatch designed by VectorWatch. %s \"Buy Cheap Smartwatch - Luna by VectorWatch\" would be a much better choice for a title.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'description_empty' => array(
                'title' => esc_html__("Description not empty", _SQ_PLUGIN_NAME_),
                'value_title' => esc_html__("Current Description", _SQ_PLUGIN_NAME_),
                'value' => $this->_post->sq->getClearedDescription(),
                'description' => sprintf(esc_html__("Meta descriptions are important for SEO on multiple search engines. %s You need to have a meta description for this URL. %s The better you write it, the higher the chances of people clicking on your listing when they find it on search engines.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
            'description_length' => array(
                'title' => sprintf(esc_html__("Description up to %s chars", _SQ_PLUGIN_NAME_), $this->_description_maxlength),
                'value_title' => esc_html__("Current Description Length", _SQ_PLUGIN_NAME_),
                'value' => $this->_description_length . ' ' . esc_html__("chars", _SQ_PLUGIN_NAME_),
                'description' => sprintf(esc_html__("Description has to be longer than %s chars and up to %s chars. %s You can change the description max length from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), self::DESCRIPTION_MINLENGTH, $this->_description_maxlength, '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '">', '</a>'),
            ),
            'keyword_description' => array(
                'title' => esc_html__("Keyword in description", _SQ_PLUGIN_NAME_),
                'value_title' => esc_html__("Snippet Keyword", _SQ_PLUGIN_NAME_),
                'value' => ($this->_keyword <> '' ? $this->_keyword : '<em>' . esc_html__("no keywords", _SQ_PLUGIN_NAME_) . '</em>'),
                'description' => sprintf(esc_html__("Same as with the title task. %s If a user reads the description of your page on Google, but cannot find the keyword they searched for in that text, then they'd have very low chances of actually clicking and visiting your page. %s They'd go to the next page ranked on Google for that keyword. %s Think about this: Google itself is trying more and more to display keywords in the description of the pages it brings to TOP 10. It's pretty clear they care a lot about this, because that's what people want to find on the search engine.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
            ),
            'keywords' => array(
                'title' => esc_html__("Meta Keywords (2-4 Words)", _SQ_PLUGIN_NAME_),
                'value_title' => esc_html__("Meta Keyword", _SQ_PLUGIN_NAME_),
                'value' => ($this->_post->sq->keywords <> '' ? $this->_post->sq->keywords : '<em>' . esc_html__("no meta keywords", _SQ_PLUGIN_NAME_) . '</em>'),
                'description' => esc_html__("Even if Meta keywords are not mandatory for Google, it's important for other search engines to find this meta and to index your post for these keywords.", _SQ_PLUGIN_NAME_),
            ),
            'canonical' => array(
                'title' => sprintf(esc_html__("Canonical Link", _SQ_PLUGIN_NAME_), $this->_title_maxlength),
                'value_title' => esc_html__("Current Link", _SQ_PLUGIN_NAME_),
                'value' => ((isset($this->_post->sq->canonical) && $this->_post->sq->canonical <> '') ? urldecode($this->_post->sq->canonical) : urldecode($this->_post->url)),
                'description' => sprintf(esc_html__("You don't have to set any canonical link if your post is not copied from another source. %s Squirrly will alert you if your canonical link is not the same with the current post's URL. %s The canonical link is used to tell search engines which URL is the original one. The original is the one that gets indexed and ranked.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
            ),
        );


    }

    public function getTitle($title) {
        if ($this->_error) {
            return esc_html__("Some Squirrly Metas are deactivated.", _SQ_PLUGIN_NAME_);
        }

        foreach ($this->_tasks[$this->_category] as $task) {
            if ($task['completed'] === false) {
                return esc_html__("Some Squirrly Metas are not set correctly. Click to open the Assistant in the right sidebar and follow the instructions.", _SQ_PLUGIN_NAME_);
            }
        }

        if ($this->_pattern) {
            return esc_html__("Some Squirrly Metas are generated automatically.", _SQ_PLUGIN_NAME_);
        }

        return esc_html__("All Squirrly Metas are customized and set correctly.", _SQ_PLUGIN_NAME_);

    }

    /*********************************************/
    /**
     * Show Current Post
     * @return string
     */
    public function getHeader() {
        $header = '';
        $header .= '<li class="completed">' . $this->getCurrentURL($this->_post->url) . '</li>';

        $header .= '<li class="completed">';
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords')) {
            $header .= $this->getUsedKeywords();
        }
        $header .= '</li>';

        return $header;
    }


    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkTitle_empty($task) {
        $errors = array();
        if (!$this->_post->sq->doseo) {
            $errors[] = esc_html__("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(esc_html__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_title')) {
            $errors[] = sprintf(esc_html__("Meta Title is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(esc_html__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq_adm->title == '') {
            $task['error_message'] = esc_html__("Title is generated automatically.", _SQ_PLUGIN_NAME_);
            $task['pattern'] = true;
        }

        $task['completed'] = ($this->_post->sq->title <> '');

        return $task;
    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkTitle_length($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = esc_html__("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(esc_html__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_title')) {
            $errors[] = sprintf(esc_html__("Meta Title is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(esc_html__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq_adm->title == '') {
            $task['error_message'] = esc_html__("Title is generated automatically.", _SQ_PLUGIN_NAME_);
            $task['pattern'] = true;
        }

        $task['completed'] = ($this->_title_length > self::TITLE_MINLENGTH && $this->_title_length < ((int)$this->_title_maxlength + self::CHARS_ERROR));

        return $task;

    }

    public function checkKeyword_title($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = esc_html__("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(esc_html__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_title')) {
            $errors[] = sprintf(esc_html__("Meta Title is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(esc_html__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords')) {
            $errors[] = sprintf(esc_html__("Meta Keywords is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq->title <> '') {
            $keywords = preg_split('/,/', $this->_keyword);
            if (!empty($keywords)) {
                foreach ($keywords as $keyword) {
                    if ($keyword <> '' && (SQ_Classes_Helpers_Tools::findStr($this->_post->sq->title, trim($keyword)) !== false)) {
                        $task['completed'] = true;
                        return $task;
                    }
                }
            }
        }

        $task['completed'] = false;

        return $task;

    }

    public function checkDescription_empty($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = esc_html__("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(esc_html__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_description')) {
            $errors[] = sprintf(esc_html__("Meta Description is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(esc_html__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq_adm->description == '') {
            $task['error_message'] = esc_html__("Description is generated automatically.", _SQ_PLUGIN_NAME_);
            $task['pattern'] = true;
        }

        $task['completed'] = ($this->_post->sq->description <> '');

        return $task;
    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkDescription_length($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = esc_html__("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(esc_html__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_description')) {
            $errors[] = sprintf(esc_html__("Meta Description is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(esc_html__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }


        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq_adm->description == '') {
            $task['error_message'] = esc_html__("Description is generated automatically.", _SQ_PLUGIN_NAME_);
            $task['pattern'] = true;
        }

        $task['completed'] = ($this->_description_length > self::DESCRIPTION_MINLENGTH && $this->_description_length < ((int)$this->_description_maxlength + self::CHARS_ERROR));

        return $task;
    }

    public function checkKeyword_description($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = esc_html__("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(esc_html__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_description')) {
            $errors[] = sprintf(esc_html__("Meta Description is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(esc_html__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords')) {
            $errors[] = sprintf(esc_html__("Meta Keywords is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if ($this->_loadpatterns && $this->_post->sq->description <> '') {
            $keywords = preg_split('/,/', $this->_keyword);

            if (!empty($keywords)) {
                foreach ($keywords as $keyword) {
                    if ($keyword <> '' && (SQ_Classes_Helpers_Tools::findStr($this->_post->sq->description, trim($keyword)) !== false)) {
                        $task['completed'] = true;
                        return $task;
                    }
                }
            }
        }
        $task['completed'] = false;

        return $task;

    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkKeywords($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = esc_html__("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(esc_html__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(esc_html__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords')) {
            $errors[] = sprintf(esc_html__("Meta Keywords is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        $keywords = preg_split('/,/', $this->_post->sq->keywords);
        foreach ($keywords as $keyword) {
            if ($keyword <> '' && $this->_strWordCount($keyword) >= 2) {
                $task['completed'] = true;
                return $task;
            }
        }

        $task['completed'] = false;

        return $task;
    }

    /**
     * API Keyword Research
     * @return bool|WP_Error
     */
    public function checkCanonical($task) {
        if (!$this->_post->sq->doseo) {
            $errors[] = esc_html__("Squirrly Snippet is deactivated from this post.", _SQ_PLUGIN_NAME_);
        }

        if (!$this->_post->sq->do_metas) {
            $errors[] = sprintf(esc_html__("SEO Metas for this post type are deactivated from %sSEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $this->_post->post_type . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_canonical')) {
            $errors[] = sprintf(esc_html__("Meta Canonical is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) {
            $errors[] = sprintf(esc_html__("SEO Metas is deactivated from %sSEO Settings > Metas%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '" >', '</a>');
        }

        if (!empty($errors)) {
            $task['error_message'] = join('<br />', $errors);
            $task['error'] = true;
        }

        if (isset($this->_post->sq->canonical) && $this->_post->sq->canonical <> '') {
            if (rtrim($this->_post->sq->canonical, '/') <> rtrim($this->_post->url, '/')) {
                $task['completed'] = false;
                return $task;
            }
        }

        $task['completed'] = true;

        return $task;
    }

    private function _strWordCount($string) {

        if (!$count = str_word_count($string)) {
            if (function_exists('mb_split') && function_exists('mb_internal_encoding') && function_exists('mb_regex_encoding')) {
                try {
                    mb_internal_encoding('UTF-8');
                    mb_regex_encoding('UTF-8');

                    $words = mb_split('[^\x{0600}-\x{06FF}]', $string);
                    $count = count((array)$words);
                } catch (Exception $e) {
                }
            } else {
                return 1;
            }

        }

        return (int)$count;
    }

}