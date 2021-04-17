<?php

class SQ_Models_Audits {

    /** @var array todos */
    protected $_todo = array();

    /** @var SQ_Models_Domain_AuditPage */
    protected $_auditpage;

    public function getTasks() {
        return array(
            'blogging' => array(
                'Optimization' => array(
                    'complete' => false,
                    'title' => esc_html__("Average Content Optimization", _SQ_PLUGIN_NAME_),
                    'success' => '%s%%. ' . esc_html__("Great!", _SQ_PLUGIN_NAME_),
                    'fail' => '%s%%. ' . esc_html__("hmm...", _SQ_PLUGIN_NAME_),
                    'description' => sprintf(esc_html__("How can we fix the SEO optimization of a page on our website? %s Find an amazing keyword set to use for your page. %s If you have a page about a Jazz Concert that John Dane (fictional name used for this example) will do on 9th of August 2025 in Phoenix, AZ, then you can try and find the best keywords you can use, that are related to: 'jazz concert', 'john dane', 'jazz 2025' and 'jazz in phoenix'. Find out what others search for. If you'll optimize the page for those keywords, you'll be certain that jazz fans will find it. The keyword research tool available in Squirrly SEO helps you figure out exactly what keywords to use. %s Start optimizing your content.  Use the Live Assistant from Squirrly SEO to do this, as it guides you towards the best practices of optimizing a page for SEO and helps you avoid keyword stuffing.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Optimization is NOT about stuffing in keywords. It's about writing the page in such a way that Search Engine bots and Humans alike will easily understand that the page is exactly about the topic they were searching for. Use the Live Assistant from Squirrly SEO to get the job done with ease.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Use tools like Squirrly Keyword Research and Squirrly Live Assistant to optimize your content", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistants'),
                ),
                'DcPublisher' => array(
                    'complete' => false,
                    'title' => esc_html__("DcPublisher Meta", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!' . '<div class="sq_list_error_title">' . esc_html__("The pages without DcPublisher meta", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => esc_html__("Dublin Core is a set of standard metadata elements used to describe the contents of a website. It can help with some internal search engines and it does not bloat your code.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add the meta DcPublisher tag in the page's header", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
            ),
            'traffic' => array(
                'TopTen' => array(
                    'complete' => false,
                    'title' => esc_html__("Top Ten Pages This Week", _SQ_PLUGIN_NAME_),
                    'success' => '<div class="sq_list_success">%s</div>',
                    'fail' => '<div class="sq_list_success">%s</div>',
                    'description' => sprintf(esc_html__("If there is enough data in Google Analytics, you should see the list of pages with the most visitors in the last week. %s Having at least 100 visitors per page every week is crucial. %s Search Engines like Google and Bing will push down a page which doesn't attract visitors.", _SQ_PLUGIN_NAME_), '<br/><br/>', '<br/>'),
                ),
                'PageViews' => array(
                    'complete' => false,
                    'title' => esc_html__("Page Traffic", _SQ_PLUGIN_NAME_),
                    'success' => '{total} ' . esc_html__(" total visits / mo.", _SQ_PLUGIN_NAME_),
                    'fail' => '<div class="sq_list_error_title">' . esc_html__("The pages with low traffic", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Overall Traffic of the website? %s Make sure you have active listings which can be easily found on various marketplaces / platforms. eg: you have a Shopify app, a Chrome Extension, a Chrome App, a Udemy Course, Slides on SlideShare.com, videos on Youtube, an infographic on Pinterest, etc. These will always bring you constant traffic to the website and once you set it (and make it visible) you can forget it. It will keep bringing you traffic. Of course, the key is to first make these items visible in the places where you publish them. %s You need an email list. Make sure that people who come to your store, do business with you, visit your website, or read your blog give you their email address so you can communicate with them further on. An alternative to this is to make a Chatbot for Facebook Messenger and get them hooked to the bot. By doing any of these, you'll be able to bring those people back to your website. %sUse the Keyword Research tool included in Squirrly SEO, to spot keywords that are easy to rank for: [link]https://plugin.squirrly.co/best-keyword-research-tool-for-seo/[link] %sRank for more keywords with low competition. This will start building up traffic for your site. %sTo Easily rank new pages, use the SEO Goals: [link]https://plugin.squirrly.co/best-seo-goals/[/link] %sStudy website rankings to learn how to bring more traffic, by using our Special Cloud Services for Rank Checking, available only on: Business Plans [link]https://plugin.squirrly.co/squirrly-seo-pricing/[/link]", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Get each person who arrives on your site once to leave something that you can use later on to bring them to your site again. You can use Facebook Pixel and then retarget them, you can make them subscribe to Desktop Notifications to receive push notifications, you can have them download an app, subscribe to a newsletter, etc. Sometimes it's best if you can create clever funnels that will ensure that any person may start following you on multiple such channels.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Try to gain organic traffic to your site's pages", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
            ),
            'seo' => array(
                'NoIndex' => array(
                    'complete' => false,
                    'title' => esc_html__("Visible for search engines?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!' . '<div class="sq_list_error_title">' . esc_html__("The pages with noindex", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the noindex for our pages? %s You're currently telling Google not to index some of your pages through a robots tag inside your code. %s On WordPress, it's super easy to control on which pages to place no-index and which pages should never get tagged with no-index if you use the Squirrly SEO Plugin. %s If you decided you 100%% want these pages to be No-Index (you don’t want Google to index them) - then remove these pages from the SEO Audit. Use the SEO Audit for the pages you want to be seen on search engines.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li><li>','</li></ul>'),
                    'protip' => esc_html__("Some pages are better off if they have an associated no-index tag. Every website has a couple of pages that would be completely pointless to appear in search results, because they wouldn't ever make any sense for potential searchers.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add the correct meta robots tag in the pages", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'NoFollow' => array(
                    'complete' => false,
                    'title' => esc_html__("Followed by search engines?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!' . '<div class="sq_list_error_title">' . esc_html__("The pages with nofollow", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the nofollow for our pages? %s You're currently telling Google not to follow some of your pages through a robots tag inside your code. %s On WordPress, it's super easy to control on which pages to place nofollow and which pages should never get tagged with nofollow if you use the Squirrly SEO Plugin. %s If you're using something else, make sure you remove <META NAME=“ROBOTS” CONTENT=“NOFOLLOW”> from the <head> of your HTML.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Some pages are better off if they have an associated nofollow tag. Every website has a couple of pages that would be completely pointless to be followed by search results like: Contact Us, Terms and Policy.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add the correct meta robots tag in the pages", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'SafeBrowsing' => array(
                    'complete' => false,
                    'title' => esc_html__("Is your site Safe Browsing?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!',
                    'description' => sprintf(esc_html__("How can we get our website to be Safe Browsing compliant? %s Make sure you find and delete all malware from your website. %s Watch this video to learn more. [link]https://www.youtube.com/embed/7GStGcTeo20[/link] %s Once you feel like you've fixed your problems you can check using this tool from Google: [link]https://transparencyreport.google.com/safe-browsing/search[/link]%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("This is a TOP priority if you're having a Safe Browsing problem at the moment. Browsers will NOT allow web visitors to actually access your pages. It will also cause you other problems like lower search rankings.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'Speed' => array(
                    'complete' => false,
                    'title' => esc_html__("Page load time", _SQ_PLUGIN_NAME_),
                    'success' => '{total}' . 's ' . esc_html__("average is a good time"),
                    'fail' => '{total}' . 's ' . esc_html__("average is slow") . '<div class="sq_list_error_title">' . esc_html__("The slow pages are", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the loading speed of the website? %s Use smaller images, or compress them with tools like ShortPixel.com %s Minify Javascripts, use CDNs, use gZip. %s Use a professional service if your site is based on WordPress. Our parent company, Squirrly Limited, offers such a service for WordPress.org based websites [link]https://www.squirrly.co/agency/[/link] %s After you optimize the page, test the loading Speed Index with Google Speed Test here [link]https://developers.google.com/speed/pagespeed/insights/[/link] %s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li style="text-align: center; font-weight: 600;  color: #fff;  display: block; background: #43464b; padding: 30px;">Squirrly negotiated a special Free Plan for you that gives you more credits for images, then they do on their own sites: <a href="https://www.squirrly.co/wordpress/plugins/short-pixel/" title="shortpixel" target="_blank" style="color: #f16334;">https://www.squirrly.co/wordpress/plugins/short-pixel/</a> ShortPixel reduced the size of our images by 84% and kept the same quality” - Andreea, Communications Expert at Squirrly </li><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Increasing loading speed will bring you more engagement, lower bounce rates AND more search engine results.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Optimize your site's speed", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'DuplicateTitles' => array(
                    'complete' => false,
                    'title' => esc_html__("Duplicate Titles", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("No duplicate titles.", _SQ_PLUGIN_NAME_) . '<div class="sq_list_success"><strong>' . esc_html__("Great!", _SQ_PLUGIN_NAME_) . '</strong> ' . esc_html__("The pages on your site have unique title tags.", _SQ_PLUGIN_NAME_) . '</div>',
                    'fail' => esc_html__("We found duplicates.", _SQ_PLUGIN_NAME_) . '<div class="sq_list_error_title">' . esc_html__("The Pages with Duplicate Titles are", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Duplicate Titles on our pages? %s Features like SEO Automation or SEO Snippet from Squirrly SEO will generate your META title automatically from the content of your page (in case you didn't already place a custom title). Make every single META Title of every page unique (you never repeat it on any other URL from the website). You will write what you want Google to display in the search results as a title for your listing. Make this text awesome and you'll get people clicking on it. %s See if you can assign rules to WordPress to have it change the Title of each URL according to different patterns. Normally the platform will take the Title of the latest product inside the category and add it to the Title of that particular category. In this case you can end up with something like: example.com/shooter-games will have title: 'Counter Strike GO. Buy it Now' and also: example.com/shooter-games/cs-go will also have title: 'Counter Strike GO. Buy it Now'. %s All these problematic cases can be forgotten once you start using Squirrly SEO . With its Patterns feature, it will create rules for WordPress that ensure each title for each page on your site is unique. This feature is available in the Free version of Squirry.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("On WordPress you can use Squirrly SEO to control everything about your page Titles and make them stand out on search engines.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add different titles to each page. You can do it manually or use SEO tools (like Squirrly) for that.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'DuplicateDescription' => array(
                    'complete' => false,
                    'title' => esc_html__("Duplicate Descriptions", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("No duplicate descriptions.", _SQ_PLUGIN_NAME_) . '<div class="sq_list_success"><strong>' . esc_html__("Great!", _SQ_PLUGIN_NAME_) . '</strong> ' . esc_html__("The pages on your site have unique meta descriptions.", _SQ_PLUGIN_NAME_) . '</div>',
                    'fail' => esc_html__("We found duplicates.", _SQ_PLUGIN_NAME_) . '<div class="sq_list_error_title">' . esc_html__("The Pages on which we found duplicates are", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Duplicate Descriptions on our website? %s Use the SEO Automation feature from Squirrly SEO, because it will generate your META description automatically from the content of your page (in case you didn't already place a custom description). Make every single META description of every page unique (you never repeat it on any other URL from the website). Make this text awesome and you'll get people clicking on it. %s Use the Patterns feature from Squirrly SEO. It will help you create rules for WordPress that ensure each description for each page on your site is unique. This feature is available on all plans. %s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>',  '</li></ul>'),
                    'protip' => esc_html__("Use Squirrly SEO’s BULK SEO section to control everything about your META descriptions and make them stand out on search engines.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add different description to each page. You can do it manually or use SEO tools (like Squirrly) for that.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'EmptyTitles' => array(
                    'complete' => false,
                    'title' => esc_html__("Empty Titles", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("All pages have titles.", _SQ_PLUGIN_NAME_) . '<div class="sq_list_success"><strong>' . esc_html__("Great!", _SQ_PLUGIN_NAME_) . '</strong> ' . esc_html__("all the pages on your site have the title tag defined :-)", _SQ_PLUGIN_NAME_) . '</div>',
                    'fail' => esc_html__("There are some pages without title.", _SQ_PLUGIN_NAME_) . '<div class="sq_list_error_title">' . esc_html__("The pages with empty Title tags are", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Empty Titles on our pages? %s Use Squirrly’s SEO Automation features or the SEO Snippet to generate your META title automatically from the content of your page. Write what you want Google to display in the search results as a title for your listing. Make this text awesome and you'll get people clicking on it. %s Use the Patterns feature from Squirrly. It will create rules for WordPress that ensure each title for each page on your site is unique. This feature is available on all plans.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Use Squirrly SEO to create and control everything about your META titles and make them stand out on search engines.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add a Title tag to each page in your site.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'EmptyDescription' => array(
                    'complete' => false,
                    'title' => esc_html__("Empty Descriptions", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("All articles have description.", _SQ_PLUGIN_NAME_) . '<div class="sq_list_success"><strong>' . esc_html__("Great!", _SQ_PLUGIN_NAME_) . '</strong> ' . esc_html__("all the pages on your site have meta description", _SQ_PLUGIN_NAME_) . '</div>',
                    'fail' => esc_html__("There are some pages without description.", _SQ_PLUGIN_NAME_) . '<div class="sq_list_error_title">' . esc_html__("The pages with empty description are", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Empty Descriptions on our website? %s Use Squirrly’s SEO Automation features or the SEO Snippet which will generate your META description automatically from the content of your page.  Make this text awesome and you'll get people clicking on it. %s See if you can assign rules to WordPress to have it create META descriptions for each URL according to different patterns. By having clear rules for all URLs you'll ensure that Empty Descriptions will no longer be a problem in the future. %s All these problematic cases can be forgotten once you start using Squirrly SEO . With its Patterns feature, it will create rules for WordPress that ensure each description for each page on your site is unique. This feature is available on all plans.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Use Squirrly SEO to create and control everything about your META descriptions and make them stand out on search engines.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add meta description to each page in your site.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'Title' => array(
                    'complete' => false,
                    'title' => esc_html__("Do you have a title tag?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes"),
                    'fail' => esc_html__("No") . '<div class="sq_list_error_title">' . esc_html__("The pages without title tag are", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the title tags of our pages %s On WordPress, using Squirrly SEO will ensure your pages have title tags. It will create titles for every page. It will help you customize titles for every page, all while making you write ZERO code. No coding required when you use Squirrly SEO.%s", _SQ_PLUGIN_NAME_), '<ul><li>',  '</li></ul>'),
                    'protip' => esc_html__("Platforms like Shopify handle this aspect with their default engine.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add a Title tag to this page of your site", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'Description' => array(
                    'complete' => false,
                    'title' => esc_html__("Do you have a meta description?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes"),
                    'fail' => esc_html__("No") . '<div class="sq_list_error_title">' . esc_html__("The pages without description meta are", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the META Descriptions of our pages %s First of all, make sure that you understand the following: a poorly written META description will make for a horrible listing inside the Google search page. If people find your listing, they will not click on your listing in case your META Description is horrible to look at, is poorly written, or it doesn't seem to make sense. %s On WordPress, you can use Squirrly SEO for this. It will automatically create META Descriptions for every page. It will help you customize these descriptions for every page, all while making you write ZERO, nada, rien, code. No coding required when you use Squirrly SEO. You can even customize the way it automates your descriptions.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Platforms like Shopify handle this with their default engines.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add meta description to this page of your site", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'Keywords' => array(
                    'complete' => false,
                    'title' => esc_html__("Meta Keyword", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '<div class="sq_list_success_title"><strong>' . esc_html__("Your keywords are", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_success">%s</div>',
                    'fail' => esc_html__("No keywords.", _SQ_PLUGIN_NAME_),
                    'description' => esc_html__("It is important for search engines to know which keywords you are trying to rank for with your website. This also helps bring targeted visitors to your site.", _SQ_PLUGIN_NAME_),
                    'protip' => esc_html__("Make sure that the search for your keywords is on a rising trend", _SQ_PLUGIN_NAME_),
                    'solution' => '',
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'Canonical' => array(
                    'complete' => false,
                    'title' => esc_html__("Canonical Link", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!' . '<div class="sq_list_error_title">' . esc_html__("The pages without canonical meta", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Canonical Links problems of our pages? %s Add this code to the <head> section of your HTML page: <link rel=\"canonical\" href=\"your site URL\" /> %s Think of a canonical link as the \"preferred version\" of the page. %s Make sure you have this definition on your URL especially if you've copied the content from another LINK on the web. Example: You published a blog post on Medium and then also added it to your own blog on your own domain. If you add the canonical link definition, then you won't be penalized for duplicate content. Medium also allows you to re-publish content from your own site to Medium and helps you get the rel=\"canonical\" inside the medium post to show that the original is hosted on your own site.%s Use Squirrly SEO's Bulk SEO to define canonical links and indexing options for your pages. %s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>','</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Platforms like Shopify handle this with their default engine. On WordPress you can use Squirrly SEO to control canonical links and make sure you avoid having duplicate content.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add canonical meta link in the page header", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'Jsonld' => array(
                    'complete' => false,
                    'title' => esc_html__("Meta Json-LD?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!' . '<div class="sq_list_error_title">' . esc_html__("The pages without Json-LD meta", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the meta Json_LD of the website? %s You need to make sure you have this tag inside your page's code: <script type=\"application/ld+json\"> . Or something similar. %s JSON-LD annotates elements on a page, structuring the data, which can then be used by search engines to disambiguate elements and establish facts surrounding entities, which is then associated with creating a more organized, better web overall.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>',  '</li></ul>'),
                    'protip' => esc_html__("On WordPress you can use Squirrly SEO to add the Json-LD Structured data. Squirrly will automatically structure the information from all your products if you use Woocommerce plugin for eCommerce.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Make sure you activated Json-LD in Squirrly > SEO Settings > Json-LD Meta", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'Encoding' => array(
                    'complete' => false,
                    'title' => esc_html__("Page Encoding", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!' . '<div class="sq_list_error_title">' . esc_html__("The pages without encoding meta", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the character encoding specifications of the website? %s You'll have to specify this according to the encoding you use for your website. %s Adding your encoding tag to the <head> of the site will fix it. Below, you'll find what you can place, in case your encoding is UTF-8 (the majority of web pages use this) %s <meta http-equiv=“Content-Type” content=“text/html;charset=utf-8” />%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Platforms like Shopify handle this with their default engine. On WordPress you can use Squirrly SEO  to get encoding specified for all your pages. Without specifying the encoding, search engines such as Google will be more likely to suggest other pages and rank other pages that DO have the specification made.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add the meta encoding tag in the page's header", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'Sitemap' => array(
                    'complete' => false,
                    'title' => esc_html__("Does your site have a feed or sitemap?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!',
                    'description' => sprintf(esc_html__("How can we fix the Feed and Sitemap of the website? %s Make sure that you feed and Sitemap exists and that it is accessible. Your visitors should be able to access it using /feed, or /sitemap.xml %s Make sure your visitors can access it using domainname.com/feed (where the text \"domainname\" is actually your domain. eg. bloggingwithjane.com ) %s On WordPress, you can use Squirrly SEO to generate your FEED and the Sitemap for your whole site. It has some pretty advanced options, so that you feeds will be perfect. This feature is free to use.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Your feeds and sitemaps should contain the date when your content was published and last updated. This is super important for Google to know, as it's always looking to surface fresh content to people who search on search engines. PLUS, having this gives you the opportunity to show up when users of Google say they want to see only results from the last week. If you had anything published during the last week, these people will see it and you will gain traffic.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add a RSS feed and Sitemap to your site", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'Robots' => array(
                    'complete' => false,
                    'title' => esc_html__("Does your site have a robots.txt file?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!',
                    'description' => sprintf(esc_html__("How can we fix the robots.txt of the website? %s You'll need to have a http://domain.com/robots.txt link on your site that crawlers can access to know which pages they are allowed to crawl. (gather info from) %s Create or Edit a robots.txt file using Squirrly SEO %s Once you have the file, upload it to your ftp (if you don’t want to let Squirrly operate it for you) and make sure it can be accessed. %s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Platforms like Shopify handle this with their default engine. On WordPress you can use Squirrly SEO  to create and customize your robots.txt", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add robots.txt file in your site", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'Viewport' => array(
                    'complete' => false,
                    'title' => esc_html__("Meta Viewport", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!' . '<div class="sq_list_error_title">' . esc_html__("The pages without viewport meta", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the meta viewport of the website? %s You need to make sure you have this tag inside your page's code: <meta name=“viewport” content=“width=device-width, initial-scale=1”> . Or something similar. %s In case you know that the minimum resolution required to deliver a good user experience to your viewers is 500 px, then write the following: %s <meta name=“viewport” content=“width=500, initial-scale=1”>%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Platforms like Shopify handle this with their default engine. On WordPress, you need to make sure the WordPress theme you buy is responsive and has this definition.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add the meta viewport tag in the page's header", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'Gzip' => array(
                    'complete' => false,
                    'title' => esc_html__("Site optimized for speed?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!' . '<div class="sq_list_error_title">' . esc_html__("The pages without gzip", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the gzip compression for our website? %s GZIP compression must be installed on the web server, such as in Apache, IIS and nginx. When retrieving the website the web browser will prompt the visitor he/she can receive the GZIP. %s Squirrly’s teams of experts can help you get this done. [link]https://www.squirrly.co/agency/[/link] - Premium Paid Services, separate from any software license you may have from the Squirrly Company. %s Ask your webmaster / developer / host to help you with this. Or try to find plugins to help you with this.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>',  '</li></ul>'),
                    'protip' => esc_html__("Setting this up saves 50% to 80% bandwidth, which will make all your pages load a lot faster.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Use gzip to increase your site's speed", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'DuplicateOGMetas' => array(
                    'complete' => false,
                    'title' => esc_html__("Duplicate Open Graph Tags?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("No duplicates", _SQ_PLUGIN_NAME_),
                    'fail' => esc_html__("We found some ...", _SQ_PLUGIN_NAME_) . '<div class="sq_list_error_title">' . esc_html__("The pages with duplicate Open Graph metas", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the duplicate meta codes of our pages? %s Make a list of the pages which have this problem. %s Start fixing them one by one. %s Remove duplicate definitions of code from the <head> section of each page. (eg. you have two instances of og:title << remove one of them!)%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("On WordPress you can use Squirrly SEO to Remove Duplicate Meta codes from all your pages. It removes them automatically. No work on your behalf.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Make sure you don't have duplicate meta tags in your site's header", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'DuplicateTCMetas' => array(
                    'complete' => false,
                    'title' => esc_html__("Duplicate Twitter Card Tags?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("No duplicates", _SQ_PLUGIN_NAME_),
                    'fail' => esc_html__("We found some ...", _SQ_PLUGIN_NAME_) . '<div class="sq_list_error_title">' . esc_html__("The pages with duplicate Twitter Card metas", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the duplicate meta codes of our pages? %s Make a list of the pages which have this problem. %s Start fixing them one by one. %s Remove duplicate definitions of code from the <head> section of each page. (eg. you have two instances of og:title << remove one of them!)%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("On WordPress you can use Squirrly SEO to Remove Duplicate Meta codes from all your pages. It removes them automatically. No work on your behalf.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Make sure you don't have duplicate meta tags in your site's header", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'DuplicateTitleMetas' => array(
                    'complete' => false,
                    'title' => esc_html__("Duplicate Title Tags?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("No duplicates", _SQ_PLUGIN_NAME_),
                    'fail' => esc_html__("We found some ...", _SQ_PLUGIN_NAME_) . '<div class="sq_list_error_title">' . esc_html__("The pages with duplicate Title metas", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the duplicate meta codes of our pages? %s Make a list of the pages which have this problem. %s Start fixing them one by one. %s Remove duplicate definitions of code from the <head> section of each page. (eg. you have two instances of og:title << remove one of them!)%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("On WordPress you can use Squirrly SEO to Remove Duplicate Meta codes from all your pages. It removes them automatically. No work on your behalf.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Make sure you don't have duplicate meta tags in your site's header", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'DuplicateDescriptionMetas' => array(
                    'complete' => false,
                    'title' => esc_html__("Duplicate Description Tags?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("No duplicates", _SQ_PLUGIN_NAME_),
                    'fail' => esc_html__("We found some ...", _SQ_PLUGIN_NAME_) . '<div class="sq_list_error_title">' . esc_html__("The pages with duplicate Description metas", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the duplicate meta codes of our pages? %s Make a list of the pages which have this problem. %s Start fixing them one by one. %s Remove duplicate definitions of code from the <head> section of each page. (eg. you have two instances of og:title << remove one of them!)%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("On WordPress you can use Squirrly SEO to Remove Duplicate Meta codes from all your pages. It removes them automatically. No work on your behalf.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Make sure you don't have duplicate meta tags in your site's header", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),

            ),
            'social' => array(
                'TopTenSocials' => array(
                    'complete' => false,
                    'title' => esc_html__("Top Shared Pages", _SQ_PLUGIN_NAME_),
                    'success' => '<div class="sq_list_success">%s</div>',
                    'fail' => '<div class="sq_list_success">%s</div>',
                ),
                'Shares' => array(
                    'complete' => false,
                    'title' => esc_html__("Shares", _SQ_PLUGIN_NAME_),
                    'success' => '<div class="sq_list_success">%s</div>',
                    'fail' => '<div class="sq_list_success">%s</div>',
                    'description' => sprintf(htmlentities(esc_html__("How can we raise the Social Media Shares (or signals) for our pages on Social Media? %s Use a tool like SalesFlare or FullContact (both paid) to extract the social media profiles of your customers, users, email subscribers and even LinkedIN Connections. Then make sure they follow you on Social Media. An easy way to do this is to follow them yourself. They already care about you and your company. They will gladly interact with your profiles. Using tools like these will also give you a clear picture of what Social Media platforms your desired audience uses most, so that you can create profiles only for those social media platforms. %s You should create social media Giveaways, or even viral communities like: [link]https://www.squirrly.co/dmsuperstars/[/link] %s Use a service like [link]https://techfork.xyz/about/[/link] (warning: other social media providers will most likely cause problems, because they use bots. - TechFork has been verified by our community and it has been a partner for over 4 years) %s Learn from our Episode on the Marketing Education Cloud Podcast how to share your pages so that you get better social signals and also 10,000 visits from social media: [link]https://www.squirrly.co/podcast/[/link] %s", _SQ_PLUGIN_NAME_)), '<ul><li>', '</li><li>','</li><li>','</li><li>', '</li></ul>'),
                    'protip' => esc_html__("All the shares and likes that your fans will give your pages will contribute to the total number of shares from social media (social signals). When Google’s algorithm starts “seeing” that people share your pages on social media, it will consider that your site is becoming popular and will increase its rankings.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("You have to share your articles with your fans", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'ShareButtons' => array(
                    'complete' => false,
                    'title' => esc_html__("Share Buttons in your articles?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!' . '<div class="sq_list_error_title">' . esc_html__("The pages without share buttons", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we get social media share buttons on our website? %s There are many options to help you get social sharing buttons inside your website. However, you should be careful not to let them ruin your loading times. Most plugins and apps will do that. %s Sumo.com is an Okay option. I'm not really happy with them, because I find it slows my pages. %s My current favorites are [link]http://info.zotabox.com/[/link] . I'm using them on Shopify and WordPress. It works with any CMS platform. The loading speed is great and their social media counters work perfectly.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("All there is to it is: make the buttons obvious, so people can easily find them. Make sure they don't slow your site down. Make sure they look great on mobile.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add Social Share buttons in your articles", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'FollowButtons' => array(
                    'complete' => false,
                    'title' => esc_html__("Social 'Follow me' Buttons?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!' . '<div class="sq_list_error_title">' . esc_html__("The pages without social buttons", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Social Follow Me buttons of the website? %s Add buttons to your website, that allow your visitors to check your social media profiles and follow you on social media. %s This is one of the most important aspects nowadays, if you want to build trust with your website. %s Learn more with Expectation Marketing. Expectation Marketing is all about teaching you how to implement such buttons and other trust elements for your digital brand. [link]http://expectationmarketing.com/[/link] %s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Place the buttons in your site's footer, to make sure they're always accessible. Web users are used to finding them there when they wish to connect to brands on social media.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add links to your Social Media profiles to strengthen social signals and keep readers engaged.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'OpenGraph' => array(
                    'complete' => false,
                    'title' => esc_html__("Open Graph protocol?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!' . '<div class="sq_list_error_title">' . esc_html__("The pages without Open Graph metas", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Open Graph of the website? %s You need to make sure you're going to fix the Open Graph image AS WELL AS all the other open graph elements. %s If you're on WordPress, you're easily getting all the settings you need from  Squirrly SEO . Make sure you use it. %s Below, you can see the examples of open graph elements you need to implement in the <head> section of your page's code. Make sure you replace the elements inside content=\" \" with your own data: your own titles, own image URLs, etc. %s <meta property=“og:url” content=“{site}/product/expectation-marketing-ebook/“ /> %s <meta property=“og:title” content=“Expectation Marketing [Book]” /> %s <meta property=“og:description” content=“If you`re wondering why your marketing strategy isn`t bringing the results you expected this is the right ebook for you. Expectation Marketing is about giving you an acti” /> %s <meta property=“og:type” content=“product” /> %s <meta property=“og:image” content=“{site}/image.jpg” /> %s <meta property=“og:image:width” content=“700” /> %s <meta property=“og:image:height” content=“536” /> %s <meta property=“og:image:type” content=“image/jpeg” /> %s <meta property=“og:site_name” content=“Expectation Marketing” /> %s <meta property=“og:locale” content=“en” />%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>',  '</li></ul><pre style="white-space: initial !important;">', '<br />', '<br />', '<br />', '<br />', '<br />', '<br />', '<br />', '<br />', '<br />', '</pre>'),
                    'protip' => esc_html__("Fixing this will improve Click Through Rates on Facebook, LinkedIN. Guaranteed. Make sure you use this to control how your pages look on social media when people share them.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add the meta Open Graph tag in your page's header.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'TwitterCard' => array(
                    'complete' => false,
                    'title' => esc_html__("Twitter Card?", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!' . '<div class="sq_list_error_title">' . esc_html__("The pages without Twitter Card metas", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Twitter Cards of the website? %s You need to make sure you're going to fix the Twitter Card image AS WELL AS all the other twitter card elements. %s If you're on WordPress, you're easily getting all the settings you need from Squirrly SEO. Make sure you use it. %s Below, you can see examples of twitter card elements you need to implement in the <head> section of your page's code. Make sure you replace the elements inside content=\" \" with your own data: your own titles, own image URLs, etc. %s <meta property=“twitter:url” content=“{site}/product/expectation-marketing-ebook/“ /> %s <meta property=“twitter:title” content=“Expectation Marketing [Book]” /> %s <meta property=“twitter:description” content=“If you`re wondering why your marketing strategy isn`t bringing the results you expected this is the right ebook for you. Expectation Marketing is about giving you an acti” /> %s <meta property=“twitter:image” content=“{site}/image.jpg” /> %s <meta property=“twitter:domain” content=“Expectation Marketing” /> %s <meta property=“twitter:card” content=“summary” />%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul><pre style="white-space: initial!important;">', '<br />', '<br />', '<br />', '<br />', '<br />', '</pre>'),
                    'protip' => esc_html__("Fixing this will improve Click Through Rates on Twitter. Guaranteed. Make sure you use this to control how your pages look on social media when people share them.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add Twitter Card to make your articles look better on Twitter.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),

            ),
            'inbound' => array(
                'MajesticInboundLinks' => array(
                    'complete' => false,
                    'title' => esc_html__("Majestic Backlinks", _SQ_PLUGIN_NAME_),
                    'success' => '{total} ' . esc_html__("link(s)", _SQ_PLUGIN_NAME_) . '<div class="sq_list_success_title">' . esc_html__("Backlinks Count", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_success">%s</div>',
                    'fail' => '{total} ' . esc_html__("link(s)", _SQ_PLUGIN_NAME_) . '<div class="sq_list_error_title">' . esc_html__("Backlinks Count", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Inbound Links Number to the latest 10 Pages? %s Many are tempted to go to [link]fiverr.com[/link] for something like this. Avoid shady SEO. What you can try, and ONLY if it makes sense, is to get bloggers who sell on fiverr to place your article (with links to your own site) on their site. %s You can easily get backlinks from multiple domains by showing that your business: - is an alternative to some other existing business (there are many websites on which people look for alternatives and they'll be happy to include your site as well, because it supports their purpose) - has discounts and coupons (there are many websites for coupon and discounts. Just search on Google and you'll find many. They'll happily include your coupon codes and links to your site) - hosts giveaways and contests (many websites that will happily link to the contest page on your website) %s Broken Link Building, using tools like Screaming Frog to help you find broken links.%s Use Squirrly SPY to check the sites which send links to your competitors or to other websites in your niche (or audience, or market): [link]https://www.squirrly.co/seo/spy/[/link] %s Many Squirrly users decided to purchase SPY reports and found out that they easily identified people from their industry who were easy to reach. This helped them secure new links from trust-worthy sites. %s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li><li>','</li><li>','</li></ul>'),
                    'protip' => esc_html__("Use the BackLinks Assistant [link]https://www.producthunt.com/upcoming/backlinks-assistant-by-squirrly[/link]. There are many other ways to increase the number of backlinks. Find more ideas in this resource: https://www.squirrly.co/how-to-improve-the-site-audit-score-given-by-squirrly-seo-plugin/. Send it to your team. Brainstorm items from our list which your team can start working on.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'MajesticUniqueDomains' => array(
                    'complete' => false,
                    'title' => esc_html__("Majestic Unique Domains", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Links from {total} domains", _SQ_PLUGIN_NAME_) . '<div class="sq_list_success_title">' . esc_html__("Unique Domains Count", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_success">%s</div>',
                    'fail' => esc_html__("Links from {total} domains", _SQ_PLUGIN_NAME_) . '<div class="sq_list_error_title">' . esc_html__("Unique Domains Count", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Inbound Links Number to the latest 10 Pages? %s Many are tempted to go to [link]fiverr.com[/link] for something like this. Avoid shady SEO. What you can try, and ONLY if it makes sense, is to get bloggers who sell on fiverr to place your article (with links to your own site) on their site. %s You can easily get backlinks from multiple domains by showing that your business: - is an alternative to some other existing business (there are many websites on which people look for alternatives and they'll be happy to include your site as well, because it supports their purpose) - has discounts and coupons (there are many websites for coupon and discounts. Just search on Google and you'll find many. They'll happily include your coupon codes and links to your site) - hosts giveaways and contests (many websites that will happily link to the contest page on your website) %s Broken Link Building, using tools like Screaming Frog to help you find broken links.%s Use Squirrly SPY to check the sites which send links to your competitors or to other websites in your niche (or audience, or market): [link]https://www.squirrly.co/seo/spy/[/link] %s Many Squirrly users decided to purchase SPY reports and found out that they easily identified people from their industry who were easy to reach. This helped them secure new links from trust-worthy sites. %s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li><li>','</li><li>','</li></ul>'),
                    'protip' => esc_html__("Use the BackLinks Assistant [link]https://www.producthunt.com/upcoming/backlinks-assistant-by-squirrly[/link]. There are many other ways to increase the number of backlinks. Find more ideas in this resource: https://www.squirrly.co/how-to-improve-the-site-audit-score-given-by-squirrly-seo-plugin/. Send it to your team. Brainstorm items from our list which your team can start working on.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'MozLinks' => array(
                    'complete' => false,
                    'title' => esc_html__("Moz Backlinks", _SQ_PLUGIN_NAME_),
                    'success' => '{total} ' . esc_html__("link(s)", _SQ_PLUGIN_NAME_) . '<div class="sq_list_success_title">' . esc_html__("Moz Backlinks Count", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_success">%s</div>',
                    'fail' => '{total} ' . esc_html__("link(s)", _SQ_PLUGIN_NAME_) . '<div class="sq_list_error_title">' . esc_html__("Moz Backlinks Count", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_error">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Inbound Links Number to the latest 10 Pages? %s Many are tempted to go to fiverr.com for something like this. Avoid shady SEO. What you can try, and ONLY if it makes sense, is to get bloggers who sell on fiverr to place your article (with links to your own site) on their site. %s You can easily get backlinks from multiple domains by showing that your business: - is an alternative to some other existing business (there are many websites on which people look for alternatives and they'll be happy to include your site as well, because it supports their purpose) - has discounts and coupons (there are many websites for coupon and discounts. Just search on Google and you'll find many. They'll happily include your coupon codes and links to your site) - hosts giveaways and contests (many websites that will happily link to the contest page on your website) %s Broken Link Building, using tools like Screaming Frog to help you find broken links.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Use the BackLinks Assistant [link]https://www.producthunt.com/upcoming/backlinks-assistant-by-squirrly[/link] . There are many other ways to increase the number of backlinks. Just check out the full documentation below. Send it to your team. Brainstorm items from our list which your team can start working on.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Find more blogs, forums, directories to add links there. Contribute to the respective community and they will appreciate it.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'NoFollowLinks' => array(
                    'complete' => false,
                    'title' => esc_html__("Links with noFollow?", _SQ_PLUGIN_NAME_),
                    'success' => '<div class="sq_list_success_title">' . esc_html__("Nofollow Links Count", _SQ_PLUGIN_NAME_) . ':</div><div class="sq_list_success">%s</div>',
                    'fail' => esc_html__("No"),
                    'description' => sprintf(esc_html__("How can we fix the No-Follow links of the website? %s You can find an extremely easy way to do this in the SEO Kit of Squirrly: [link]https://www.squirrly.co/seo/kit/[/link] %s You can start doing this even if you don't have an advanced or complex SEO strategy for all your site's inner links. If you have pages in your SEO strategy that are super important (you NEED those pages to be found via search) make sure you add:  <meta name=\"robots\" content=\"index, nofollow\" /> This ensures that Google considers this a final page. If many other pages link on to this page and this is the final one, it means that it is the most valuable resource. %s Identify links on your pages that are not important for you or for the purpose of the site itself. Maybe you're sending a link to chef Jamie Oliver's recipe for hot sauce. You should make sure that you add the No Follow tag to that link going out of your site, because you don't want Google to pass on link juice to Jaime Oliver. You'd give him a part of your SEO Authority and you don't want that. You should also add No-Follow tags to internal links from your very own site. Add no-follow to pages like \"/login\", \"/register\" \"/terms-of-use\", which are not important to be found via search engines. %s  Add rel=\"nofollow\" to links inside your pages to fix this task. If you'd want to NoFollow your Sign In page you could do it like this: <a href=\"signin.php\" rel=\"nofollow\">sign in</a>%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>','</li><li>', '</li></ul>'),
                    'protip' => esc_html__("You could add no-follow to most of the links from your site that go towards external, third-party websites. The only external sites you should leave without No-Follow are sites that you'd like to be associated with by Google. This is to say that in some cases you may want to send do-follow links to other people's sites if they are super high authority and would help Google better understand what your site's content is all about.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add nofollow links to pages like Terms and Conditions.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),

            ),
            'authority' => array(

                'Authority' => array(
                    'complete' => false,
                    'title' => esc_html__("Page Authority", _SQ_PLUGIN_NAME_),
                    'success' => '{total} ' . esc_html__("average authority", _SQ_PLUGIN_NAME_) . '<div class="sq_list_success">%s</div>',
                    'fail' => '{total} ' . esc_html__("average authority", _SQ_PLUGIN_NAME_) . '<div class="sq_list_success">%s</div>',
                    'description' => sprintf(esc_html__("How can we fix the Authority of the website? %s You must start by understanding this: Authority is Squirrly's calculated metric for how well a given webpage is likely to rank in Google's search results. It collects data from social media, google analytics and inbound links (backlinks to your own site) %s You can follow the PRO Tips sections from Audit. %s Get more Buzz on Social Media. Get More Traffic. Get More Sites to link back to your own site. That's how you increase your Authority.%s Read the Traffic section of the Audit for more fixes and ideas. Bringing more Traffic increases Authority. %s Read the Social Media ideas for getting your pages shared on social networks. In the SEO Audit from Squirrly. Get more shares and traffic from social media. That will help boost your overall Web Authority %s Use Focus Pages from Squirrly: everything we tell you there helps boost your authority: [link]https://plugin.squirrly.co/focus-pages/[/link] %s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("You can build up a solid Content Strategy using the SEO Goals and our brand new Private SEO Consultant. In a Plugin. Powered by Machine Learning and Cloud Services: [link]https://plugin.squirrly.co/best-seo-goals/[/link] or you can start getting more BackLinks using the BackLinks Assistant [link]https://www.producthunt.com/upcoming/backlinks-assistant-by-squirrly[/link].", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Get links to your page from domains with authority.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'AlexaRank' => array(
                    'complete' => false,
                    'title' => esc_html__("Alexa Rank", _SQ_PLUGIN_NAME_),
                    'success' => '%s ',
                    'fail' => '%s ',
                    'description' => sprintf(esc_html__("How can we fix the Alexa Rank of the website? %s Get more traffic to your website. (the visitors should have the Alexa toolbar installed for Alexa to be able to measure the traffic). %s You could encourage your visitors to install the Alexa toolbar (if it makes sense for your business or audience, of course). %s Increase your SEO rankings, get more shares on social media. You can use tools like Social Squirrly to make sure you constantly promote your pages, without doing any manual work. And without forgetting to keep posting them. [link]https://www.squirrly.co/social-media/tools-for-digital-marketing/[/link]%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("A certain and tested way of increasing Alexa rank is creating and promoting many pieces of fresh content. An agency like Squirrly's Content Agency can help you with this. [link]http://www.squirrly.co/agency[/link]", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Try to gain organic traffic to your site.", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'DomainAge' => array(
                    'complete' => false,
                    'title' => esc_html__("Domain Age", _SQ_PLUGIN_NAME_),
                    'success' => '%s ',
                    'fail' => '%s ',
                    'description' => sprintf(esc_html__("How can we fix the Domain Age of the website? %s While you certainly can't go back and forth in time like the Flash, there are things you can do, like: make sure your domain can be crawled by search engines. %s Ping your domain name as soon as possible using Google Search Console. Ask GSC asap to index your pages. Both by manual URL index and by placing the sitemaps generated by Squirrly. %s Get your website on Way Back Machine. [link]https://archive.org/web/[/link] Archive.org even has a tool called Save Page Now which will guarantee your entry into Way Back Machine.%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("If Squirrly could crawl your website and find your pages + show you the Audit, it means your domain and pages can be crawled. Just make sure you're not stopping the Google crawlers in your code via \"no-index\" or via robots.txt", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Your domain is new. I know it will get older, but still, it's good to know what to expect if it's new :)", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'Favicon' => array(
                    'complete' => false,
                    'title' => esc_html__("Site Icon", _SQ_PLUGIN_NAME_),
                    'success' => '%s ',
                    'fail' => esc_html__("No") . '!',
                    'description' => sprintf(esc_html__("How can we fix the favicon of the website? %s If you don't already have a favicon, you'll need to create one. The dimensions are 16 x 16 pixels %s You can easily create one using this [link]http://www.favicon.cc/[/link] . Upload it to your own server after creating it. %s Once you have the favicon, use this in the code of your pages: <link rel=“shortcut icon” href=“/images/specialicon.ico” type=“image/x-icon” />%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Platforms like Shopify handle this with their default engine. On WordPress you can use Squirrly SEO to upload and control the favicon displayed on your pages.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add an icon for your site", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
                'AppleIcon' => array(
                    'complete' => false,
                    'title' => esc_html__("IPad and IPhone Icons", _SQ_PLUGIN_NAME_),
                    'success' => esc_html__("Yes") . '!',
                    'fail' => esc_html__("No") . '!',
                    'description' => sprintf(esc_html__("How can we fix the Apple Icon of the website? %s If you don't already have an Apple Icon, you'll need to create one. The dimensions are 129 x 129 pixels. It will need to be a .png file %s You can easily create one using this [link]https://www.canva.com/[/link] . Upload it to your own server after creating it. %s Once you have the Apple Icon, use this in the code (in the <head> section) of your pages: %s <link rel=“apple-touch-icon” href=“/apple-touch-icon.png” />%s", _SQ_PLUGIN_NAME_), '<ul><li>', '</li><li>', '</li><li>', '</li><li>', '</li></ul>'),
                    'protip' => esc_html__("Platforms like Shopify handle this with their default engine. On WordPress you can use Squirrly SEO to upload and control the Apple Icon displayed on user's home screens when they bookmark your pages.", _SQ_PLUGIN_NAME_),
                    'solution' => esc_html__("Add an icon for your site", _SQ_PLUGIN_NAME_),
                    'link' => SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo'),
                ),
            )
        );
    }

    public function prepareAudit($audit) {
        $groups = $todo = array();

        $tasks = $this->getTasks();

        if (!empty($audit->audit)) {
            foreach ($audit->audit as $group => $rows) {
                $audittasks = array();

                //initialize group
                $groups[$group]['complete'] = 0;
                $groups[$group]['total'] = 0;

                foreach ($rows as $row) {

                    if (!isset($tasks[$group][$row->audit_task])) {
                        continue;
                    }

                    $audittask = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_AuditTask', array_merge($tasks[$group][$row->audit_task], (array)$row));

                    if ($audittask->audit_task == 'AlexaRank' && $audittask->value == 0) {
                        continue;
                    }

                    $replace = '';
                    switch ($audittask->audit_task) {
                        case 'TopTen':
                            if ((is_object($audittask->value) || is_array($audittask->value)) && !empty($audittask->value)) {
                                $replace .= '
                                      <table class="table_vals table table-striped my-3">
                                        <tr>
                                          <th>' . esc_html__("URL", _SQ_PLUGIN_NAME_) . '</th>
                                          <th>' . esc_html__("Visitors", _SQ_PLUGIN_NAME_) . '</th>
                                          <th>' . esc_html__("Bounce", _SQ_PLUGIN_NAME_) . '</th>
                                        </tr>';

                                foreach ($audittask->value as $value) {
                                    $value = (array)$value;
                                    $replace .= '<tr>';
                                    if ($value['permalink'] <> '') {
                                        $replace .= '';
                                        $replace .= '<td><a href="' . $value['permalink'] . '" target="_blank">' . $value['permalink'] . '</a></td>';
                                        $replace .= '<td>' . number_format((float)$value['visitors'], 0, '.', ',') . '</td>';
                                        $replace .= '<td>' . $value['bounces'] . '%</td>';
                                    }
                                    $replace .= '</tr>';
                                }
                                $replace .= '</table>';
                            } else {
                                $replace = '<div class="my-2 small">' . esc_html__("No traffic data found", _SQ_PLUGIN_NAME_) . '</div>';
                            }
                            break;

                        case 'TopTenSocials':
                        case 'MajesticInboundLinks':
                        case 'MajesticUniqueDomains':
                        case 'MozLinks':
                        case 'NoFollowLinks':
                        case 'TopTenAuthority':
                        case 'Authority':
                            if ((is_object($audittask->value) || is_array($audittask->value)) && !empty($audittask->value)) {
                                $replace .= '
                                      <table class="table_vals table table-striped my-3">
                                        <tr>
                                          <th>' . esc_html__("URL", _SQ_PLUGIN_NAME_) . '</th>
                                          <th>' . esc_html__("Total", _SQ_PLUGIN_NAME_) . '</th>
                                        </tr>';

                                foreach ($audittask->value as $post_id => $value) {
                                    $replace .= '<tr>';
                                    $replace .= '<td><a href="' . $audit->urls->$post_id . '" target="_blank">' . $audit->urls->$post_id . '</a></td>';
                                    $replace .= '<td>' . number_format((float)$value, 0, '.', ',') . '</td>';
                                    $replace .= '</tr>';
                                }
                                $replace .= '</table>';

                            }
                            break;
                        case 'Speed':
                            if ((is_object($audittask->urls) || is_array($audittask->urls)) && !empty($audittask->urls)) {
                                $replace .= '
                                      <table class="table_vals table table-striped my-3">
                                        <tr>
                                          <th>' . esc_html__("URL", _SQ_PLUGIN_NAME_) . '</th>
                                          <th>' . esc_html__("Total", _SQ_PLUGIN_NAME_) . '</th>
                                        </tr>';

                                foreach ($audittask->urls as $post_id) {
                                    if (!isset($audittask->value->$post_id)) {
                                        continue;
                                    }

                                    $replace .= '<tr>';
                                    $replace .= '<td><a href="' . $audit->urls->$post_id . '" target="_blank">' . $audit->urls->$post_id . '</a></td>';
                                    $replace .= '<td>' . number_format((float)$audittask->value->$post_id, 1, '.', ',') . ' s</td>';
                                    $replace .= '</tr>';

                                }
                                $replace .= '</table>';

                            }
                            break;
                        case 'Shares':
                            if ((is_object($audittask->value) || is_array($audittask->value)) && !empty($audittask->value)) {
                                foreach ($audittask->value as $post_id => $value) {
                                    if (!$audit->urls->$post_id) {
                                        continue;
                                    }

                                    $replace .= '<div class="my-2"><a href="' . $audit->urls->$post_id . '" target="_blank">' . $audit->urls->$post_id . '</a></div>';

                                    $replace .= '<table class="table_vals table table-striped my-3">';

                                    $tableOfContents = array(
                                        'facebookShareCount' => array(
                                            'icon' => 'sq_rank_flag_facebook',
                                            'title' => esc_html__("Facebook reactions", _SQ_PLUGIN_NAME_)
                                        ),
                                        'facebookLikeCount' => array(
                                            'icon' => 'sq_rank_flag_facebook',
                                            'title' => esc_html__("Facebook shares", _SQ_PLUGIN_NAME_)
                                        ),
                                        'reditShareCount' => array(
                                            'icon' => 'sq_rank_flag_reddit',
                                            'title' => esc_html__("Reddit shares", _SQ_PLUGIN_NAME_)
                                        ),
                                        'pinterestShareCount' => array(
                                            'icon' => 'sq_rank_flag_pinterest',
                                            'title' => esc_html__("Pinterest shares", _SQ_PLUGIN_NAME_)
                                        ),
                                    );
                                    foreach ($value as $name => $shares) {
                                        $replace .= '<tr>';
                                        $replace .= '<td><i class="sq_rank_sprite ' . $tableOfContents[$name]['icon'] . '"></i>' . $tableOfContents[$name]['title'] . '</td>';
                                        $replace .= '<td>' . number_format((float)$shares, 0, '.', ',') . '</td>';
                                        $replace .= '</tr>';
                                    }
                                    $replace .= '</table>';


                                }
                            }
                            break;

                        case 'DcPublisher':
                        case 'SafeBrowsing':
                        case 'DuplicateTitles':
                        case 'DuplicateDescription':
                        case 'EmptyTitles':
                        case 'EmptyDescription':
                        case 'Title':
                        case 'Description':
                        case 'Canonical':
                        case 'Encoding':
                        case 'Viewport':
                        case 'Gzip':
                        case 'DuplicateOGMetas':
                        case 'DuplicateTCMetas':
                        case 'DuplicateTitleMetas':
                        case 'DuplicateDescriptionMetas':
                        case 'Jsonld':
                        case 'FollowButtons':
                        case 'ShareButtons':
                        case 'OpenGraph':
                        case 'TwitterCard':
                            if (!empty($audittask->urls)) {
                                $replace .= '<ul>';
                                foreach ($audittask->urls as $post_id) {
                                    if (!$audit->urls->$post_id) {
                                        continue;
                                    }

                                    $replace .= '<li class="my-1 mx-4" style="list-style: initial"><a href="' . $audit->urls->$post_id . '" target="_blank">' . $audit->urls->$post_id . '</a></li>';

                                }
                                $replace .= '</ul>';


                            }
                            break;

                        case 'NoIndex':
                        case 'NoFollow':
                        case 'ExternalLinks':
                        case 'PageViews':
                            if (!empty($audittask->urls)) {

                                $replace .= '
                                      <table class="table_vals table table-striped my-3">
                                        <tr>
                                          <th>' . esc_html__("URL", _SQ_PLUGIN_NAME_) . '</th>
                                          <th>' . esc_html__("Value", _SQ_PLUGIN_NAME_) . '</th>
                                        </tr>';

                                foreach ($audittask->urls as $post_id) {
                                    if (!isset($audittask->value->$post_id)) {
                                        continue;
                                    }

                                    $value = $audittask->value->$post_id;

                                    $replace .= '<tr>';
                                    $replace .= '<td><a href="' . $audit->urls->$post_id . '" target="_blank">' . $audit->urls->$post_id . '</a></td>';
                                    $replace .= '<td>' . $value . '</td>';
                                    $replace .= '</tr>';
                                }
                                $replace .= '</table>';
                            }
                            break;

                        case 'Keywords':
                            if ((is_object($audittask->value) || is_array($audittask->value)) && !empty($audittask->value)) {
                                $replace .= '<ul>';
                                foreach ($audittask->value as $value) {
                                    $replace .= '<li class="my-1 mx-4" style="list-style: initial">' . $value . '</li>';
                                }
                                $replace .= '</ul>';
                            }
                            break;
                        default:
                            if (!is_array($audittask->value) && !is_object($audittask->value)) {
                                if (is_numeric($audittask->value)) {
                                    $replace = '<strong>' . number_format((float)$audittask->value, 0, '.', ',') . '</strong>';
                                } else {
                                    $replace = '<strong>' . $audittask->value . '</strong>';
                                }
                            }
                    }

                    //update the value message
                    $audittask->value = urldecode($replace);

                    if (in_array($audittask->audit_task, array('Speed', 'Authority'))) {
                        $audittask->total = number_format((float)$audittask->total, 1, '.', ',');
                    } else {
                        $audittask->total = (int)$audittask->total;

                    }

                    //correct the success message
                    $audittask->success = str_replace(array('{site}', '{total}'), array(home_url(), $audittask->total), $audittask->success);
                    $audittask->success = sprintf($audittask->success, $audittask->value);

                    //correct the fail message
                    $audittask->fail = str_replace(array('{site}', '{total}'), array(home_url(), $audittask->total), $audittask->fail);
                    $audittask->fail = sprintf($audittask->fail, $audittask->value);

                    $audittask->description = str_replace(array('{site}', '{total}'), array(home_url(), $audittask->total), $audittask->description);
                    $audittask->description = preg_replace('/\[link\]([^\[]*)\[\/link\]/i', '<a href="$1" target="_blank">$1</a>', $audittask->description);
                    $audittask->protip = preg_replace('/\[link\]([^\[]*)\[\/link\]/i', '<a href="$1" target="_blank">$1</a>', $audittask->protip);

                    if (!$audittask->complete && $audittask->solution <> '') {
                        $this->_todo[$audittask->audit_task] = array(
                            'title' => $audittask->title,
                            'description' => $audittask->description,
                            'todo' => $audittask->solution,
                        );
                        if ($audittask->protip <> '') {
                            $this->_todo[$audittask->audit_task]['description'] .= '<div class="my-3 p-0"><strong class="text-info">' . esc_html__("PRO TIP", _SQ_PLUGIN_NAME_) . ':</strong> ' . $audittask->protip . '</div>';
                        }

                    } elseif ($audittask->complete) {
                        $groups[$group]['complete']++;
                    }

                    $groups[$group]['total']++;
                    $audittasks[] = $audittask;
                }

                //update the audit group with the valid tasks
                $audit->audit->$group = $audittasks;


                if ($groups[$group]['total'] > 0) {
                    $color = 'sq_audit_task_completed_green';
                    $colorname = '';
                    if ($groups[$group]['complete'] < ($groups[$group]['total'] / 2)) {
                        $color = 'sq_audit_task_completed_red';
                        $colorname = esc_html__("Requires Attention!", _SQ_PLUGIN_NAME_);
                    }
                    if ($groups[$group]['complete'] >= ($groups[$group]['total'] / 2)) {
                        $color = 'sq_audit_task_completed_yellow';
                        $colorname = esc_html__("Can be improved.", _SQ_PLUGIN_NAME_);
                    }
                    if ($groups[$group]['complete'] == $groups[$group]['total']) {
                        $color = 'sq_audit_task_completed_green';
                        $colorname = esc_html__("Great!", _SQ_PLUGIN_NAME_);
                    }

                    $groups[$group]['color'] = $color;
                    $groups[$group]['colorname'] = $colorname;
                } else {
                    unset($groups[$group]);
                }
            }

            if (!empty($this->_todo)) {
                krsort($this->_todo);
                add_filter('sq_assistant_tasks', array($this, 'setAssistantTasks'));
            }

            $audit->groups = json_decode(wp_json_encode($groups));
            $audit->next_audit_datetime = date_i18n('d M Y', strtotime($audit->audit_datetime) + (3600 * 24 * 8));
        }

        //echo '<pre>' . print_R($audit, true) . '</pre>';

        return $audit;
    }

    /**
     * Se the assistant tasks for the Squirrly Assistant
     * @param $tasks
     * @return mixed
     */
    public function setAssistantTasks($tasks) {

        foreach ($this->_todo as $audit_task => $todo) {
            $this->_todo[$audit_task] = array(
                'title' => $todo['title'],
                'description' => $todo['description'],
                'function' => false,
            );
        }

        //echo '<pre>' . print_R($this->_todo, true) . '</pre>';

        return $this->_todo;

    }

    /**
     * Parse all categories for a single page
     * @param SQ_Models_Domain_AuditPage $auditpage
     * @return $this
     */
    public function parseAuditPage(SQ_Models_Domain_AuditPage $auditpage) {
        //set focus pages from API
        $this->_auditpage = $auditpage;

        //Set the focus page audit as success
        if (isset($this->_auditpage->audit_datetime)) {
            $this->_auditpage->audit_datetime = date(get_option('date_format') . ' ' . get_option('time_format'), strtotime($this->_auditpage->audit_datetime));
        } else {
            $this->_auditpage->audit_datetime = esc_html__("not yet", _SQ_PLUGIN_NAME_);
        }

        if($post = $this->_auditpage->getWppost()) {
            if ($post->post_status <> '' && $post->post_status <> 'publish') { //just if the  Page is public
                $this->_auditpage->audit_error = 404;
            }
        }


        return $this;
    }

    /**
     * Return the audit page
     * @return SQ_Models_Domain_AuditPage
     */
    public function getAuditPage() {
        return $this->_auditpage;
    }


}