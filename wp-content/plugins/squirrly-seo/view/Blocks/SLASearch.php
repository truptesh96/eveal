<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_preloading">
    <?php echo esc_html__("Waiting for your editor to load ..", _SQ_PLUGIN_NAME_); ?>
</div>

<div class="sq_box" style="display: none">
    <div class="sq_header"><span class="sq_logo"></span>
        <?php echo esc_html__("Squirrly SEO", _SQ_PLUGIN_NAME_); ?>
        <div class="sq_box_close" title="<?php echo esc_html__("Click to Close Squirrly Live Assistant", _SQ_PLUGIN_NAME_); ?>" style="display: none">x</div>
        <div class="sq_box_minimize" title="<?php echo esc_html__("Click to Minimize Box", _SQ_PLUGIN_NAME_); ?>" style="display: none">_</div>
        <div class="sq_box_maximize" title="<?php echo esc_html__("Click to Maximize Box", _SQ_PLUGIN_NAME_); ?>" style="display: none">&#x25a1;</div>
        <div id="sq_briefcase_icon" title="<?php echo esc_html__("Squirrly Briefcase", _SQ_PLUGIN_NAME_); ?>"></div>

    </div>
    <div id="sq_blocksearch">
        <div id="sq_briefcase_list" style="display:none;">
            <div class="sq_header" style="background-color: #8684a4;  color: white;">
                <div class="sq_briefcase_icon_white" style="float: left; width: 20px; height: 20px; margin-right: 5px; background-size: 100%;"></div><?php echo esc_html__("Squirrly Briefcase", _SQ_PLUGIN_NAME_); ?>
                <div id="sq_briefcase_refresh" title="<?php echo esc_html__("Refresh the briefcase", _SQ_PLUGIN_NAME_); ?>" ></div>
                <div id="sq_briefcase_close" title="<?php echo esc_html__("Close Briefcase", _SQ_PLUGIN_NAME_); ?>" >x</div>
            </div>
            <input type="text" id="sq_briefcase_keyword" value="" autocomplete="off" placeholder="<?php echo esc_html__("Search in Briefcase ...", _SQ_PLUGIN_NAME_); ?>">
            <div id="sq_briefcase_content"></div>
            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') ?>" class="sq_button" id="sq_briefcase_addbriefcase" target="_blank" style="background-color: rgb(38, 128, 180);"><?php echo esc_html__("Go to Briefcase", _SQ_PLUGIN_NAME_); ?></a>
            <div id="sq_briefcase_bottom"></div>
        </div>
        <div class="sq_keyword">
            <?php
            if (SQ_Classes_Helpers_Tools::getOption('sq_keyword_help')) {
                ?>
                <div id="sq_keyword_help" style="display:none">
                    <span></span><?php echo esc_html__("Enter a keyword", _SQ_PLUGIN_NAME_); ?>
                    <p><?php echo esc_html__("for Squirrly Live SEO optimization", _SQ_PLUGIN_NAME_); ?></p>
                </div>
                <?php
            }
            ?>
            <input type="text" id="sq_keyword" name="sq_keyword" value="<?php echo SQ_Classes_Helpers_Tools::getValue('keyword','') ?>" autocomplete="off" placeholder="<?php echo esc_html__("Type in your keyword...", _SQ_PLUGIN_NAME_) ?>"/>
            <input type="button" id="sq_keyword_check" value=">"/>
            <input type="button" id="sq_selectit" value="<?php echo esc_html__("Use this keyword", _SQ_PLUGIN_NAME_); ?>" style="display: none"/>
        </div>
        <div class="sq_research_div">
            <a id="sq_research_link" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') ?>" target="_blank"><?php echo esc_html__("Do keyword research!", _SQ_PLUGIN_NAME_); ?></a>
        </div>
        <div id="sq_types" style="display:none">
            <ul>
                <li id="sq_type_img" title="<?php echo esc_html__("Images", _SQ_PLUGIN_NAME_) ?>"></li>
                <li id="sq_type_twitter" title="<?php echo esc_html__("Twitter", _SQ_PLUGIN_NAME_) ?>"></li>
                <li id="sq_type_wiki" title="<?php echo esc_html__("Wiki", _SQ_PLUGIN_NAME_) ?>"></li>
                <li id="sq_type_blog" title="<?php echo esc_html__("Blogs", _SQ_PLUGIN_NAME_) ?>"></li>
                <li id="sq_type_local" title="<?php echo esc_html__("My articles", _SQ_PLUGIN_NAME_) ?>"></li>
            </ul>
        </div>
        <div style="position: relative;">
            <div id="sq_search_close" style="display:none">x</div>
        </div>
        <div class="sq_search"></div>
        <div id="sq_search_img_filter" style="display:none">
            <label id="sq_search_img_nolicence_label" <?php if (SQ_Classes_Helpers_Tools::getOption('sq_img_licence')) echo 'class="checked"'; ?> for="sq_search_img_nolicence"><span></span><?php echo esc_html__("Show only Copyright Free images", _SQ_PLUGIN_NAME_) ?>
            </label><input id="sq_search_img_nolicence" type="checkbox" value="1" style="display:none" <?php if (SQ_Classes_Helpers_Tools::getOption('sq_img_licence')) echo 'checked="checked"'; ?> />
        </div>
    </div>
</div>
<noscript><style>#sq_preloading,#sq_options{display: none}</style></noscript>