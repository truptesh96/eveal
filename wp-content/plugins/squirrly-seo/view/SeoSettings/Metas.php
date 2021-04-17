<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_settings')) {
            echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_) . '</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_seosettings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">

                <?php do_action('sq_form_notices'); ?>
                <form method="POST">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_metas', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_metas"/>

                    <div class="card col-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-7 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_metas_icon m-2"></div>
                                </div>
                                <h3 class="card-title"><?php echo esc_html__("SEO Metas", _SQ_PLUGIN_NAME_); ?>
                                    <div class="sq_help_question d-inline">
                                        <a href="https://howto.squirrly.co/kb/seo-metas/" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                    </div>
                                </h3>
                                <div class="col-12 text-left m-0 p-0">
                                    <div class="card-title-description m-2"><?php echo esc_html__("Add all Search Engine METAs like Title, Description, Canonical Link, Dublin Core, Robots and more.", _SQ_PLUGIN_NAME_); ?></div>
                                </div>
                            </div>
                            <div class="col-5 text-right">
                                <div class="checker row my-4 py-2 mx-0 px-0 justify-content-end">
                                    <div class="sq-switch redgreen sq-switch-sm ">
                                        <label for="sq_auto_metas" class="mr-2"><?php echo esc_html__("Activate SEO Metas", _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_metas" value="0"/>
                                        <input type="checkbox" id="sq_auto_metas" name="sq_auto_metas" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_metas"></label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="sq_seosettings" class="card col-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') ? '' : 'sq_deactivated') ?>">

                            <div class="card-body">
                                <div class="col-12 row my-4">
                                    <div class="col-6 p-3 text-right">
                                        <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') ?>" class="btn btn-lg btn-primary">
                                            <?php echo esc_html__("Optimize with SEO Patterns", _SQ_PLUGIN_NAME_); ?>
                                        </a>
                                    </div>
                                    <div class="col-6 p-3 text-left">
                                        <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo') ?>" class="btn btn-lg btn-primary">
                                            <?php echo esc_html__("Optimize all SEO Snippets", _SQ_PLUGIN_NAME_); ?>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-12 mt-5 mx-2">
                                    <h5 class="text-left my-3 text-info"><?php echo esc_html__("Tips: How to optimize all the pages from my website?", _SQ_PLUGIN_NAME_); ?></h5>
                                    <ul class="mx-3">
                                        <li style="font-size: 15px; list-style: initial;"><?php echo sprintf(esc_html__("Use the %s SEO Automation %s to setup SEO Patterns based on Post Types for global optimization.", _SQ_PLUGIN_NAME_),'<a href="'.SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation').'">','</a>'); ?></li>
                                        <li style="font-size: 15px; list-style: initial;"><?php echo sprintf(esc_html__("Use %s Bulk SEO %s to optimize the SEO Snippet for each page on your website.", _SQ_PLUGIN_NAME_),'<a href="'.SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo').'">','</a>'); ?></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="col-12 m-0 p-0">
                                    <div class="card col-12 p-0 border-0  ">
                                        <div class="bg-title border-top p-2 ">
                                            <h3 class="card-title"><?php echo esc_html__("Manage On-Page SEO Metas", _SQ_PLUGIN_NAME_); ?></h3>
                                        </div>
                                        <div class="col-12 py-4 tab-panel">
                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_title" value="0"/>
                                                        <input type="checkbox" id="sq_auto_title" name="sq_auto_title" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_title') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_title" class="ml-2"><?php echo esc_html__("Optimize the Titles", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/seo-metas/#Optimize-The-Titles" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add the Title Tag in the page header. You can customize it using the Bulk SEO and Squirrly SEO Snippet.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_description" value="0"/>
                                                        <input type="checkbox" id="sq_auto_description" name="sq_auto_description" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_description') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_description" class="ml-2"><?php echo esc_html__("Optimize Descriptions", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/seo-metas/#Optimize-The-Description" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add the Description meta in the page header. You can customize it using the Bulk SEO and Squirrly SEO Snippet.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_keywords" value="0"/>
                                                        <input type="checkbox" id="sq_auto_keywords" name="sq_auto_keywords" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_keywords" class="ml-2"><?php echo esc_html__("Optimize Keywords", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/seo-metas/#Optimize-Keywords" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add the Keyword meta in the page header. You can customize it using the Bulk SEO and Squirrly SEO Snippet.", _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("This meta is not mandatory for Google but other search engines still use it for ranking", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_canonical" value="0"/>
                                                        <input type="checkbox" id="sq_auto_canonical" name="sq_auto_canonical" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_canonical') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_canonical" class="ml-2"><?php echo esc_html__("Add Canonical Meta Link", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/seo-metas/#Add-Canonical-Meta-Link" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add canonical link meta in the page header. You can customize the canonical link on each page.", _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Also add prev & next links metas in the page header when navigate between blog pages.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_dublincore" value="0"/>
                                                        <input type="checkbox" id="sq_auto_dublincore" name="sq_auto_dublincore" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_dublincore') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_dublincore" class="ml-2"><?php echo esc_html__("Add Dublin Core Meta", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/seo-metas/#Add-Dublin-Core-Meta" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add the Dublin Core meta in the page header.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_auto_noindex" value="0"/>
                                                        <input type="checkbox" id="sq_auto_noindex" name="sq_auto_noindex" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_auto_noindex" class="ml-2"><?php echo esc_html__("Add Robots Meta", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/seo-metas/#Add-Robots-Meta" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add the Index/Noindex and Follow/Nofollow options in Squirrly SEO Snippet.", _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add googlebot and bingbot METAs for better performance.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bg-title border-top p-2 sq_advanced">
                                            <h3 class="card-title"><?php echo esc_html__("More SEO Settings", _SQ_PLUGIN_NAME_); ?></h3>
                                        </div>
                                        <div class="col-12 py-4 tab-panel sq_advanced">
                                            <div class="col-12 row mb-1 ml-1 sq_advanced">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_keywordtag" value="0"/>
                                                        <input type="checkbox" id="sq_keywordtag" name="sq_keywordtag" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_keywordtag') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_keywordtag" class="ml-2"><?php echo esc_html__("Add the Post tags in Keyword META", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/seo-metas/#Add-The-Post-Tags-in-Keyword-Meta" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add all the tags from your posts as keywords. Not recommended when you use Keywords in Squirrly SEO Snippet.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_use_frontend" value="0"/>
                                                        <input type="checkbox" id="sq_use_frontend" name="sq_use_frontend" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_use_frontend') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_use_frontend" class="ml-2"><?php echo esc_html__("Activate SEO Snippet in Frontend", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/seo-metas/#Add-Snippet-in-Frontend" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Load Squirrly SEO Snippet in Frontend to customize the SEO directly from page preview.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <?php $metas = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('sq_metas'))); ?>
                                        <div class="sq_advanced">
                                            <div class="bg-title p-2">
                                                <h3 class="card-title">
                                                    <?php echo esc_html__("Title & Description Lengths", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/seo-metas/#lengths" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                </h3>
                                            </div>
                                            <div class="col-12 py-4 border-bottom tab-panel ">
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-1 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Title Length", _SQ_PLUGIN_NAME_); ?>:
                                                        <a href="https://howto.squirrly.co/kb/seo-metas/#title_description_length" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                    </div>
                                                    <div class="col-1 p-0 input-group input-group-sm">
                                                        <input type="text" class="form-control bg-input" name="sq_metas[title_maxlength]" value="<?php echo (int)$metas->title_maxlength ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-1 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Description Length", _SQ_PLUGIN_NAME_); ?>:
                                                        <a href="https://howto.squirrly.co/kb/seo-metas/#title_description_length" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a></label>
                                                    </div>
                                                    <div class="col-1 p-0 input-group input-group-sm">
                                                        <input type="text" class="form-control bg-input" name="sq_metas[description_maxlength]" value="<?php echo (int)$metas->description_maxlength ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="col-12 p-0 py-3 bg-light">
                            <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) { ?>
                                <div class="py-0 float-right text-right m-2">
                                    <button type="button" class="show_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0"><?php echo esc_html__("Show Advanced Options", _SQ_PLUGIN_NAME_); ?></button>
                                    <button type="button" class="hide_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0" style="display: none"><?php echo esc_html__("Hide Advanced Options", _SQ_PLUGIN_NAME_); ?></button>
                                </div>
                            <?php } ?>
                            <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php echo esc_html__("Save Settings", _SQ_PLUGIN_NAME_); ?></button>
                        </div>

                    </div>

                </form>
            </div>
            <div class="sq_col_side sticky">
                <div class="card col-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
