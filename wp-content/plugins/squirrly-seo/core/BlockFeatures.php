<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Core_BlockFeatures extends SQ_Classes_BlockController {

    public function init() {
        echo $this->getView('Blocks/Features');
    }

    public function getFeatures() {
        $connect = SQ_Classes_Helpers_Tools::getOption('connect');
        $sitemap = SQ_Classes_Helpers_Tools::getOption('sq_sitemap');
        $features = array(
            array(
                'title' => "Squirrly Cloud App",
                'description' => "Many Squirrly features work from <bold>cloud.squirrly.co</bold> and helps you optimize the content and manage the keywords, audits and rankings.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'squirrly.png',
                'link' => SQ_Classes_RemoteController::getMySquirrlyLink('dashboard'),
                'details' => 'https://howto.squirrly.co/kb/squirrly-cloud-app/',
            ), //Squirrly Cloud
            array(
                'title' => "14 Days Journey Course",
                'description' => "<strong>Improve your Online Presence</strong> by knowing how your website is performing. All you need now is to start driving One of your most valuable pages to <strong>Better Rankings</strong>.",
                'mode' => "Free",
                'option' => false,
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_seojourney'),
                'optional' => false,
                'connection' => true,
                'logo' => 'journey_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'journey1'),
                'details' => 'https://howto.squirrly.co/kb/install-squirrly-seo-plugin/#journey',
            ), //14 Days Journey Course
            array(
                'title' => "Next SEO Goals",
                'description' => "The AI SEO Consultant with <strong>over 100+ signals</strong> that prepares your goals to take you closer to the first page of Google.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'goals_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard', '', array('#tasks')),
                'details' => 'https://howto.squirrly.co/kb/next-seo-goals/',
            ),//Next SEO Goals
            array(
                'title' => "Progress & Achievements",
                'description' => "Displays <strong>Success Messages</strong> and <strong>Progress & Achievements</strong> for SEO Goals, Focus Pages, Audits, and Rankings",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'progress_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard', '', array('#tasks')),
                'details' => 'https://howto.squirrly.co/kb/squirrly-seo-goals/',
            ),//Progress
            array(
                'title' => "Focus Pages",
                'description' => "Brings you clear methods to take your pages <strong>from never found to always found on Google</strong>. Rank your pages by influencing the right ranking factors.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'focuspages_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'pagelist'),
                'details' => 'https://howto.squirrly.co/kb/focus-pages-page-audits/',
            ), //Focus Pages
            array(
                'title' => "Chances of Ranking",
                'description' => "Get information about <strong>Chances of Ranking for each Focus Page</strong> based on our <strong>Machine Learning Algorithms and Ranking Vision A.I.</strong>",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'focuspages_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'pagelist'),
                'details' => 'https://howto.squirrly.co/kb/focus-pages-page-audits/#chance_to_rank',
            ), //Chances of Ranking
            array(
                'title' => "Keyword Research",
                'description' => "Find the <strong>Best Keywords</strong> that your own website can rank for and get <strong>personalized competition data</strong> for each keyword. Provides info on Region that was used for Keyword Research.",
                'mode' => "Free",
                'option' => false   ,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'kr_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research'),
                'details' => 'https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/',
            ), //Keyword Research
            array(
                'title' => "Google Search & Trends",
                'description' => "Keyword Research uses tird-party services like <strong>Google Search API and Google Trends API</strong> to get live research data for each keyword. The research algorithm processes <strong>more than 100 processes</strong> for each keyword you selected.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'kr_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research'),
                'details' => 'https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/',
            ), //Keyword Research
            array(
                'title' => "Briefcase",
                'description' => "Add keywords in your portfolio based on your current Campaigns, Trends, Performance <strong>for a successful SEO strategy</strong>.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'briefcase_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase'),
                'details' => 'https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase',
            ),//SEO Briefcase
            array(
                'title' => "Live Assistant",
                'description' => "Publish <strong>content that is fully optimized</strong> for BOTH Search Engines and Humans – every single time!",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'sla_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant'),
                'details' => 'https://howto.squirrly.co/kb/squirrly-live-assistant/',
            ),//Live Assistant
            array(
                'title' => "Keywords Optimization",
                'description' => "Optimize for <strong>Multiple Keywords at once in a Single Page</strong>. Automatically Calculates Optimization Scores for all secondary keywords and displays them to you as you’re typing your page.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'briefcase_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant'),
                'details' => 'https://howto.squirrly.co/kb/squirrly-live-assistant/#add_keyword',
            ),//Keywords Optimization
            array(
                'title' => "Elementor Website Builder",
                'description' => "The SEO Live Assistant <strong>works on the front-end of Elementor</strong>, just as you're creating or editing your Elementor page.",
                'mode' => "Free",
                'option' => 'sq_sla_frontend',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_sla_frontend'),
                'optional' => true,
                'connection' => false,
                'logo' => 'sla_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant', 'settings'),
                'details' => 'https://howto.squirrly.co/kb/squirrly-live-assistant/#elementor',
            ),//Live Assistant Elementor
            array(
                'title' => "Google Rankings with GSC",
                'description' => "Get <strong>Google Search Console (GSC)</strong> average <strong>possitions, clicks and impressions</strong> for organic keywords.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'ranking_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'rankings'),
                'details' => 'https://howto.squirrly.co/kb/ranking-serp-checker/',
            ),//Google SERP with GSC
            array(
                'title' => "SEO Automation",
                'description' => "Configure the <strong>SEO in 2 minutes</strong> for the entire website without writing a line of code.",
                'mode' => "Free",
                'option' => 'sq_auto_pattern',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern'),
                'optional' => true,
                'connection' => false,
                'logo' => 'automation_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation'),
                'details' => 'https://howto.squirrly.co/kb/seo-automation/',
            ),//SEO Automation
            array(
                'title' => "Bulk SEO & Snippets",
                'description' => "Simplify the SEO process to <strong>Optimize all the SEO Snippets</strong> in just minutes. Edit Snippets in BULK for all post types directly from All Snippets",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => false,
                'logo' => 'bulkseo_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                'details' => 'https://howto.squirrly.co/kb/bulk-seo/',
            ),//Bulk SEO
            array(
                'title' => "Frontend SEO Snippet",
                'description' => "Optimize each page by loading the <strong>SEO Snippet directly on the front-end</strong> of your site. You have <strong>Custom SEO</strong> directly in the WP Admin Toolbar.",
                'mode' => "Free",
                'option' => 'sq_use_frontend',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_use_frontend'),
                'optional' => true,
                'connection' => false,
                'logo' => 'bulkseo_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas'),
                'details' => 'https://howto.squirrly.co/kb/seo-metas/#Add-Snippet-in-Frontend',
            ),//Frontend SEO Snippet
            array(
                'title' => "Open Graph Optimization",
                'description' => "Add Social Open Graph protocol so that <strong>your Facebook Shares look awesome</strong>.",
                'mode' => "Free",
                'option' => 'sq_auto_facebook',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook'),
                'optional' => true,
                'connection' => false,
                'logo' => 'social_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social'),
                'details' => 'https://howto.squirrly.co/kb/social-media-settings/#opengraph',
            ),//Open Graph Optimization
            array(
                'title' => "Twitter Card Optimization",
                'description' => "Add Twitter Card in your tweets so that your <strong>Twitter Shares look awesome</strong>.",
                'mode' => "Free",
                'option' => 'sq_auto_twitter',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter'),
                'optional' => true,
                'connection' => false,
                'logo' => 'social_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'social'),
                'details' => 'https://howto.squirrly.co/kb/social-media-settings/#twittercard',
            ),//Twitter Card Optimization
            array(
                'title' => "Sitemap XML",
                'description' => "Use Sitemap Generator to <strong>help your website get crawled</strong> and indexed by Search Engines. Add Sitemap Support for News, Posts, Pages, Products, Tags, Categories, Taxonomies, Images, Videos, etc.",
                'mode' => "Free",
                'option' => 'sq_auto_sitemap',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap'),
                'optional' => true,
                'connection' => false,
                'logo' => 'sitemap_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'sitemap'),
                'details' => 'https://howto.squirrly.co/kb/sitemap-xml-settings/',
            ), //XML Sitemap
            array(
                'title' => "Google News",
                'description' => "For a news website it's really important to have a Google News Sitemap. This way you will have <strong>all your News Posts instantly on Google News</strong>.",
                'mode' => "Free",
                'option' => false,
                'active' => ($sitemap['sitemap-news'][1] == 1),
                'optional' => false,
                'connection' => false,
                'logo' => 'news_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'sitemap'),
                'details' => 'https://howto.squirrly.co/kb/sitemap-xml-settings/#news_sitemap',
            ), //Sitemap Instant Indexing
            array(
                'title' => "JSON-LD Structured Data",
                'description' => "Edit your website's JSON-LD Schema with Squirrly's powerful <strong>semantic SEO Markup Solution</strong>. Use the built-in Structured Data or add your custom Schema code.",
                'mode' => "Free",
                'option' => 'sq_auto_jsonld',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld'),
                'optional' => true,
                'connection' => false,
                'logo' => 'jsonld_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'jsonld'),
                'details' => 'https://howto.squirrly.co/kb/json-ld-structured-data/',
            ), //JSON-LD Optimizaition
            array(
                'title' => "ACF Integration",
                'description' => "Use <strong>Advanced Custom Fields (ACF)</strong> plugin to add advanced and custom JSON-LD Schema code on your pages.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => false,
                'logo' => 'jsonld_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'jsonld'),
                'details' => 'https://howto.squirrly.co/kb/json-ld-structured-data/#ACF',
            ), //Advanced Custom Fields
            array(
                'title' => "Google Analytics Tracking",
                'description' => "Add the <strong>Google Analytics</strong> and <strong>Google Tag Manager</strong> tracking on your website.",
                'mode' => "Free",
                'option' => 'sq_auto_tracking',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking'),
                'optional' => true,
                'connection' => false,
                'logo' => 'traffic_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'tracking'),
                'details' => 'https://howto.squirrly.co/kb/google-analytics-tracking-tool/#google_analytics',
            ), //Google Analytics Tracking
            array(
                'title' => "AMP Support",
                'description' => sprintf("Automatically load the <strong>Accelerate Mobile Pages (AMP)</strong> support for plugins like %sAMP for WP%s or %sAMP%s.", '<a href="https://wordpress.org/plugins/accelerated-mobile-pages/" target="_blank">', '</a>', '<a href="https://wordpress.org/plugins/amp/" target="_blank">', '</a>'),
                'mode' => "Free",
                'option' => 'sq_auto_amp',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_amp'),
                'optional' => true,
                'connection' => false,
                'logo' => 'amp_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'tracking'),
                'details' => 'https://howto.squirrly.co/kb/google-analytics-tracking-tool/#amp_support',
            ), //
            array(
                'title' => "Facebook Pixel Tracking",
                'description' => "Track visitors with <strong>website and e-commerce events</strong> for better Retargeting Campaigns. <strong>Integrated with Woocommerce</strong> plugin with events like Add to Cart, Initiate Checkout, Payment, and more.",
                'mode' => "Free",
                'option' => 'sq_auto_pixels',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_pixels'),
                'optional' => true,
                'connection' => false,
                'logo' => 'traffic_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'tracking'),
                'details' => 'https://howto.squirrly.co/kb/google-analytics-tracking-tool/#facebook_pixel',
            ), //Facebook Pixel Tracking
            array(
                'title' => "Webmaster Tools",
                'description' => "Connect your website with the popular webmasters like <strong>Google Search Console (GSC), Bing, Baidu, Yandex, Alexa</strong>.",
                'mode' => "Free",
                'option' => 'sq_auto_webmasters',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_webmasters'),
                'optional' => true,
                'connection' => false,
                'logo' => 'websites_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'webmaster'),
                'details' => 'https://howto.squirrly.co/kb/webmaster-tools-settings/',
            ), //Webmaster Tools
            array(
                'title' => "Google Search Console (GSC)",
                'description' => "Connect your website with <strong>Google Search Console</strong> and get insights based on <strong>organic searched keywords</strong>.",
                'mode' => "Free",
                'option' => 'sq_auto_webmasters',
                'active' => (isset($connect['google_search_console']) ? $connect['google_search_console'] : true),
                'optional' => false,
                'connection' => true,
                'logo' => 'websites_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'settings'),
                'details' => 'https://howto.squirrly.co/kb/ranking-serp-checker/#google_search_console',
            ), //Google Search Console
            array(
                'title' => "Robots.txt File",
                'description' => "Tell search engine crawlers which pages or files the crawler can or can't request from your site.",
                'mode' => "Free",
                'option' => 'sq_auto_robots',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_robots'),
                'optional' => true,
                'connection' => false,
                'logo' => 'robots_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'robots'),
                'details' => false,
            ), //Robots.txt File
            array(
                'title' => "Favicon Site Icon",
                'description' => "Add your <strong>website icon</strong> in the browser tabs and on other devices like <strong>iPhone, iPad and Android phones</strong>.",
                'mode' => "Free",
                'option' => 'sq_auto_favicon',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_favicon'),
                'optional' => true,
                'connection' => false,
                'logo' => 'favicon_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'favicon'),
                'details' => 'https://howto.squirrly.co/kb/website-favicon-settings/',
            ), //Favicon Site Icon
            array(
                'title' => "SEO Links",
                'description' => "Increase the <strong>website authority</strong> by correctly managing all the external links on your website. Instantly add <strong>nofollow</strong> to all external links.",
                'mode' => "Free",
                'option' => 'sq_auto_links',
                'active' => (bool)SQ_Classes_Helpers_Tools::getOption('sq_auto_links'),
                'optional' => true,
                'connection' => false,
                'logo' => 'links_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'links'),
                'details' => 'https://howto.squirrly.co/kb/seo-links/',
            ), //SEO Links
            array(
                'title' => "On-Page SEO METAs",
                'description' => "Add all the required Search Engine METAs like <strong>Title Meta, Description, Canonical Link, Dublin Core, Robots Meta</strong> and more.",
                'mode' => "Free",
                'option' => 'sq_auto_metas',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_metas'),
                'optional' => true,
                'connection' => false,
                'logo' => 'metas_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'metas'),
                'details' => 'https://howto.squirrly.co/kb/seo-metas/',
            ), //On-Page SEO METAs
            array(
                'title' => "Remove META Duplicate",
                'description' => "Fix Duplicate Title, Description, Canonical, Dublin Core, Robots and more without writing a line of code.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => false,
                'logo' => 'metas_92.png',
                'link' => false,
                'details' => 'https://howto.squirrly.co/kb/seo-metas/#remove_duplicates',
            ), //Remove META Duplicate
            array(
                'title' => "404 URLs Redirects",
                'description' => "Automatically <strong>redirect 404 URLs</strong> to the new URLs and keep the post authority. You can manage the <strong>Redirect Broken URLs</strong> for each post type.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => false,
                'logo' => 'redirect_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation', array('#tab=nav-post')),
                'details' => 'https://howto.squirrly.co/kb/seo-automation/#redirect_broken_urls',
            ), //404 Redirects
            array(
                'title' => "SEO Audit",
                'description' => "Improve your Online Presence by knowing how your website is performing online. <strong>Generate and Compare SEO Audits</strong> and follow the Assistant to optimize the website.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'audit_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'audits'),
                'details' => 'https://howto.squirrly.co/kb/seo-audit/',
            ), //SEO Audit
            array(
                'title' => "Moz",
                'description' => "Receive information about <strong>Backlinks and Authority from Moz.com</strong> directly in your SEO Audit report.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'audit_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'audits'),
                'details' => 'https://howto.squirrly.co/kb/seo-audit/#moz',
            ), //SEO Audit Moz
            array(
                'title' => "Majestic",
                'description' => "Receive information about <strong>Backlinks from Majestic.com</strong> directly in your SEO Audit report.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'audit_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'audits'),
                'details' => 'https://howto.squirrly.co/kb/seo-audit/#majestic',
            ), //SEO Audit Majestic
            array(
                'title' => "Alexa",
                'description' => "Receive <strong>Alexa Score and Backlinks</strong> information directly in your SEO Audit report.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'audit_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'audits'),
                'details' => 'https://howto.squirrly.co/kb/seo-audit/#alexa',
            ), //SEO Audit Alexa
            array(
                'title' => "Google PageSpeed Insights",
                'description' => "Get precise information about the <strong>Average Loading Time</strong> of your website using Google PageSpeed Insights in your SEO Audit report.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'audit_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'audits'),
                'details' => 'https://howto.squirrly.co/kb/seo-audit/#google_pagespeed',
            ), //SEO Audit Google PageSpeed
            array(
                'title' => "Blogging Assistant",
                'description' => "Add relevant <strong>Copyright-Free images, Tweets, Wikis, Blog Excerpts</strong> in your posts.",
                'mode' => "Pro",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'sla_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant'),
                'details' => 'https://howto.squirrly.co/kb/squirrly-live-assistant/#live_assistant_box',
            ), //Blogging Assistant
            array(
                'title' => "Google SERP Checker",
                'description' => "Accurately track your <strong>Google Rankings every day</strong> with Squirrly's user-friendly Google SERP Checker.",
                'mode' => "Business",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'ranking_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'rankings'),
                'details' => 'https://howto.squirrly.co/kb/ranking-serp-checker/',
            ), //Google SERP Checker
            array(
                'title' => "Copyright Free Images",
                'description' => "Search <strong>Copyright Free Images</strong> in Squirrly Live Assistant and import them directly on your content.",
                'mode' => "free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => true,
                'logo' => 'image_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant'),
                'details' => 'https://howto.squirrly.co/kb/squirrly-live-assistant/#copyright_free_images',
            ), //Blogging Assistant
            array(
                'title' => "WooCommerce SEO",
                'description' => "<strong>Optimize all WooCommerce Products</strong> with Squirrly Live Assistant for better ranking. Add the required Metas, Google Tracking, Facebook Pixel Events and JSON-LD Schema. Useful for loading Rich Snippets on Google search results.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => false,
                'logo' => 'shop_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo', array('stype=product')),
                'details' => 'https://howto.squirrly.co/kb/json-ld-structured-data/#woocommerce',
            ), //
            array(
                'title' => "Polylang",
                'description' => "<strong>Multilingual Support</strong> with Polylang plugin for fast multilingual optimization. Load Squirrly Live Assistant, SEO Snippets and Sitemap XML based on Polylang language.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => false,
                'logo' => 'multilingual_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                'details' => 'https://howto.squirrly.co/wordpress-seo/compatibility-with-polylang-plugin/',
            ), //
            array(
                'title' => "Local SEO",
                'description' => "Optimize the website for <strong>local audience</strong> to have a huge advantage in front of your competitors.",
                'mode' => "Free",
                'option' => 'sq_auto_jsonld_local',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld_local'),
                'optional' => true,
                'connection' => false,
                'logo' => 'local_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'jsonld', array('#localseo')),
                'details' => 'https://howto.squirrly.co/kb/json-ld-structured-data/#local_seo',
            ), //
            array(
                'title' => "Settings Assistant",
                'description' => "With many of the Assistant panels in all Squirrly Setting pages, all a user needs to do is <strong>turn Red dots into Green dots</strong>.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => false,
                'logo' => 'audit_92.png',
                'link' => false,
                'details' => 'https://howto.squirrly.co/kb/squirrly-settings-assistant/',
            ),//Live Assistant Elementor
            array(
                'title' => "Fetch SEO Snippet",
                'description' => sprintf("Automatically <strong>fetch the Squirrly Snippet</strong> on %sFacebook Sharing Debugger%s every time you update the content on a page.", '<a href="https://developers.facebook.com/tools/debug/" target="_blank">', '</a>'),
                'mode' => "Free",
                'option' => 'sq_sla_social_fetch',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_sla_social_fetch'),
                'optional' => true,
                'connection' => true,
                'logo' => 'social_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant', 'settings'),
                'details' => 'https://howto.squirrly.co/kb/squirrly-live-assistant/#fetch_social',
            ), //
            array(
                'title' => "SEO Images",
                'description' => "Automatically <strong>downloads image and adds image alt tag</strong> for you, if you searched for images using your focus keyword <strong>inside the Blogging Assistant</strong>.",
                'mode' => "Free",
                'option' => 'sq_local_images',
                'active' => SQ_Classes_Helpers_Tools::getOption('sq_local_images'),
                'optional' => true,
                'connection' => false,
                'logo' => 'image_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant', 'settings'),
                'details' => 'https://howto.squirrly.co/kb/squirrly-live-assistant/#seo_image',
            ), //

            array(
                'title' => "Plugins Integration",
                'description' => "Squirrly SEO works with all websites types and popular plugins like <strong>E-commerce plugins, Page Builder plugins, Cache plugins, SEO plugins, Multilingual plugins, and more</strong>.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => false,
                'logo' => 'settings_92.png',
                'link' => false,
                'details' => 'https://howto.squirrly.co/',
            ), //
            array(
                'title' => "Import SEO & Settings",
                'description' => "Import the settings and SEO from other plugins so you can use only Squirrly SEO for on-page SEO.",
                'mode' => "Free",
                'option' => false,
                'active' => true,
                'optional' => false,
                'connection' => false,
                'logo' => 'settings_92.png',
                'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'backup'),
                'details' => 'https://howto.squirrly.co/kb/import-export-seo-settings/',
            ), //Import SEO & Settings


        );

        //for PHP 7.3.1 version
        $features = array_filter($features);

        return apply_filters('sq_features', $features);
    }
}
