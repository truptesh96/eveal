<?php
defined('ABSPATH') || die('Cheatin\' uh?');

/**
 * The configuration file
 */
if (!defined('_SQ_NONCE_ID_')) {
    if (defined('NONCE_KEY')) {
        define('_SQ_NONCE_ID_', NONCE_KEY);
    } else {
        define('_SQ_NONCE_ID_', md5(date('Y-d')));
    }
}

define('_SQ_MOBILE_ICON_SIZES', '76,120,152');

define('SQ_ONBOARDING', '9.0.0');
defined('SQ_DEBUG') || define('SQ_DEBUG', 0);
define('SQ_REQUEST_TIME', microtime(true));

/* No path file? error ... */
require_once(dirname(__FILE__) . '/paths.php');

/* Define the record name in the Option and UserMeta tables */
defined('SQ_OPTION') || define('SQ_OPTION', 'sq_options');
defined('SQ_TASKS') || define('SQ_TASKS', 'sq_tasks');
defined('_SQ_DB_') || define('_SQ_DB_', 'qss');

define('SQ_ALL_PATTERNS', wp_json_encode(array(
    '{{sep}}' => esc_html__("Places a separator between the elements of the post description", _SQ_PLUGIN_NAME_),
    '{{title}}' => esc_html__("Adds the title of the post/page/term once it’s published", _SQ_PLUGIN_NAME_),
    '{{excerpt}}' => esc_html__("Will display an excerpt from the post/page/term (if not customized, the excerpt will be auto-generated)", _SQ_PLUGIN_NAME_),
    '{{excerpt_only}}' => esc_html__("Will display an excerpt from the post/page (no auto-generation)", _SQ_PLUGIN_NAME_),
    '{{keyword}}' => esc_html__("Adds the post's keyword to the post description", _SQ_PLUGIN_NAME_),
    '{{page}}' => esc_html__("Displays the number of the current page (i.e. 1 of 6)", _SQ_PLUGIN_NAME_),
    '{{sitename}}' => esc_html__("Adds the site's name to the post description", _SQ_PLUGIN_NAME_),
    '{{sitedesc}}' => esc_html__("Adds the tagline/description of your site", _SQ_PLUGIN_NAME_),
    '{{category}}' => esc_html__("Adds the post category (several categories will be comma-separated)", _SQ_PLUGIN_NAME_),
    '{{primary_category}}' => esc_html__("Adds the primary category of the post/page", _SQ_PLUGIN_NAME_),
    '{{category_description}}' => esc_html__("Adds the category description to the post description", _SQ_PLUGIN_NAME_),
    '{{tag}}' => esc_html__("Adds the current tag(s) (several tags will be comma-separated)", _SQ_PLUGIN_NAME_),
    '{{tag_description}}' => esc_html__("Adds the tag description", _SQ_PLUGIN_NAME_),
    '{{term_title}}' => esc_html__("Adds the term name", _SQ_PLUGIN_NAME_),
    '{{term_description}}' => esc_html__("Adds the term description", _SQ_PLUGIN_NAME_),
    '{{searchphrase}}' => esc_html__("Displays the search phrase (if it appears in the post)", _SQ_PLUGIN_NAME_),
    '{{modified}}' => esc_html__("Replaces the publication date of a post/page with the modified one", _SQ_PLUGIN_NAME_),
    '{{name}}' => esc_html__("Displays the author's nicename", _SQ_PLUGIN_NAME_),
    '{{user_description}}' => esc_html__("Adds the author's biographical info to the post description", _SQ_PLUGIN_NAME_),
    '{{date}}' => esc_html__("Displays the date of the post/page once it's published", _SQ_PLUGIN_NAME_),
    '{{currentdate}}' => esc_html__("Displays the current date", _SQ_PLUGIN_NAME_),
    '{{currentday}}' => esc_html__("Adds the current day", _SQ_PLUGIN_NAME_),
    '{{currentmonth}}' => esc_html__("Adds the current month", _SQ_PLUGIN_NAME_),
    '{{currentyear}}' => esc_html__("Adds the current year", _SQ_PLUGIN_NAME_),
    '{{parent_title}}' => esc_html__("Adds the title of a page's parent page", _SQ_PLUGIN_NAME_),
    '{{product_name}}' => esc_html__("Adds the product name from Woocommerce for the current product", _SQ_PLUGIN_NAME_),
    '{{product_price}}' => esc_html__("Adds the product price from Woocommerce for the current product", _SQ_PLUGIN_NAME_),
    '{{product_sale}}' => esc_html__("Adds the product sale price from Woocommerce for the current product", _SQ_PLUGIN_NAME_),
    '{{product_currency}}' => esc_html__("Adds the product price currency from Woocommerce for the current product", _SQ_PLUGIN_NAME_),
)));

define('SQ_ALL_OG_TYPES', wp_json_encode(array('website', 'article', 'profile', 'book', 'music', 'video')));
define('SQ_ALL_JSONLD_TYPES', wp_json_encode(array('website', 'article', 'newsarticle', 'FAQ page', 'question', 'recipe', 'review', 'movie', 'video', 'local store', 'local restaurant', 'profile')));

define('SQ_ALL_SEP', wp_json_encode(array(
    'sc-dash' => '-',
    'sc-ndash' => '&ndash;',
    'sc-mdash' => '&mdash;',
    'sc-middot' => '&middot;',
    'sc-bull' => '&bull;',
    'sc-star' => '*',
    'sc-smstar' => '&#8902;',
    'sc-pipe' => '|',
    'sc-tilde' => '~',
    'sc-laquo' => '&laquo;',
    'sc-raquo' => '&raquo;',
    'sc-lt' => '&lt;',
    'sc-gt' => '&gt;',
)));

define('SQ_ACTIONS', array(
    array(
        'name' => 'SQ_Core_Blocklogin',
        'description' => 'Connection Block',
        'actions' => array(
            'action' => array(
                'sq_login',
                'sq_register',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Core_BlockConnect',
        'description' => 'Connection Block to API',
        'actions' => array(
            'action' => array(
                'sq_cloud_connect',
                'sq_cloud_disconnect',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_Account',
        'description' => 'Account Class',
        'actions' => array(
            'action' => array(
                'sq_ajax_account_getaccount',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_FocusPages',
        'description' => 'Focus Pages Controller',
        'actions' => array(
            'action' => array(
                'sq_focuspages_getpage',
                'sq_focuspages_addnew',
                'sq_focuspages_update',
                'sq_focuspages_delete',
                'sq_focuspages_inspecturl',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_PostsList',
        'description' => 'Posts List Page',
        'actions' => array(
            'action' => array(
                'inline-save',
                'sq_ajax_postslist',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_Post',
        'description' => 'Post Page',
        'actions' => array(
            'action' => array(
                'sq_create_demo',
                'sq_ajax_save_ogimage',
                'sq_ajax_get_post',
                'sq_ajax_save_post',
                'sq_ajax_type_click',
                'sq_ajax_search_blog',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_Snippet',
        'description' => 'Snippet Page',
        'actions' => array(
            'action' => array(
                'sq_saveseo',
                'sq_getsnippet',
                'sq_previewsnippet',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_Patterns',
        'description' => 'Patterns Class',
        'actions' => array(
            'action' => array(
                'sq_getpatterns',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_BulkSeo',
        'actions' => array(
            'action' => array(
                'sq_ajax_assistant_bulkseo',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_SeoSettings',
        'actions' => array(
            'action' => array(
                'sq_seosettings_automation',
                'sq_seosettings_bulkseo',
                'sq_seosettings_jsonld',
                'sq_seosettings_metas',
                'sq_seosettings_links',
                'sq_seosettings_social',
                'sq_seosettings_tracking',
                'sq_seosettings_webmaster',
                'sq_seosettings_sitemap',
                'sq_seosettings_robots',
                'sq_seosettings_favicon',
                'sq_seosettings_backupsettings',
                'sq_seosettings_backupseo',
                'sq_seosettings_restoresettings',
                'sq_seosettings_restoreseo',
                'sq_seosettings_importsettings',
                'sq_seosettings_importseo',
                'sq_seosettings_importall',
                'sq_seosettings_ga_revoke',
                'sq_seosettings_gsc_revoke',
                'sq_seosettings_gsc_check',
                'sq_seosettings_ga_check',
                'sq_reinstall',
                'sq_rollback',
                'sq_alerts_close',
                'sq_ajax_seosettings_save',
                'sq_ajax_automation_addpostype',
                'sq_ajax_automation_deletepostype',
                'sq_ajax_sla_sticky',
                'sq_ajax_gsc_code',
                'sq_ajax_ga_code',
                'sq_ajax_connection_check',
                'sq_seosettings_advanced',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_Research',
        'actions' => array(
            'action' => array(
                'sq_briefcase_addlabel',
                'sq_briefcase_editlabel',
                'sq_briefcase_keywordlabel',
                'sq_briefcase_article',
                'sq_briefcase_doresearch',
                'sq_briefcase_addkeyword',
                'sq_briefcase_deletekeyword',
                'sq_briefcase_deletelabel',
                'sq_briefcase_deletefound',
                'sq_briefcase_savemain',
                'sq_briefcase_backup',
                'sq_briefcase_restore',
                'sq_ajax_briefcase_doserp',
                'sq_ajax_research_others',
                'sq_ajax_research_process',
                'sq_ajax_research_history',
                'sq_ajax_briefcase_bulk_delete',
                'sq_ajax_briefcase_bulk_label',
                'sq_ajax_briefcase_bulk_doserp',
                'sq_ajax_labels_bulk_delete',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_Audits',
        'actions' => array(
            'action' => array(
                'sq_audits_settings',
                'sq_auditpages_getaudit',
                'sq_audits_getpage',
                'sq_audits_addnew',
                'sq_audits_page_update',
                'sq_audits_update',
                'sq_audits_delete',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_Ranking',
        'actions' => array(
            'action' => array(
                'sq_ranking_settings',
                'sq_serp_refresh_post',
                'sq_serp_delete_keyword',
                'sq_ajax_rank_bulk_delete',
                'sq_ajax_rank_bulk_refresh',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_Assistant',
        'actions' => array(
            'action' => array(
                'sq_settings_assistant',
                'sq_ajax_assistant',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_CheckSeo',
        'actions' => array(
            'action' => array(
                'sq_checkseo',
                'sq_fixsettings',
                'sq_donetask',
                'sq_resetignored',
                'sq_moretasks',
                'sq_ajax_checkseo',
                'sq_ajax_getgoals',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_Onboarding',
        'actions' => array(
            'action' => array(
                'sq_onboarding_commitment',
                'sq_onboading_checksite',
                'sq_onboarding_settings',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Core_BlockJorney',
        'actions' => array(
            'action' => array(
                'sq_journey_close',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Core_BlockSupport',
        'actions' => array(
            'action' => array(
                'sq_feedback',
                'sq_uninstall_feedback',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Core_BlockSearch',
        'actions' => array(
            'action' => array(
                'sq_ajax_search',
            ),
        ),
        'active' => '1',
    ),
    array(
        'name' => 'SQ_Controllers_Dashboard',
        'actions' => array(
            'action' => array(
                'sq_ajaxcheckseo',
            ),
        ),
        'active' => '1',
    ),
));