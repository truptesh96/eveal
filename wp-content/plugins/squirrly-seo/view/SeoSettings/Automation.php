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
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs('automation', 'sq_seosettings'); ?>
        <div class="sq_seosettings_automation d-flex flex-row bg-white px-3">
            <div class="flex-grow-1 px-1 sq_flex">

                <?php do_action('sq_form_notices'); ?>
                <form method="POST">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_automation', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_automation"/>

                    <div class="card col-12 p-0">
                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-8 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_automation_icon m-2"></div>
                                </div>
                                <h3 class="card-title"><?php echo esc_html__("SEO Automation - Patterns", _SQ_PLUGIN_NAME_); ?>
                                    <div class="sq_help_question d-inline">
                                        <a href="https://howto.squirrly.co/kb/seo-automation/" target="_blank"><i class="fa fa-question-circle" style="margin: 0;"></i></a>
                                    </div>
                                </h3>
                                <div class="col-12 text-left m-0 p-0">
                                    <div class="card-title-description m-1"><?php echo esc_html__("Control how post types are displayed on your site, within search engine results, and social media feeds.", _SQ_PLUGIN_NAME_); ?></div>
                                </div>
                            </div>
                            <div class="col-4 text-right">
                                <div class="checker col-12 row my-2 py-1 mx-0 px-0 ">
                                    <div class="col-12 p-0 sq-switch redgreen sq-switch-sm ">
                                        <label for="sq_auto_pattern" class="ml-2"><?php echo esc_html__("Activate Patterns", _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_pattern" value="0"/>
                                        <input type="checkbox" id="sq_auto_pattern" name="sq_auto_pattern" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_pattern" class="mx-2"></label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card col-12 p-0 m-0 border-0 tab-panel border-0">

                            <div class="card-body p-0">
                                <div class="col-12 m-0 p-0">
                                    <div class="card col-12 p-0 my-0 border-0 ">

                                        <?php
                                        $filter = array('public' => true, '_builtin' => false);
                                        $types = get_post_types($filter);

                                        $new_types = array();
                                        foreach ($types as $pattern => $type) {
                                            if (in_array($pattern, array('elementor_library'))) continue;

                                            if (in_array($pattern, array_keys(SQ_Classes_Helpers_Tools::getOption('patterns')))) {
                                                continue;
                                            }
                                            $new_types[$pattern] = $type;
                                        }
                                        $filter = array('public' => true,);
                                        $taxonomies = get_taxonomies($filter);
                                        foreach ($taxonomies as $pattern => $type) {
                                            if (in_array($pattern, array('post_tag', 'post_format', 'product_cat', 'product_tag', 'product_shipping_class'))) continue;

                                            if (in_array('tax-' . $pattern, array_keys(SQ_Classes_Helpers_Tools::getOption('patterns')))) {
                                                continue;
                                            }
                                            $new_types['tax-' . $pattern] = $type;
                                        }
                                        if (!empty($new_types)) { ?>
                                            <div class="bg-title border-top p-2">
                                                <h3 class="card-title"><?php echo esc_html__("Add Post Type for SEO Automation", _SQ_PLUGIN_NAME_); ?></h3>
                                            </div>
                                            <div class="col-12 m-0 py-4 tab-panel">

                                                <div class="checker col-12 row m-0 p-0 sq_save_ajax">
                                                    <div class="col-12 row py-2 mx-0 my-3">
                                                        <div class="col-4 p-1">
                                                            <div class="font-weight-bold"><?php echo esc_html__("Add Post Type", _SQ_PLUGIN_NAME_); ?>:<a href="https://howto.squirrly.co/kb/seo-automation/#add_post_type" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                            </div>
                                                            <div class="small text-black-50"><?php echo esc_html__("Add new post types in the list and customize the automation for it.", _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                        <div class="col-8 p-0 input-group">
                                                            <select id="sq_select_post_types" class="form-control bg-input mb-1">
                                                                <?php
                                                                foreach ($new_types as $pattern => $type) {
                                                                    ?>
                                                                    <option value="<?php echo esc_attr($pattern) ?>"><?php echo ucwords(str_replace(array('-', '_'), ' ', esc_attr($pattern))); ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <button type="button" data-input="sq_select_post_types" data-action="sq_ajax_automation_addpostype" data-name="post_type" class="btn btn-lg rounded-0 btn-success mx-2" style="max-height: 50px;"><?php echo esc_html__("Add Post Type", _SQ_PLUGIN_NAME_); ?></button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="bg-title border-top p-2">
                                            <h3 class="card-title"><?php echo esc_html__("Customize each Post Type", _SQ_PLUGIN_NAME_); ?></h3>
                                        </div>

                                        <div class="col-12 pt-0 py-4 tab-panel">
                                            <div class="d-flex flex-row mt-2">
                                                <ul class="nav nav-tabs nav-tabs--vertical nav-tabs--left" id="nav-tab" role="tablist">
                                                    <?php foreach (SQ_Classes_Helpers_Tools::getOption('patterns') as $pattern => $type) {
                                                        if (strpos($pattern, 'product') !== false || strpos($pattern, 'shop') !== false) {
                                                            if (!SQ_Classes_Helpers_Tools::isEcommerce()) {
                                                                continue;
                                                            }
                                                        }

                                                        $itemname = ucwords(str_replace(array('-', '_'), ' ', esc_attr($pattern)));
                                                        if($pattern == 'tax-product_cat'){
                                                            $itemname = "Product Category";
                                                        }elseif($pattern == 'tax-product_tag'){
                                                            $itemname = "Product Tag";
                                                        }
                                                        ?>
                                                        <input type="hidden" name="patterns[<?php echo esc_attr($pattern) ?>][protected]" value="<?php echo((isset($type['protected']) && $type['protected']) ? 1 : 0) ?>"/>

                                                        <li class="nav-item">
                                                            <a class="nav-item nav-link text-info <?php if ($pattern == 'home') { ?>active<?php } ?>" id="nav-<?php echo esc_attr($pattern) ?>-tab" data-toggle="tab" href="#nav-<?php echo esc_attr($pattern) ?>" role="tab" aria-controls="nav-<?php echo esc_attr($pattern) ?>" <?php if ($pattern == 'home') { ?>aria-selected="true" <?php }else{ ?>aria-selected="false"<?php } ?>><?php echo $itemname; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                                <div class="tab-content flex-grow-1 border-top border-right border-bottom">
                                                    <?php foreach (SQ_Classes_Helpers_Tools::getOption('patterns') as $pattern => $type) {
                                                        $itemname = ucwords(str_replace(array('-', '_'), ' ', esc_attr($pattern)));
                                                        if($pattern == 'tax-product_cat'){
                                                            $itemname = "Product Category";
                                                        }elseif($pattern == 'tax-product_tag'){
                                                            $itemname = "Product Tag";
                                                        }
                                                        ?>

                                                        <div class="tab-pane <?php if ($pattern == 'home') { ?>show active<?php } ?>" id="nav-<?php echo esc_attr($pattern) ?>" role="tabpanel" aria-labelledby="nav-<?php echo esc_attr($pattern) ?>-tab">
                                                            <h4 class="col-12 py-3 text-center text-black"><?php echo $itemname; ?></h4>

                                                            <div id="sq_seosettings" class="col-12 pt-0 pb-4 border-bottom tab-panel <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern') ? '' : 'sq_deactivated') ?>">

                                                                <div class="col-12 row py-2 mx-0 my-3">
                                                                    <div class="col-4 p-0 pr-3 font-weight-bold">
                                                                        <?php echo esc_html__("Title", _SQ_PLUGIN_NAME_); ?> :
                                                                        <a href="https://howto.squirrly.co/kb/seo-automation/#title_automation" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        <div class="small text-black-50 mt-1 mb-0"><?php echo esc_html__("Tips: Length 10-75 chars", _SQ_PLUGIN_NAME_); ?></div>
                                                                    </div>
                                                                    <div class="col-8 p-0 input-group sq_pattern_field">
                                                                        <textarea rows="1" class="form-control bg-input" name="patterns[<?php echo esc_attr($pattern) ?>][title]"><?php echo esc_html($type['title']) ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 row py-2 mx-0 my-3">
                                                                    <div class="col-4 p-0 pr-3 font-weight-bold">
                                                                        <?php echo esc_html__("Description", _SQ_PLUGIN_NAME_); ?>:
                                                                        <a href="https://howto.squirrly.co/kb/seo-automation/#description_automation" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        <div class="small text-black-50 mt-1 mb-0"><?php echo esc_html__("Tips: Length 70-320 chars", _SQ_PLUGIN_NAME_); ?></div>
                                                                    </div>
                                                                    <div class="col-8 p-0 sq_pattern_field">
                                                                        <textarea class="form-control" name="patterns[<?php echo esc_attr($pattern) ?>][description]" rows="5"><?php echo esc_html($type['description']) ?></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 row py-2 mx-0 my-3">
                                                                    <div class="col-4 p-1 font-weight-bold">
                                                                        <?php echo esc_html__("Separator", _SQ_PLUGIN_NAME_); ?>:
                                                                        <a href="https://howto.squirrly.co/kb/seo-automation/#separator" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                        <div class="small text-black-50 mt-1 mb-0"><?php echo esc_html__("Use separator to help user read the most relevant part of your title and increase Conversion Rate", _SQ_PLUGIN_NAME_); ?></div>
                                                                    </div>
                                                                    <div class="col-4 p-0 input-group">
                                                                        <select name="patterns[<?php echo esc_attr($pattern) ?>][sep]" class="form-control bg-input mb-1">
                                                                            <?php
                                                                            $seps = json_decode(SQ_ALL_SEP, true);

                                                                            foreach ($seps as $sep => $code) { ?>
                                                                                <option value="<?php echo esc_attr($sep) ?>" <?php echo ($type['sep'] == $sep) ? 'selected="selected"' : '' ?>><?php echo esc_html($code) ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 py-4 border-bottom tab-panel">

                                                                <div class="col-12 row mb-1 ml-1">

                                                                    <div class="checker col-12 row my-2 py-1">

                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_metas" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_metas" data-action="sq_ajax_seosettings_save" data-name="sq_auto_metas"><?php echo esc_html__("Activate Metas", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_noindex" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_noindex" data-action="sq_ajax_seosettings_save" data-name="sq_auto_noindex"><?php echo esc_html__("Activate Robots Meta", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') || !SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr($pattern) ?>][noindex]" value="1"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr($pattern) ?>_noindex" name="patterns[<?php echo esc_attr($pattern) ?>][noindex]" class="sq-switch" <?php echo(($type['noindex'] == 0) ? 'checked="checked"' : '') ?> value="0"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr($pattern) ?>_noindex" class="ml-2"><?php echo esc_html__("Let Google Index it", _SQ_PLUGIN_NAME_); ?>
                                                                                <a href="https://howto.squirrly.co/kb/seo-automation/#let_google_index" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </label>
                                                                            <div class="offset-1 small text-black-50"><?php echo esc_html__("If you switch off this option, Squirrly will add noindex meta for this post type.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="col-12 row mb-1 ml-1">
                                                                    <div class="checker col-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_metas" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_metas" data-action="sq_ajax_seosettings_save" data-name="sq_auto_metas"><?php echo esc_html__("Activate Metas", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_noindex" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_noindex" data-action="sq_ajax_seosettings_save" data-name="sq_auto_noindex"><?php echo esc_html__("Activate Robots Meta", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') || !SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr($pattern) ?>][nofollow]" value="1"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr($pattern) ?>_nofollow" name="patterns[<?php echo esc_attr($pattern) ?>][nofollow]" class="sq-switch" <?php echo(($type['nofollow'] == 0) ? 'checked="checked"' : '') ?> value="0"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr($pattern) ?>_nofollow" class="ml-2"><?php echo esc_html__("Send Authority to it", _SQ_PLUGIN_NAME_); ?>
                                                                                <a href="https://howto.squirrly.co/kb/seo-automation/#send_authority" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </label>
                                                                            <div class="offset-1 small text-black-50"><?php echo esc_html__("If you sq-switch off this option, Squirrly will add nofollow meta for this post type.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 row mb-1 ml-1">
                                                                    <div class="checker col-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas') || !SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_sitemap" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_sitemap" data-action="sq_ajax_seosettings_save" data-name="sq_auto_sitemap"><?php echo esc_html__("Activate Sitemap", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr($pattern) ?>][do_sitemap]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr($pattern) ?>_do_sitemap" name="patterns[<?php echo esc_attr($pattern) ?>][do_sitemap]" class="sq-switch" <?php echo(($type['do_sitemap'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr($pattern) ?>_do_sitemap" class="ml-2"><?php echo esc_html__("Include In Sitemap", _SQ_PLUGIN_NAME_); ?>
                                                                                <a href="https://howto.squirrly.co/kb/seo-automation/#send_to_sitemap" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </label>
                                                                            <div class="offset-1 small text-black-50"><?php echo esc_html__("Let Squirrly SEO include this post type in Squirrly Sitemap XML.", _SQ_PLUGIN_NAME_); ?></div>
                                                                            <div class="offset-1 small text-warning"><?php echo esc_html__("If you switch off this option, Squirrly will not load the Sitemap for this post type.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php
                                                                if (!isset($type['do_redirects'])) {
                                                                    $type['do_redirects'] = 0;
                                                                }
                                                                ?>
                                                                <div class="col-12 row mb-1 ml-1">
                                                                    <div class="checker col-12 row my-2 py-1">
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr($pattern) ?>][do_redirects]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr($pattern) ?>_do_redirects" name="patterns[<?php echo esc_attr($pattern) ?>][do_redirects]" class="sq-switch" <?php echo(($type['do_redirects'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr($pattern) ?>_do_redirects" class="ml-2"><?php echo esc_html__("Redirect Broken URLs", _SQ_PLUGIN_NAME_); ?>
                                                                                <a href="https://howto.squirrly.co/kb/seo-automation/#redirect_404_links" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </label>
                                                                            <div class="offset-1 small text-black-50"><?php echo esc_html__("Redirect the 404 URL in case it is changed with a new one in Post Editor.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php if ($pattern == 'attachment') { ?>
                                                                    <div class="col-12 row mb-1 ml-1">
                                                                        <div class="checker col-12 row my-2 py-1">
                                                                            <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                                                <input type="hidden" name="sq_attachment_redirect" value="0"/>
                                                                                <input type="checkbox" id="sq_attachment_redirect" name="sq_attachment_redirect" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_attachment_redirect') ? 'checked="checked"' : '') ?> value="1"/>
                                                                                <label for="sq_attachment_redirect" class="ml-2"><?php echo esc_html__("Redirect Attachments Page", _SQ_PLUGIN_NAME_); ?></label>
                                                                                <div class="offset-1 small text-black-50"><?php echo esc_html__("Redirect the attachment page to its image URL.", _SQ_PLUGIN_NAME_); ?></div>
                                                                                <div class="offset-1 small text-black-50"><?php echo esc_html__("Recommended if your website is not a photography website.", _SQ_PLUGIN_NAME_); ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>

                                                            <div class="col-12 py-4 border-bottom tab-panel sq_advanced">

                                                                <div class="col-12 row mb-1 ml-1">
                                                                    <div class="checker col-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_metas" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_metas" data-action="sq_ajax_seosettings_save" data-name="sq_auto_metas"><?php echo esc_html__("Activate Metas", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr($pattern) ?>][do_metas]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr($pattern) ?>_do_metas" name="patterns[<?php echo esc_attr($pattern) ?>][do_metas]" class="sq-switch" <?php echo(($type['do_metas'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr($pattern) ?>_do_metas" class="ml-2"><?php echo esc_html__("Load Squirrly SEO METAs", _SQ_PLUGIN_NAME_); ?>
                                                                                <a href="https://howto.squirrly.co/kb/seo-automation/#load_squirrly_metas" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </label>
                                                                            <div class="offset-1 small text-black-50"><?php echo esc_html__("Let Squirrly SEO load the Title, Description, Keyword METAs for this post type.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 row mb-1 ml-1">
                                                                    <div class="checker col-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_pattern" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_pattern" data-action="sq_ajax_seosettings_save" data-name="sq_auto_pattern"><?php echo esc_html__("Activate Patterns", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr($pattern) ?>][do_pattern]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr($pattern) ?>_do_pattern" name="patterns[<?php echo esc_attr($pattern) ?>][do_pattern]" class="sq-switch" <?php echo(($type['do_pattern'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr($pattern) ?>_do_pattern" class="ml-2"><?php echo esc_html__("Load Squirrly Patterns", _SQ_PLUGIN_NAME_); ?>
                                                                                <a href="https://howto.squirrly.co/kb/seo-automation/#load_squirrly_patterns" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </label>
                                                                            <div class="offset-1 small text-black-50"><?php echo esc_html__("Let Squirrly SEO load the Patterns for this post type.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 row mb-1 ml-1">
                                                                    <div class="checker col-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_jsonld" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_jsonld" data-action="sq_ajax_seosettings_save" data-name="sq_auto_jsonld"><?php echo esc_html__("Activate Json-Ld", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr($pattern) ?>][do_jsonld]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr($pattern) ?>_do_jsonld" name="patterns[<?php echo esc_attr($pattern) ?>][do_jsonld]" class="sq-switch" <?php echo(($type['do_jsonld'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr($pattern) ?>_do_jsonld" class="ml-2"><?php echo esc_html__("Load JSON-LD Structured Data", _SQ_PLUGIN_NAME_); ?>
                                                                                <a href="https://howto.squirrly.co/kb/seo-automation/#load_jsonld_schema" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </label>
                                                                            <div class="offset-1 small text-black-50"><?php echo esc_html__("Let Squirrly SEO load the JSON-LD Schema for this post type.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>

                                                                        <div class="col-12 row m-0 mt-5 p-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld')) ? 'sq_deactivated' : ''); ?>">
                                                                            <div class="col-7 p-1 pr-2">
                                                                                <div class="font-weight-bold"><?php echo esc_html__("JSON-LD Type", _SQ_PLUGIN_NAME_); ?>:
                                                                                    <a href="https://howto.squirrly.co/kb/seo-automation/#load_jsonld_schema" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                                </div>
                                                                                <div class="small text-black-50"><?php echo esc_html__("JSON-LD will load the Schema for the selected types.", _SQ_PLUGIN_NAME_); ?></div>
                                                                            </div>
                                                                            <?php
                                                                            $post_types = json_decode(SQ_ALL_JSONLD_TYPES, true);

                                                                            if (in_array($pattern, array('search', 'category', 'tag', 'archive', 'attachment', '404', 'tax-post_tag', 'tax-post_cat', 'tax-product_tag', 'tax-product_cat'))) $post_types = array('website');
                                                                            if (in_array($pattern, array('home', 'shop'))) $post_types = array('website', 'local store', 'local restaurant');
                                                                            if ($pattern == 'profile') $post_types = array('profile');
                                                                            if ($pattern == 'product') $post_types = array('product');
                                                                            ?>
                                                                            <div class="col-5 p-0 input-group">
                                                                                <select <?php echo((count($post_types) > 1) ? 'multiple' : '') ?> name="patterns[<?php echo esc_attr($pattern) ?>][jsonld_types][]" class="selectpicker form-control bg-input mb-1" style="min-height: 100px;">
                                                                                    <?php foreach ($post_types as $post_type => $jsonld_type) { ?>
                                                                                        <option <?php echo((isset($type['jsonld_types']) && !empty($type['jsonld_types']) && in_array($jsonld_type, $type['jsonld_types'])) ? 'selected="selected"' : '') ?> value="<?php echo esc_attr($jsonld_type) ?>">
                                                                                            <?php echo ucfirst(esc_attr($jsonld_type)) ?>
                                                                                        </option>
                                                                                    <?php } ?>

                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>


                                                            <div class="col-12 py-4 border-bottom tab-panel sq_advanced">


                                                                <div class="col-12 row mb-1 ml-1 ">
                                                                    <div class="checker col-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_social')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_social" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_social" data-action="sq_ajax_seosettings_save" data-name="sq_auto_social"><?php echo esc_html__("Activate Social Media", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_og" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_og" data-action="sq_ajax_seosettings_save" data-name="sq_auto_facebook"><?php echo esc_html__("Activate Open Graph", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_social') || !SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr($pattern) ?>][do_og]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr($pattern) ?>_do_og" name="patterns[<?php echo esc_attr($pattern) ?>][do_og]" class="sq-switch" <?php echo(($type['do_og'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr($pattern) ?>_do_og" class="ml-2"><?php echo esc_html__("Load Squirrly Open Graph", _SQ_PLUGIN_NAME_); ?>
                                                                                <a href="https://howto.squirrly.co/kb/seo-automation/#load_open_graph" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </label>
                                                                            <div class="offset-1 small text-black-50"><?php echo esc_html__("Let Squirrly SEO load the Open Graph for this post type.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>

                                                                        <div class="col-12 row m-0 mt-5 mb-3 p-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_social') || !SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) ? 'sq_deactivated' : ''); ?>">
                                                                            <div class="col-7 p-1 pr-2">
                                                                                <div class="font-weight-bold"><?php echo esc_html__("Open Graph Type", _SQ_PLUGIN_NAME_); ?>:
                                                                                    <a href="https://howto.squirrly.co/kb/seo-automation/#load_open_graph" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                                </div>
                                                                                <div class="small text-black-50"><?php echo esc_html__("Select which Open Graph type to load for this post type.", _SQ_PLUGIN_NAME_); ?></div>
                                                                            </div>
                                                                            <?php
                                                                            $post_types = json_decode(SQ_ALL_OG_TYPES, true);

                                                                            if (in_array($pattern, array('home', 'search', 'category', 'tag', 'archive', '404', 'attachment', 'tax-post_tag', 'tax-post_cat', 'tax-product_tag', 'tax-product_cat', 'shop'))) $post_types = array('website');
                                                                            if ($pattern == 'profile') $post_types = array('profile');
                                                                            if ($pattern == 'product') $post_types = array('product');
                                                                            ?>
                                                                            <div class="col-5 p-0 input-group">
                                                                                <select name="patterns[<?php echo esc_attr($pattern) ?>][og_type]" class="form-control bg-input mb-1">
                                                                                    <?php foreach ($post_types as $post_type => $og_type) { ?>
                                                                                        <option <?php echo(($type['og_type'] == $og_type) ? 'selected="selected"' : '') ?> value="<?php echo esc_attr($og_type) ?>">
                                                                                            <?php echo ucfirst(esc_attr($og_type)) ?>
                                                                                        </option>
                                                                                    <?php } ?>

                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-12 row mb-1 ml-1 ">
                                                                    <div class="checker col-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_social')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_social" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_social" data-action="sq_ajax_seosettings_save" data-name="sq_auto_social"><?php echo esc_html__("Activate Social Media", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_twc" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_twc" data-action="sq_ajax_seosettings_save" data-name="sq_auto_twitter"><?php echo esc_html__("Activate Twitter Card", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_social') || !SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr($pattern) ?>][do_twc]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr($pattern) ?>_do_twc" name="patterns[<?php echo esc_attr($pattern) ?>][do_twc]" class="sq-switch" <?php echo(($type['do_twc'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr($pattern) ?>_do_twc" class="ml-2"><?php echo esc_html__("Load Squirrly Twitter Card", _SQ_PLUGIN_NAME_); ?>
                                                                                <a href="https://howto.squirrly.co/kb/seo-automation/#load_twitter_card" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </label>
                                                                            <div class="offset-1 small text-black-50"><?php echo esc_html__("Let Squirrly SEO load the Twitter Card for this post type.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="col-12 py-4 border-bottom tab-panel sq_advanced">

                                                                <div class="col-12 row mb-1 ml-1 ">
                                                                    <div class="checker col-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_ganalytics" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_ganalytics" data-action="sq_ajax_seosettings_save" data-name="sq_auto_tracking"><?php echo esc_html__("Activate Trackers", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr($pattern) ?>][do_analytics]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr($pattern) ?>_do_analytics" name="patterns[<?php echo esc_attr($pattern) ?>][do_analytics]" class="sq-switch" <?php echo(($type['do_analytics'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr($pattern) ?>_do_analytics" class="ml-2"><?php echo esc_html__("Load Google Analytics Tracking Script", _SQ_PLUGIN_NAME_); ?>
                                                                                <a href="https://howto.squirrly.co/kb/seo-automation/#load_analytics_tracking" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </label>
                                                                            <div class="offset-1 small text-black-50"><?php echo esc_html__("Let Google Analytics Tracking to load for this post type.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 row mb-1 ml-1 ">
                                                                    <div class="checker col-12 row my-2 py-1">
                                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking')) { ?>
                                                                            <div class="sq_deactivated_label col-12 row m-0 p-2 pr-3 sq_save_ajax">
                                                                                <div class="col-12 p-0 text-right">
                                                                                    <input type="hidden" id="activate_sq_auto_fpixel" value="1"/>
                                                                                    <button type="button" class="btn btn-link text-danger btn-sm" data-input="activate_sq_auto_fpixel" data-action="sq_ajax_seosettings_save" data-name="sq_auto_tracking"><?php echo esc_html__("Activate Trackers", _SQ_PLUGIN_NAME_); ?></button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <div class="col-12 p-0 sq-switch sq-switch-sm <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_tracking')) ? 'sq_deactivated' : ''); ?>">
                                                                            <input type="hidden" name="patterns[<?php echo esc_attr($pattern) ?>][do_fpixel]" value="0"/>
                                                                            <input type="checkbox" id="sq_patterns_<?php echo esc_attr($pattern) ?>_do_fpixel" name="patterns[<?php echo esc_attr($pattern) ?>][do_fpixel]" class="sq-switch" <?php echo(($type['do_fpixel'] == 1) ? 'checked="checked"' : '') ?> value="1"/>
                                                                            <label for="sq_patterns_<?php echo esc_attr($pattern) ?>_do_fpixel" class="ml-2"><?php echo esc_html__("Load Facebook Pixel Tracking Script", _SQ_PLUGIN_NAME_); ?>
                                                                                <a href="https://howto.squirrly.co/kb/seo-automation/#load_facebook_pixel" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                            </label>
                                                                            <div class="offset-1 small text-black-50"><?php echo esc_html__("Let Facebook Pixel Tracking to load for this post type.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <?php if ($pattern <> 'custom' && (!isset($type['protected']) || !$type['protected'])) { ?>
                                                                <div class="checker col-12 row m-0 p-3 sq_save_ajax">
                                                                    <div class="col-12 p-0 text-right">
                                                                        <input type="hidden" id="sq_delete_post_types_<?php echo esc_attr($pattern) ?>" value="<?php echo esc_attr($pattern) ?>"/>
                                                                        <button type="button" data-confirm="<?php echo sprintf(esc_html__("Do you want to delete the automation for %s?", _SQ_PLUGIN_NAME_), ucwords(str_replace(array('-', '_'), array(' '), esc_attr($pattern)))); ?>" data-input="sq_delete_post_types_<?php echo esc_attr($pattern) ?>" data-action="sq_ajax_automation_deletepostype" data-name="post_type" class="btn btn-link btn-sm text-black-50 rounded-0"><?php echo sprintf(esc_html__("Remove automation for %s", _SQ_PLUGIN_NAME_), ucwords(str_replace(array('-', '_'), array(' '), esc_attr($pattern)))); ?></button>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>

                                                    <?php } ?>
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

                                            </div>


                                        </div>


                                        <div class="bg-title p-2">
                                            <h3 class="card-title">
                                                <?php echo esc_html__("Squirrly Patterns", _SQ_PLUGIN_NAME_); ?> <a href="https://howto.squirrly.co/kb/seo-automation/#add_patterns" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                            </h3>
                                            <div class="col-12 text-left m-0 p-0">
                                                <div class="card-title-description mb-0"><?php echo esc_html__("Use the Pattern system to prevent Title and Description duplicates between posts", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 py-4 border-bottom tab-panel ">

                                            <div class="col-12 text-left m-0 p-0">
                                                <div class="card-title-description m-3"><?php echo esc_html__("Patterns change the codes like {{title}} with the actual value of the post Title.", _SQ_PLUGIN_NAME_); ?></div>
                                                <div class="card-title-description m-3"><?php echo esc_html__("In Squirrly, each post type in your site comes with a predefined posting pattern when displayed onto your website. However, based on your site's purpose and needs, you can also decide what information these patterns will include.", _SQ_PLUGIN_NAME_); ?></div>
                                                <div class="card-title-description m-3"><?php echo esc_html__("Once you set up a pattern for a particular post type, only the content required by your custom sequence will be displayed.", _SQ_PLUGIN_NAME_); ?></div>
                                                <div class="card-title-description m-3"><?php echo sprintf(esc_html__("Squirrly lets you see how the customized patterns will apply when posts/pages are shared across social media or search engine feeds. You just need to go to the %sBulk SEO%s and see the meta information for each post type.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo') . '" ><strong>', '</strong></a>'); ?></div>
                                            </div>
                                        </div>

                                        <div class="sq_advanced">
                                            <?php $metas = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('sq_metas'))); ?>
                                            <div class="bg-title p-2">
                                                <h3 class="card-title"><?php echo esc_html__("META Lengths", _SQ_PLUGIN_NAME_); ?> <a href="https://howto.squirrly.co/kb/seo-automation/#automation_custom_lengths" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                </h3>
                                                <div class="col-12 text-left m-0 p-0">
                                                    <div class="card-title-description mb-0"><?php echo esc_html__("Change the lengths for each META on automation", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                            </div>
                                            <div class="col-12 py-4 border-bottom tab-panel ">
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-1 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Title Length", _SQ_PLUGIN_NAME_); ?>:
                                                    </div>
                                                    <div class="col-1 p-0 input-group input-group-sm">
                                                        <input type="text" class="form-control bg-input" name="sq_metas[title_maxlength]" value="<?php echo (int)$metas->title_maxlength ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-1 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Description Length", _SQ_PLUGIN_NAME_); ?>:
                                                    </div>
                                                    <div class="col-1 p-0 input-group input-group-sm">
                                                        <input type="text" class="form-control bg-input" name="sq_metas[description_maxlength]" value="<?php echo (int)$metas->description_maxlength ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-1 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Open Graph Title Length", _SQ_PLUGIN_NAME_); ?>:
                                                    </div>
                                                    <div class="col-1 p-0 input-group input-group-sm">
                                                        <input type="text" class="form-control bg-input" name="sq_metas[og_title_maxlength]" value="<?php echo (int)$metas->og_title_maxlength ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-1 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Open Graph Description Length", _SQ_PLUGIN_NAME_); ?>:
                                                    </div>
                                                    <div class="col-1 p-0 input-group input-group-sm">
                                                        <input type="text" class="form-control bg-input" name="sq_metas[og_description_maxlength]" value="<?php echo (int)$metas->og_description_maxlength ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-1 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Twitter Card Title Length", _SQ_PLUGIN_NAME_); ?>:
                                                    </div>
                                                    <div class="col-1 p-0 input-group input-group-sm">
                                                        <input type="text" class="form-control bg-input" name="sq_metas[tw_title_maxlength]" value="<?php echo (int)$metas->tw_title_maxlength ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-1 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Twitter Card Description Length", _SQ_PLUGIN_NAME_); ?>:
                                                    </div>
                                                    <div class="col-1 p-0 input-group input-group-sm">
                                                        <input type="text" class="form-control bg-input" name="sq_metas[tw_description_maxlength]" value="<?php echo (int)$metas->tw_description_maxlength ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-1 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("JSON-LD Title Length", _SQ_PLUGIN_NAME_); ?>:
                                                    </div>
                                                    <div class="col-1 p-0 input-group input-group-sm">
                                                        <input type="text" class="form-control bg-input" name="sq_metas[jsonld_title_maxlength]" value="<?php echo (int)$metas->jsonld_title_maxlength ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-1 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("JSON-LD Description Length", _SQ_PLUGIN_NAME_); ?>:
                                                    </div>
                                                    <div class="col-1 p-0 input-group input-group-sm">
                                                        <input type="text" class="form-control bg-input" name="sq_metas[jsonld_description_maxlength]" value="<?php echo (int)$metas->jsonld_description_maxlength ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-12 p-0 py-3 bg-light">
                            <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php echo esc_html__("Save Settings", _SQ_PLUGIN_NAME_); ?></button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="sq_col sq_col_side ">
                <div class="card col-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
