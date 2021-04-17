<?php

class SQ_Models_Assistant {

    protected $_stats;
    protected $_checkin;
    protected $_briefcase;
    protected $_ranks;
    protected $_dbtasks;

    /**
     * Get all the assistant tasks in list
     *
     * @param string $category_name
     * @return string
     */
    public function getAssistant($category_name = 'sq_research') {
        $content = '';

        //Get the processed task for this category
        //Hook the assistant tasks
        if ($tasks = apply_filters('sq_assistant_tasks_' . $category_name, $this->parseAllTasks($category_name))) {
            //Create the list of tasks
            $content .= '<ul id="sq_assistant_tasks_' . $category_name . '" class="p-0 m-0" >';
            foreach ($tasks as $name => $task) {

                $content .= '<li class="sq_task row ' . (isset($task['status']) ? $task['status'] : '') . '"  data-category="' . $category_name . '" data-name="' . $name . '" data-active="' . $task['active'] . '" data-completed="' . $task['completed'] . '"  data-dismiss="modal">
                            <i class="fa fa-check" title="' . $task['error_message'] . '"></i>
                            <h4>' . $task['title'] . '</h4>
                            <div class="description" style="display: none">' . $task['description'] . '</div>
                            <div class="message" style="display: none">' . $task['error_message'] . '</div>
                            </li>';
            }
            $content .= '</ul>';
        }
        return $content;
    }

    /**
     * Get the modal div for the assistant popup
     * @return string
     */
    public function getModal() {
        return '
            <div id="sq_assistant_modal" tabindex="-1" class="modal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content bg-light">
                            <div class="modal-header">
                                <h4 class="modal-title">' . esc_html__("Task Details", _SQ_PLUGIN_NAME_) . ':</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body" style="min-height: 90px;"></div>
                            <div class="modal-footer"> 
                            <div class="checker col-sm-3 row m-0 p-0 sq_save_ajax">
                                <div class="col-sm-12 p-0 sq-switch sq-switch-xxs text-right">
                                    <label for="sq_ignore" class="ml-2 text-black-50 font-weight-normal">' . esc_html__("active task", _SQ_PLUGIN_NAME_) . '</label>
                                    <input type="checkbox" id="sq_ignore" data-input="" data-name="" data-action="sq_ajax_assistant" class="switch" value="1"/>
                                    <label for="sq_ignore" class="ml-2"></label>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
            </div>';
    }

    /**
     * Show the Keywords modal in Focus Pages
     * @param SQ_Models_Domain_FocusPage $focuspage
     * @return string
     */
    public function getKeywordsModal($focuspage) {
        $audit = $focuspage->getAudit();
        $post = $focuspage->getWppost();
        if (isset($post->ID) && isset($audit->data) && isset($audit->data->sq_seo_briefcase) && !empty($audit->data->sq_seo_briefcase)) {
            foreach ($audit->data->sq_seo_briefcase as $lsikeyword) {
                $options[] = '<option value="' . $lsikeyword->keyword . '" ' . ($lsikeyword->main ? 'selected="selected"' : '') . '>' . $lsikeyword->keyword . '</option>';
            }

            if (!empty($options)) {
                return '
                    <div class="sq_main_keyword_dialog_' . $post->ID . ' sq_main_keyword_dialog modal" data-post_id="' . $post->ID . '" tabindex="-1" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content bg-light">
                                <div class="modal-header">
                                    <h4 class="modal-title">' . esc_html__("Change Main Keyword", _SQ_PLUGIN_NAME_) . '</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>' . esc_html__("Main Keyword", _SQ_PLUGIN_NAME_) . '</label>
                                        <select class="form-control" name="keyword">' . join(' ', $options) . '</select>
                                    </div>
                                    <h6 class="alert-danger my-4 p-2">' . esc_html__("Note! You need to request a new Focus Pages audit to update the report!", _SQ_PLUGIN_NAME_) . '</h6>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success btn-save">' . esc_html__("Save Main Keyword", _SQ_PLUGIN_NAME_) . '</button>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
        }
    }

    /**
     * Get the admin Menu Tabs
     * @param string $category_name
     * @return array
     */
    public function getTasks($category_name) {
        $tasks = array();

        if (SQ_Classes_Helpers_Tools::getOption('sq_assistant')) {

            $tasks['sq_research'] = array(
                'do_research' => array(
                    'title' => esc_html__("Do Keyword Research", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Use Research - Find Keywords to perform your very first keyword research for this website using Squirrly SEO. %s It will guide through the 3 important steps of performing a research. %s Just follow the steps.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
                    'function' => 'checkKeywordResearch',
                ),
                'add_briefcase' => array(
                    'title' => esc_html__("Add Keywords in Briefcase", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Use the Briefcase feature to organize and manage your portfolio of keywords. %s You'll need to know and document the keywords that you'll be using throughout your WordPress site. %s This will help you keep a clear SEO Strategy or it can help you form a SEO Strategy. It will also help you focus and you'll get to see when you're spreading yourself too thin. %s Add your first keywords (that you've researched using the Keyword Research tool) to Briefcase. Only add keywords that you will want to work on at some point in the future and which are on-point with your strategy.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
                    'function' => 'checkKeywordBriefcase',
                ),
                'add_labels' => array(
                    'title' => esc_html__("Create Labels for Keywords", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Organize your keywords by using Labels for the keywords you've stored in Briefcase. %s There are many ways to use this: from Customer Journey labels, to direct or indirect labels, to core keywords or secondary keywords ... and so on. You can get super creative with this. %s We have a very important blog post you can read for this http://fourhourseo.com/pro-course-6-how-to-organize-and-manage-your-keyword-portfolio/ %s Just add your first label to complete this task.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
                    'function' => 'checkLabelBriefcase',
                ),
                'add_keyword_label' => array(
                    'title' => esc_html__("Add Keywords to Labels", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Now that you've created your first label, you should label one of your stored keywords using that label. %s Go to Briefcase. Move your mouse over the row containing your desired keyword. The 3 vertical dots button appears. %s Move your mouse over it and a menu will show. Click on Assign Label. %s Then, assign a label to your keyword in order to complete this task.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
                    'function' => 'checkKeywordLabels',
                ),
                'add_keyword_serp' => array(
                    'title' => esc_html__("Send Keywords to Rank Checker", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Now that you (hopefully) have keywords added to your Briefcase, go look at one of your keywords. Move the mouse over the row with your desired keyword. %s You will see a button with 3 vertical dots appear to the right of the row. %s Get your mouse cursor over that button. A menu shows. Click on Send to Rank Checker. %s That's it. Now Squirrly SEO's rank checker feature will start tracking your position in Google for that keyword that is part of your SEO strategy.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />'),
                    'function' => 'checkKeywordSerp',
                ),
            );
            $tasks['sq_assistant'] = array(
                'sla_optimize' => array(
                    'title' => esc_html__("Optimize Using Live Assistant", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Optimize your first Page or Article using the SEO Live Assistant (SLA) feature from Squirrly SEO. %s You can either Edit an existing post or create a new post. (You have your Live Assistant where you have your WP Editor)%sThe SEO Live Assistant is like having a SEO Consultant near you, whispering in your ear exactly what you have to do to get a 100% optimized article or page.%sYou can try the DEMO first, by clicking on the Demo Post button. It's safe to break anything in the SEO of that page, because it never gets indexed by Google, since it's a DEMO. It's an easy way to learn your way around it.", _SQ_PLUGIN_NAME_), '<br />', '<br />', '<br />', '<br />'),
                    'function' => 'checkSLAOptimization',
                ),
            );
            $tasks['sq_seosettings'] = array(
                'setup_patterns' => array(
                    'title' => esc_html__("Activate SEO Automation", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("The %sSEO Automation Features%s of Squirrly SEO are extremely powerful. %s They help Non-SEO experts avoid many mistakes they would normally make. %s They help experts control any WordPress site at a level that has never been possible before. (just make sure you click to see the Advanced settings). %s You'll be able to configure automations according to any post type. %s Turn the toggle to ON for: %sActivate Patterns%s to complete this task.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '">', '</a>', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '">', '</a>'),
                    'function' => 'checkSettingsPatterns',
                ),
                'setup_metas' => array(
                    'title' => esc_html__("Activate METAs", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Activate the %sMETA settings%s from the Squirrly SEO Plugin. %s You can import ALL meta settings you've made with other plugins in WordPress into your Squirrly SEO Plugin. That way everything will be kept 100%% intact, without any head-aches. %s To complete this task you need to activate: %s - Optimize the Titles%s - Optimize Descriptions %s - Add Canonical META Link %s Make sure you click on %sSave settings%s after you switch anything on or off.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas') . '">', '</a>', '<br /><br />', '<br /><br />', '<br /><br />', '<br />', '<br />', '<br /><br />', '<strong>', '</strong>'),
                    'function' => 'checkSettingsMetas',
                ),
                'setup_jsonld' => array(
                    'title' => esc_html__("Activate JSON-LD", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("%sJSON-LD Structured Data%s needs to be activated. %s The Duplicate Removal feature of Squirrly SEO will make sure that if you have more than one JSON-LD definition inside the source code of any URL, the definition created by Squirrly SEO will be the only one that remains. %s Make sure you setup all the information about your Organization or your Personal Brand here. %s To finish all the JSON-LD related setup, also visit the %sSocial Media%s section of our Settings page and write in your social media profiles for this site. %s Then, at URL-level you will be able to add custom JSON-LD if you're an advanced user.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'jsonld') . '">', '</a>', '<br /><br />', '<br /><br />', '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '">', '</a>', '<br /><br />'),
                    'function' => 'checkSettingsJsonld',
                ),
                'setup_og' => array(
                    'title' => esc_html__("Activate Open Graph", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Go to the %sSocial Media section%s.%sActivate Open Graph. (switch the toggle to ON) %s The Open Graph will help you control the way your posts look when people share your URLs to social media sites like Facebook and LinkedIN. %s It will also make your social media posts look great and gain you clicks to your site.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '">', '</a>', '<br /><br />', '<br /><br />', '<br /><br />'),
                    'function' => 'checkSettingsSocialOG',
                ),
                'setup_twc' => array(
                    'title' => esc_html__("Activate Twitter Card", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Go to the %sSocial Media section%s. %s - Activate Twitter Card. (switch the toggle to ON) %s - Add your Twitter profile URL %s The Twitter Card will help you control the way your posts look when people share your URLs on Twitter. %s It will also make your social media posts look great and gain you clicks to your site.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social') . '">', '</a>', '<br /><br />', '<br />', '<br /><br />', '<br /><br />'),
                    'function' => 'checkSettingsSocialTWC',
                ),
                'setup_sitemap' => array(
                    'title' => esc_html__("Activate Sitemap XML", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Activate your %sSitemap XML%s setting. Squirrly SEO will then generate your sitemap, according to different items you can set up. %s Use this to tell Google how often you bring new content to your site. %s Also, choose for which types of URLs you'll want to have sitemaps. It depends on your strategy. Leave the defaults if you're uncertain. Squirrly SEO chooses the best defaults for you. %s Make sure you include Images and Videos in the sitemap. It has been identified as a ranking factor, so it's good to have that.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'sitemap') . '">', '</a>', '<br /><br />', '<br /><br />', '<br /><br />'),
                    'function' => 'checkSettingsSitemap',
                ),
                'setup_ganalytics' => array(
                    'title' => esc_html__("Activate Google Analytics", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Go to the %sTracking Tools section%s. %s Add your Google Analytics ID to complete this setting. (find it in the tracking code that Google Analytics tells you to place on your site) %s Squirrly SEO will then add (automatically) your Google Analytics tracking code (in the format you desire) to every page of your site (according to rules you can modify in the Automation section).", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'tracking') . '">', '</a>', '<br /><br />', '<br /><br />'),
                    'function' => 'checkSettingsGoogleAnalytics',
                ),
//                'setup_fpixel' => array(
//                    'title' => esc_html__("Activate Facebook Pixel", _SQ_PLUGIN_NAME_),
//                    'description' => sprintf(esc_html__("Go to the %sTracking Tools section%s of the settings and add your Facebook Pixel ID. %s Make sure you click %sSave Settings%s after you do that. %s Do this, and Facebook will start tracking user actions on your site, so you can later retarget them with ads.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'tracking') . '">', '</a>', '<br /><br />', '<strong>', '</strong>', '<br /><br />'),
//                    'function' => 'checkSettingsFacebookPixel',
//                ),
                'setup_webmasters' => array(
                    'title' => esc_html__("Connect the Webmasters", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Go to the %sConnection section%s. %s This section makes it super easy to integrate different (important) 3rd party services with your WordPress. %s Alexa META Code is 100%% optional, but the rest are very important to add. %s Enter your Pinterest code, especially if you plan to expand your presence on Pinterest. It will %sactivate Rich Pins%s, which will completely boost your sales and visibility for any product or post that has great images.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'webmaster') . '">', '</a>', '<br /><br />', '<br /><br />', '<br /><br />', '<a href="https://developers.pinterest.com/tools/url-debugger/" target="_blank">', '</a>'),
                    'function' => 'checkSettingsWebmasters',
                ),

            );
            $tasks['sq_focuspages'] = array();
            $tasks['sq_audits'] = array(
                'ga_connect' => array(
                    'title' => esc_html__("Connect Google Analytics", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Integrate %sGoogle Analytics%s with Squirrly SEO from %sAudits > Settings%s.%sFeatures like %sFocus Pages%s and the %sAudit%s need this integration, in order to work at full potential.%sGoogle Analytics is free and everyone uses it. The %sFocus Pages%s and the %sAudit%s will interpret the right data from Google Analytics for you.%sYou'll feel like an Analytics expert, without having to know a single thing about Google Analytics.", _SQ_PLUGIN_NAME_), '<a href="https://analytics.google.com/analytics/web/" target="_blank">', '</a>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'settings') . '" target="_blank">', '</a>', '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages') . '" target="_blank">', '</a>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits') . '" target="_blank">', '</a>', '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages') . '" target="_blank">', '</a>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits') . '" target="_blank">', '</a>', '<br /><br />'),
                    'function' => 'checkGAConnect',
                ),
                'gsc_connect' => array(
                    'title' => esc_html__("Connect Google Search Console", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Integrate your WordPress with %sGoogle Search Console%s with Squirrly SEO from %sAudits > Settings%s.%sThis integration is more than just setting the meta code for it. It will connect your WP to the API of Google's service and enable info such as Impressions, Clicks, Average Ranking Position to be collected.%sMore importantly, you'll be able to update all the info that Google has about your site, directly from your Squirrly SEO Plugin.", _SQ_PLUGIN_NAME_), '<a href="https://search.google.com/search-console/" target="_blank">', '</a>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'settings') . '" target="_blank">', '</a>', '<br /><br />', '<br /><br />'),
                    'function' => 'checkGSCConnect',
                ),
                'setup_email' => array(
                    'title' => esc_html__("Set the Audit Email", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("You can customize the email to which we send the Audit reports.%sIt can be your personal email, your work email or the email of one of your collaborators.%sIt's a best practice to have the Audit sent to the person that will take charge and start correcting the problems of the site, in order to increase the score.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
                    'function' => 'checkAuditEmail',
                ),
                'audit_score_60' => array(
                    'title' => esc_html__("Get your score over 60", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("True website marketing performance happens after your Audit score gets to over 84.%sHowever, you need to start with smaller steps. For now, focus on getting a score of over 60.%sLook at the progress charts weekly and make sure you check out the Tasks section, which tells you exactly what you need to do in order to increase the score.%sWe've been testing these scores since 2013 on hundreds of thousands of websites and it's always the same: %strue performance happens at over 84%s. That's why you need to start working on this.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />', '<br /><br />', '<strong>', '</strong>'),
                    'function' => 'checkAuditScore60',
                ),
            );
            $tasks['sq_rankings'] = array(
                'add_keywords' => array(
                    'title' => esc_html__("Track your first 3 Keywords", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("%sSERP Checker = Search Engine Result Pages Checker.%s %s It checks your position on the Google Search Engine for your keywords. Also (on the Business Plan) it shows you the evolution in time for your sites' URLs for these keywords. %s Tell Squirrly SEO the first three keywords you want it to check for you, to see if you're ranking for them. %s Because you should work according to a solid SEO Strategy, you'll only be able to add keywords or remove keywords in the Ranking section from your Briefcase. %s Briefcase is your keyword organizer / manager. Find it in the Research section. Go with the mouse cursor over a keyword from %sBriefcase -> see the 3 vertical dots -> select Send to Rank Checker%s", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<br /><br />', '<br /><br />', '<br /><br />', '<br /><br />', '<a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_send_rank_checker" target="_blank">', '</a>'),
                    'function' => 'checkRankingKeywords',
                ),
                'gsc_connect' => array(
                    'title' => esc_html__("Connect Google Search Console", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Connect Google Search Console. %s You can do that from %sSEO Audit > Settings%s. %s It will bring information regarding Impressions and Clicks. %s Note: if you're on the free plan or the PRO plan then the Ranking Position will be displayed according to data from Google Search Console, which does not present the actual position you are on. It shows an average position that your site was lately found on. It can give you values such as 4.3 because of this. Even though your page today could be on position 7. %s The Business Plan is the only one that can give you the exact position because it uses Squirrly's private cloud servers that are working around the clock to gather the accurate, on-time and objective information about your rankings.", _SQ_PLUGIN_NAME_), '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'settings') . '">', '</a>', '<br /><br />', '<br /><br />', '<br /><br />'),
                    'function' => 'checkGSCConnect',
                ),
                'top_ranking' => array(
                    'title' => esc_html__("Get 1 Keyword to the first page of Google", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("Start with a small task. %sGet 1 keyword to the first page of Google%s. %s Select a good keyword (using our %sKeyword Research Tool%s). %s Create an amazing page for it (if you don't already have one). %s %sAdd the page to Focus Pages%s in Squirrly SEO. %s Turn the RED lights to Green in Focus Pages and see your rankings increase over time. %s If you continue working on those tasks and turning elements to green you'll complete this task.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') . '" target="_blank">', '</a>', '<br /><br />', '<br /><br />', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'addpage') . '" target="_blank">', '</a>', '<br /><br />', '<br /><br />'),
                    'function' => 'checkRankingTop',
                ),
//                'setup_frequency' => array(
//                    'title' => esc_html__("Select a Ranking Frequency above 0", _SQ_PLUGIN_NAME_),
//                    'description' => sprintf(esc_html__("The default setting is 0. %s Go to Ranking - Settings and set the Ranking Frequency to anything above 0. %s The Ranking Frequency setting tells Squirrly SEO how many keywords it should check rankings for every single day.", _SQ_PLUGIN_NAME_), '<br /><br />', '<br /><br />'),
//                    'function' => 'checkRankingFrequency',
//                ),
            );
            $tasks['sq_audit'] = array();
        }

        $tasks = array_filter($tasks);

        if (isset($tasks[$category_name])) {
            return apply_filters('sq_assistant_tasks', $tasks[$category_name]);
        }

        return array();
    }

    /**
     * Parse all tasks for the current category
     *
     * @param $category_name
     * @return array|bool
     *
     */
    public function parseAllTasks($category_name) {
        $tasks = $this->getTasks($category_name);

        if (!empty($tasks)) {
            if (!isset($this->_dbtasks)) {
                $this->_dbtasks = json_decode(get_option(SQ_TASKS), true);
            }

            foreach ($tasks as $name => &$task) {
                if (!isset($this->_dbtasks[$category_name][$name]['completed'])) {
                    $this->_dbtasks[$category_name][$name]['completed'] = false;
                }

                if (!isset($this->_dbtasks[$category_name][$name]['active'])) {
                    $this->_dbtasks[$category_name][$name]['active'] = true;
                }

                if ($this->_dbtasks[$category_name][$name]['active'] && method_exists($this, $task['function'])) {
                    if ($category_name == 'sq_research' && $this->_dbtasks[$category_name][$name]['completed']) {
                        //don't check the research if it's already done
                    } else {
                        $this->_dbtasks[$category_name][$name]['completed'] = call_user_func(array($this, $task['function']));
                    }
                }

                //set the current task
                $task['active'] = $this->_dbtasks[$category_name][$name]['active'];
                $task['completed'] = $this->_dbtasks[$category_name][$name]['completed'];
                $task['status'] = $this->_dbtasks[$category_name][$name]['active'] ? ($task['completed'] ? 'completed' : '') : 'ignore';
                $task['error_message'] = (!$task['active'] ? esc_html__("You chose to ignore this task. Click to activate it.", _SQ_PLUGIN_NAME_) : '');
            }

            update_option(SQ_TASKS, wp_json_encode($this->_dbtasks));
            return $tasks;
        }

        return false;
    }


    /********************************************* RESEARCH */
    public function checkKeywordResearch() {
        if (!$this->_stats) { //only if there are websites
            $this->_stats = SQ_Classes_RemoteController::getStats();
        }

        if (!is_wp_error($this->_stats)) {
            if (isset($this->_stats->kr_research) && $this->_stats->kr_research) {
                return true;
            }
        }
        return false;
    }

    public function checkKeywordBriefcase() {
        if (!$this->_briefcase) { //only if there are websites
            $this->_briefcase = SQ_Classes_RemoteController::getBriefcaseStats();
        }

        if (isset($this->_briefcase->keywords) && $this->_briefcase->keywords > 0) {
            return true;
        }
        return false;
    }

    public function checkLabelBriefcase() {
        if (!$this->_briefcase) { //only if there are websites
            $this->_briefcase = SQ_Classes_RemoteController::getBriefcaseStats();
        }

        if (isset($this->_briefcase->labels) && $this->_briefcase->labels > 0) {
            return true;
        }
        return false;
    }

    public function checkKeywordLabels() {
        if (!$this->_briefcase) { //only if there are websites
            $this->_briefcase = SQ_Classes_RemoteController::getBriefcaseStats();
        }

        if (isset($this->_briefcase->keywords_labeled) && $this->_briefcase->keywords_labeled > 0) {
            return true;

        }
        return false;
    }

    public function checkKeywordSerp() {
        if (!$this->_briefcase) { //only if there are websites
            $this->_briefcase = SQ_Classes_RemoteController::getBriefcaseStats();
        }

        if (isset($this->_briefcase->keywords_doserp) && $this->_briefcase->keywords_doserp > 0) {
            return true;

        }
        return false;
    }

    /********************************************* SLA */
    public function checkSLAOptimization() {
        if (!$this->_stats) { //only if there are websites
            $this->_stats = SQ_Classes_RemoteController::getStats();
        }

        if (!is_wp_error($this->_stats)) {
            if (isset($this->_stats->optimized_articles) && $this->_stats->optimized_articles) {
                return true;
            }
        }
        return false;
    }

    /********************************************* SEO SETTINGS */
    public function checkSettingsMetas() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_use') &&
            SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') &&
            SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') &&
            SQ_Classes_Helpers_Tools::getOption('sq_auto_canonical') &&
            SQ_Classes_Helpers_Tools::getOption('sq_auto_title') &&
            SQ_Classes_Helpers_Tools::getOption('sq_auto_description')
        ) {
            return true;
        }

        return false;
    }

    public function checkSettingsJsonld() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld')) {
            return true;
        }

        return false;
    }

    public function checkSettingsSocialOG() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_social') && SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) {
            return true;
        }

        return false;
    }

    public function checkSettingsSocialTWC() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_social') && SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) {
            return true;
        }

        return false;
    }

    /**********************************************/
    public function checkSettingsGoogleAnalytics() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking')) {
            $codes = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('codes')));
            if (isset($codes->google_analytics) && $codes->google_analytics <> '') {
                return true;
            }
        }

        return false;
    }

    public function checkSettingsFacebookPixel() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking')) {
            $codes = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('codes')));
            if (isset($codes->facebook_pixel) && $codes->facebook_pixel <> '') {
                return true;
            }
        }

        return false;
    }

    /***********************************************/
    public function checkSettingsWebmasters() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_webmasters')) {
            $codes = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('codes')));
            if (isset($codes->google_wt) && $codes->google_wt <> '' ||
                isset($codes->bing_wt) && $codes->bing_wt <> '' ||
                isset($codes->alexa_verify) && $codes->alexa_verify <> '' ||
                isset($codes->pinterest_verify) && $codes->pinterest_verify <> '') {
                return true;
            }
        }

        return false;
    }


    public function checkSettingsSitemap() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap')) {
            return true;
        }

        return false;
    }

    public function checkSettingsPatterns() {
        if (SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern')) {
            return true;
        }

        return false;
    }

    /********************************************* AUDITS */
    public function checkGAConnect() {
        $connect = SQ_Classes_Helpers_Tools::getOption('connect');
        if (isset($connect['google_analytics']) && $connect['google_analytics']) {
            return true;
        }
        return false;
    }

    public function checkGSCConnect() {
        $connect = SQ_Classes_Helpers_Tools::getOption('connect');
        if (isset($connect['google_search_console']) && $connect['google_search_console']) {
            return true;
        }
        return false;
    }

    public function checkAuditEmail() {
        $audit_email = SQ_Classes_Helpers_Tools::getOption('sq_audit_email');
        if ($audit_email <> '') {
            return true;
        }
        return false;
    }

    public function checkAuditScore60() {
        if ($audit = SQ_Classes_RemoteController::getAudit()) {

            if (!is_wp_error($audit)) {
                if ($audit->score >= 60) {
                    return true;
                }
            }
        }

        return false;
    }

    /******************************************* Ranking */

    public function checkRankingKeywords() {
        if (!$this->_ranks) { //only if there are websites
            if ($this->_ranks = SQ_Classes_RemoteController::getRanks(array('page' => 1))) {
                if (is_wp_error($this->_ranks)) {
                    $this->_ranks = array();
                }
            }
        }
        if (count((array)$this->_ranks) >= 3) {
            return true;
        }

        return false;
    }

    public function checkRankingTop() {
        if (!$this->_ranks) { //only if there are websites
            $args = array();
            $args['page'] = 1;
            if ($this->_ranks = SQ_Classes_RemoteController::getRanks($args)) {
                if (is_wp_error($this->_ranks)) {
                    $this->_ranks = array();
                }
            }
        }
        if (!empty($this->_ranks)) {
            foreach ($this->_ranks as $rank) {
                if (($rank->rank > 0 && $rank->rank <= 10) ||
                    $rank->average_position > 0 && $rank->average_position <= 10) {
                    return true;
                }
            }
        }

        return false;
    }
}