<?php

class SQ_Models_Focuspages_Strategy extends SQ_Models_Abstract_Assistant {

    protected $_category = 'strategy';

    protected $_keyword = false;
    protected $_optimization = false;
    protected $_briefcase = false;
    protected $_lsikeywords = false;
    protected $_labels = false;

    const OPTIMIZATION_MINVAL = 30;

    public function init() {
        parent::init();

        if (!isset($this->_audit->data)) {
            $this->_error = true;
            return;
        }
        $this->_labels = false;
        $this->_briefcase = false;


        if (isset($this->_audit->data->sq_seo_keywords->value)) {
            $this->_keyword = $this->_audit->data->sq_seo_keywords->value;

            $args = array();
            $args['search'] = $this->_keyword;
            $briefcase = SQ_Classes_RemoteController::getBriefcase($args);
            if (isset($briefcase->keywords) && !empty($briefcase->keywords)) {
                foreach ($briefcase->keywords as $row){

                    if(strtolower($row->keyword) == strtolower($this->_keyword)){
                        $this->_briefcase = true; //the keyword exists

                        if(!empty($row->labels)){
                            $this->_labels = true; //labels are added

                        }
                    }
                }
            }
        }

        if (isset($this->_audit->data->sq_seo_briefcase) && !empty($this->_audit->data->sq_seo_briefcase)) {
            foreach ($this->_audit->data->sq_seo_briefcase as $lsikeyword) {
                if ($lsikeyword->keyword <> $this->_keyword) {
                    $this->_lsikeywords[$lsikeyword->keyword] = $lsikeyword->optimized;
                }
            }
        }

        add_filter('sq_assistant_' . $this->_category . '_task_practice', array($this, 'getPractice'), 11, 2);
    }

    public function setTasks($tasks) {
        parent::setTasks($tasks);

        $lsikeywords = array();
        if ($this->_lsikeywords) {
            foreach ($this->_lsikeywords as $keyword => $optimized) {
                $lsikeywords[] = $keyword . ' (' . $optimized . '%)';
            }
        }

        $this->_tasks[$this->_category] = array(
            'briefcase' => array(
                'title' => esc_html__("Add keyword to Briefcase", _SQ_PLUGIN_NAME_),
                'value' => ($this->_briefcase ?  esc_html__("Great! The keyword exists in Briefcase", _SQ_PLUGIN_NAME_) : esc_html__("The keyword does not exist in Briefcase", _SQ_PLUGIN_NAME_)),
                'description' => sprintf(esc_html__("Go add a keyword to your %sBriefcase%s. %s The Briefcase is the command center for your SEO operations. Manage your keywords in Briefcase, so that you'll always have quick access to them. You'll always know what your SEO Strategy is all about. %s Plus, adding keywords to Briefcase will make it very easy for you to collaborate with other people from your team, freelancers, agencies or partners. %s Never lose the amazing keywords you find through the %sSquirrly SEO Keyword Research tool%s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') . '" target="_blank">', '</a>','<br /><br />', '<br /><br />', '<br /><br />','<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') . '" target="_blank">', '</a>'),
            ),
            'lsioptimization' => array(
                'title' => esc_html__("Add SEO Context", _SQ_PLUGIN_NAME_),
                'value' => (!empty($lsikeywords) ? join(', ', $lsikeywords) : ''),
                'penalty' => 5,
                'description' => sprintf(esc_html__("Optimize to %s for a secondary keyword. %s Squirrly SEO's Live Assistant allows you to optimize for multiple keywords that you have placed in your Briefcase. %s Use a couple of additional keywords for your Focus Page which help Google understand the exact topic and context of your page.  %s If you added the keywords 'political party' to 'black panther', you'd make a clear hint to Google that your page is about the Black Panther political party, not Black Panther, the Marvel Movie.  %s Or add 'places to eat' to a page about your Local Restaurant in San Diego. That will give clearer context to Google that your page really is about a restaurant where people can dine.", _SQ_PLUGIN_NAME_), self::OPTIMIZATION_MINVAL . '%', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />'),
            ),

            'labels' => array(
                'title' => esc_html__("Labels Exist", _SQ_PLUGIN_NAME_),
                'value' => ($this->_labels ?  esc_html__("Great! The keyword has Label attached to it", _SQ_PLUGIN_NAME_) : esc_html__("The keyword does not have a label attached to it", _SQ_PLUGIN_NAME_)),
                'description' => sprintf(esc_html__("To turn this task to green, go to %sLabels section%s and add a label to the keyword that you've used as main keyword for this Focus Page. %s Make sure that you keep creating new labels as you're finding more keywords to target with your website. %s If you're unsure regarding keyword research, read %sHow to Find Amazing Keywords and get more search traffic?%s . %s Organize all the Keywords that you plan to use for your website with Briefcase Labels. %s This task helps you make sure that the main keyword for this Focus Page has been organized clearly inside your SEO Strategy. That's what Briefcase Labels are all about.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'labels') . '" target="_blank">', '</a>', '<br /><br />', '<br /><br />', '<a href="https://howto.squirrly.co/wordpress-seo/journey-to-better-ranking-day-2/" target="_blank">', '</a>','<br /><br />', '<br /><br />'),
            ),
        );
    }

    /*********************************************/
    /**
     * @param $content
     * @param $task
     * @return string
     */
    public function getHeader() {
        $header = '<li class="completed">';
        $header .= '<div class="font-weight-bold text-black-50 mb-1">' . esc_html__("Current URL", _SQ_PLUGIN_NAME_) . ': </div>';
        $header .= '<a href="' . $this->_post->url . '" target="_blank" style="word-break: break-word;">' . urldecode($this->_post->url) . '</a>';
        $header .= '</li>';

        $header .= '<li class="completed" style="background-color:#f7f7f7">';
        if ($this->_keyword) {
            $header .= $this->getUsedKeywords();
            $header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') . '" target="_blank" class="btn btn-success text-white col-sm-10 offset-1 mt-3">' . esc_html__("Manage Strategy", _SQ_PLUGIN_NAME_) . '</a>';
        } else {
            if (isset($this->_post->ID)) {
                $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('post.php?post=' . (int)$this->_post->ID . '&action=edit');
                if ($this->_post->post_type <> 'profile') {
                    $edit_link = get_edit_post_link($this->_post->ID, false);
                }
                $header .= '<div class="font-weight-bold text-warning m-0  text-center">' . esc_html__("No Keyword found in Squirrly Live Assistant", _SQ_PLUGIN_NAME_) . '</div>';
                $header .= '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') . '" target="_blank" class="btn btn-success text-white col-sm-10 offset-1 mt-3">' . esc_html__("Do a research", _SQ_PLUGIN_NAME_) . '</a>';
                if (isset($this->_post->ID)) {
                    $header .= '<a href="' . $edit_link . '" target="_blank" class="btn btn-success text-white col-sm-10 offset-1 my-2">' . esc_html__("Optimize for a keyword", _SQ_PLUGIN_NAME_) . '</a>';
                }
            }
        }
        $header .= '</li>';
        return $header;
    }

    /**
     * Keyword optimization required
     * @param $title
     * @return string
     */
    public function getTitle($title) {

        if ($this->_error && !$this->_keyword) {
            return esc_html__("Optimize the page for a keyword. Click to open the Assistant in the right sidebar and follow the instructions.", _SQ_PLUGIN_NAME_);
        } elseif (!$this->_completed && !$this->_indexed) {
            foreach ($this->_tasks[$this->_category] as $task) {
                if ($task['completed'] === false) {
                    return esc_html__("Click to open the Assistant in the right sidebar and follow the instructions.", _SQ_PLUGIN_NAME_);
                }
            }
        }

        return parent::getTitle($title);
    }

    /**
     * API Briefcase Keyword Exists
     * @return bool|WP_Error
     */
    public function checkBriefcase($task) {
        $task['completed'] = $this->_briefcase;
        return $task;
    }

    /**
     * API Briefcase LSI optimization
     * @return bool|WP_Error
     */
    public function checkLsioptimization($task) {
        if (isset($this->_audit->data->sq_seo_briefcase) && !empty($this->_audit->data->sq_seo_briefcase)) {
            if ($this->_lsikeywords) {
                foreach ($this->_lsikeywords as $keyword => $optimized) {
                    if (($optimized >= self::OPTIMIZATION_MINVAL)) {
                        $task['completed'] = true;
                        return $task;
                    }
                }
            }

            $task['error_message'] = esc_html__("Add a secondary keyword in Squirrly Live Assistant from Briefcase", _SQ_PLUGIN_NAME_);
            $task['completed'] = false;

            unset($task['value']); //don't show current when no keywords are present
            return $task;
        }

        $task['error_message'] = esc_html__("Add a secondary keyword in Squirrly Live Assistant from Briefcase", _SQ_PLUGIN_NAME_);
        $task['error'] = true;
        return $task;
    }

    /**
     * API Briefcase Keyword label exists
     * @return bool|WP_Error
     */
    public function checkLabels($task) {
        $task['completed'] = $this->_labels ;
        return $task;
    }

}