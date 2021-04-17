<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php if (SQ_Classes_Helpers_Tools::getMenuVisible('show_tutorial')) { ?>
    <?php $page = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', '')); ?>
    <div class="mt-2">
        <div class="sq_knowledge p-2">
            <h4 class="mt-2 text-center">

                <?php echo esc_html__("Knowledge Base", _SQ_PLUGIN_NAME_) ?>
                <a href="https://howto.squirrly.co/" target="_blank">
                    <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/knowledge.png' ?>" style="width: 150px;display: block;margin: 0 auto;">
                </a>
            </h4>
            <div>
                <?php if (SQ_Classes_Helpers_Tools::getOption('sq_api') == '') { ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/install-squirrly-seo-plugin/#connect_to_cloud" target="_blank">Why connect to Squirrly Cloud?</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/wordpress-seo/squirrly-seo-error-messages/" target="_blank">I <strong>receive an error</strong> while login.</a>
                        </li>
                    </ul>
                <?php } elseif ($page == 'sq_dashboard') { ?>
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/import-export-seo-settings/#import_seo" target="_blank">How to <strong>Import SEO</strong> from other SEO plugins.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/install-squirrly-seo-plugin/#top_10_race" target="_blank">How to get on <strong>TOP 10 Google</strong>?</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/next-seo-goals/" target="_blank">How to use <strong>Next SEO Goals</strong>?</a>
                        </li>
                    </ul>
                    <div class="text-center m-2">
                        <a href="https://howto.squirrly.co/kb/install-squirrly-seo-plugin/" target="_blank">[ go to knowledge base ]</a></div>
                <?php } elseif ($page == 'sq_research') { ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#find_new_keywords" target="_blank">How to do a Keyword Research.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_add_keyword" target="_blank">How to <strong>add Keywords</strong> into Briefcase.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_label" target="_blank">How to categorize Keywords.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_optimize_sla" target="_blank">How to <strong>optimize a post</strong> with Briefcase.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_backup_keywords" target="_blank">How to <strong>backup/restore</strong> Keywords.</a>
                        </li>
                    </ul>
                    <div class="text-center m-2">
                        <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/" target="_blank">[ go to knowledge base ]</a></div>
                <?php } elseif ($page == 'sq_assistant') { ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#all_tasks_green" target="_blank">How to <strong>100% optimize</strong> a post, page or product with Squirrly Live Assistant.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#copyright_free_images" target="_blank">How to add <strong>Copyright Free Images</strong>.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/faq/why-is-the-squirrly-live-assistant-not-loading-in-the-post-editor/" target="_blank">Squirrly Live Assistant not showing.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#after_optimization" target="_blank">What to do <strong>after I optimize a post</strong>.</a>
                        </li>
                    </ul>
                    <div class="text-center m-2">
                        <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/" target="_blank">[ go to knowledge base ]</a></div>
                <?php } elseif ($page == 'sq_seosettings') { ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/seo-automation/" target="_blank">How to set the <strong>SEO in just 2 minutes</strong>.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_og" target="_blank">How to <strong>optimize Social Media</strong> for each post.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_jsonld" target="_blank">How to activate <strong>Rich Snippets</strong> for Google.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/google-analytics-tracking-tool/#amp_support" target="_blank">How to activate <strong>AMP Support</strong>.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/google-analytics-tracking-tool/#receive_tracking_code" target="_blank">How to activate <strong>GA4 Tracking</strong>.</a>
                        </li>
                    </ul>
                    <div class="text-center m-2">
                        <a href="https://howto.squirrly.co/kb/seo-automation/" target="_blank">[ go to knowledge base ]</a></div>
                <?php } elseif ($page == 'sq_focuspages') { ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/focus-pages-page-audits/#add_new_focus_page" target="_blank">How to <strong>add a new</strong> Focus Page.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/focus-pages-page-audits/#remove_focus_page" target="_blank">How to <strong>remove a</strong> Focus Page.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/focus-pages-page-audits/#chance_to_rank" target="_blank">What is <strong>Chance to Rank</strong>?</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/focus-pages-page-audits/#keyword" target="_blank">How to <strong>add a keyword</strong> in a Focus Page.</a>
                        </li>
                    </ul>
                    <div class="text-center m-2">
                        <a href="https://howto.squirrly.co/kb/focus-pages-page-audits/" target="_blank">[ go to knowledge base ]</a></div>
                <?php } elseif ($page == 'sq_audits') { ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/seo-audit/#how_seo_audit_works" target="_blank">How does the Audit work?</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/seo-audit/#add_new_audit_page" target="_blank">How to <strong>add a page</strong> in Audit.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/seo-audit/#delete_page" target="_blank">How to <strong>remove a page</strong> from Audits.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/seo-audit/#google_search_console" target="_blank">Connect to <strong>Google Search Console</strong>.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/seo-audit/#google_analytics" target="_blank">Connect to <strong>Google Analytics</strong>.</a>
                        </li>
                    </ul>
                    <div class="text-center m-2">
                        <a href="https://howto.squirrly.co/kb/seo-audit/" target="_blank">[ go to knowledge base ]</a></div>
                <?php } elseif ($page == 'sq_rankings') { ?>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/ranking-serp-checker/#add_keyword_ranking" target="_blank">How to <strong>add a Keyword</strong> in Rankings.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/ranking-serp-checker/#sync_keyword_ranking" target="_blank">How to <strong>sync a Keyword</strong> with GSC.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/ranking-serp-checker/#remove_keyword_ranking" target="_blank">How to <strong>remove a keyword</strong> from Rankings.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://howto.squirrly.co/kb/ranking-serp-checker/#check_keyword_information" target="_blank">Check the Keyword <strong>Impressions, Clicks and Optimization</strong>.</a>
                        </li>
                        <li class="list-group-item text-left">
                            <a href="https://fourhourseo.com/why-does-neil-patel-use-squirrly-seo-for-every-blog-post-that-he-publishes/" target="_blank">Why Does Neil Patel Use Squirrly SEO For Every Blog Post that He Publishes?</a>
                        </li>
                    </ul>
                    <div class="text-center m-2">
                        <a href="https://howto.squirrly.co/kb/ranking-serp-checker/" target="_blank">[ go to knowledge base ]</a></div>
                <?php } ?>
            </div>
        </div>

    </div>
<?php } ?>