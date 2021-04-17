<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php
    if (SQ_Classes_Helpers_Tools::getOption('sq_use')) {
        if (isset($view->post) && $view->post && isset($view->post->hash) && $view->post->hash <> '') {
            $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');
            $socials = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('socials')));
            $codes = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('codes')));

            //Check if the patterns are loaded for this post
            $loadpatterns = true;
            if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_pattern') || !$view->post->sq->do_pattern) {
                $loadpatterns = false;
            }

            //Clear the Title and Description for admin use only
            $view->post->sq->title = $view->post->sq->getClearedTitle();
            $view->post->sq->description = $view->post->sq->getClearedDescription();

            if ($view->post->sq->og_media == '') {
                if ($og = SQ_Classes_ObjController::getClass('SQ_Models_Services_OpenGraph')) {
                    $images = $og->getPostImages();

                    if (!empty($images)) {
                        $image = current($images);
                        if (isset($image['src'])) {
                            if ($view->post->sq->og_media == '') $view->post->sq->og_media = $image['src'];
                        }
                    }elseif (SQ_Classes_Helpers_Tools::getOption('sq_og_image')) {
                        $view->post->sq->og_media = SQ_Classes_Helpers_Tools::getOption('sq_og_image');
                    }
                }
            }

            if ($view->post->sq->tw_media == '') {
                if ($tc = SQ_Classes_ObjController::getClass('SQ_Models_Services_TwitterCard')) {
                    $images = $tc->getPostImages();

                    if (!empty($images)) {
                        $image = current($images);
                        if (isset($image['src'])) {
                            if ($view->post->sq->tw_media == '') $view->post->sq->tw_media = $image['src'];
                        }
                    }elseif (SQ_Classes_Helpers_Tools::getOption('sq_tc_image')) {
                        $view->post->sq->tw_media = SQ_Classes_Helpers_Tools::getOption('sq_tc_image');
                    }
                }
            }

            if ($view->post->ID > 0 && function_exists('get_sample_permalink')) {
                list($permalink, $post_name) = get_sample_permalink($view->post->ID);
                if (strpos($permalink, '%postname%') !== false || strpos($permalink, '%pagename%') !== false) {
                    $view->post->url = str_replace(array('%pagename%', '%postname%'), esc_html($post_name), esc_html(urldecode($permalink)));
                }
            }

            //Set the preview title and description in case Squirrly SEO is switched off for Title and Description
            $preview_title = (SQ_Classes_Helpers_Tools::getOption('sq_auto_title') ? $view->post->sq->title : $view->post->post_title);
            $preview_description = (SQ_Classes_Helpers_Tools::getOption('sq_auto_description') ? $view->post->sq->description : $view->post->post_excerpt);
            $preview_keywords = (SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords') ? $view->post->sq->keywords : '');

            ?>


            <input type="hidden" name="sq_url" value="<?php echo esc_attr($view->post->url); ?>">
            <input type="hidden" name="sq_post_id" value="<?php echo (int)$view->post->ID; ?>">
            <input type="hidden" name="sq_post_type" value="<?php echo esc_attr($view->post->post_type); ?>">
            <input type="hidden" name="sq_term_id" value="<?php echo (int)$view->post->term_id; ?>">
            <input type="hidden" name="sq_taxonomy" value="<?php echo esc_attr($view->post->taxonomy); ?>">
            <input type="hidden" name="sq_hash" id="sq_hash" value="<?php echo esc_attr($view->post->hash); ?>">
            <input type="hidden" name="sq_keyword" id="sq_keyword" value="">

            <?php if (SQ_Classes_Helpers_Tools::isAjax()) {  //Run only is frontend admin and ajax call ?>
                <div id="snippet_<?php echo esc_attr($view->post->hash) ?>" class="sq_snippet_wrap sq-card sq-col-sm-12 sq-p-0 sq-pr-1 sq-m-0 sq-border-0">

                    <div class="sq-card-body sq-p-0">
                        <div class="sq-close sq-close-absolute">x</div>

                        <div class="sq-d-flex sq-flex-row sq-m-0">

                            <!-- ================= Tabs ==================== -->
                            <div class="sq_snippet_menu sq-d-flex sq-flex-column sq-bg-nav sq-mb-0 sq-border-right" role="sqtablist">
                                <ul class="sq-nav sq-nav-tabs sq-nav-tabs--vertical sq-nav-tabs--left">
                                    <li class="sq-nav-item">
                                        <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_metas" class="sq-nav-icon" target="_blank"><i class="fa fa-question-circle m-0 px-1"></i></a>
                                        <a href="#sqtab<?php echo esc_attr($view->post->hash) ?>1" class="sq-nav-item sq-nav-link sq-py-3 sq-text-info" id="sq-nav-item_metas" data-category="metas" data-toggle="sqtab"><?php echo esc_html__("Meta Tags", _SQ_PLUGIN_NAME_) ?></a>
                                    </li>
                                    <li class="sq-nav-item">
                                        <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_jsonld" class="sq-nav-icon" target="_blank"><i class="fa fa-question-circle m-0 px-1"></i></a>
                                        <a href="#sqtab<?php echo esc_attr($view->post->hash) ?>2" class="sq-nav-item sq-nav-link sq-py-3 sq-text-info" id="sq-nav-item_jsonld" data-category="jsonld" data-toggle="sqtab"><?php echo esc_html__("JSON-LD", _SQ_PLUGIN_NAME_) ?></a>
                                    </li>
                                    <li class="sq-nav-item">
                                        <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_og" class="sq-nav-icon" target="_blank"><i class="fa fa-question-circle m-0 px-1"></i></a>
                                        <a href="#sqtab<?php echo esc_attr($view->post->hash) ?>3" class="sq-nav-item sq-nav-link sq-py-3 sq-text-info" id="sq-nav-item_opengraph" data-category="opengraph" data-toggle="sqtab"><?php echo esc_html__("Open Graph", _SQ_PLUGIN_NAME_) ?></a>
                                    </li>
                                    <li class="sq-nav-item">
                                        <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_twittercard" class="sq-nav-icon" target="_blank"><i class="fa fa-question-circle m-0 px-1"></i></a>
                                        <a href="#sqtab<?php echo esc_attr($view->post->hash) ?>4" class="sq-nav-item sq-nav-link sq-py-3 sq-text-info" id="sq-nav-item_twittercard" data-category="twittercard" data-toggle="sqtab"><?php echo esc_html__("Twitter Card", _SQ_PLUGIN_NAME_) ?></a>
                                    </li>
                                    <li class="sq-nav-item">
                                        <a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_visibility" class="sq-nav-icon" target="_blank"><i class="fa fa-question-circle m-0 px-1"></i></a>
                                        <a href="#sqtab<?php echo esc_attr($view->post->hash) ?>6" class="sq-nav-item sq-nav-link sq-py-3 sq-text-info" id="sq-nav-item_visibility" data-category="visibility" data-toggle="sqtab"><?php echo esc_html__("Visibility", _SQ_PLUGIN_NAME_) ?></a>
                                    </li>
                                </ul>
                            </div>
                            <!-- =================== Optimize ==================== -->

                            <div class="sq-tab-content sq-d-flex sq-flex-column sq-flex-grow-1 sq-bg-white sq-px-3">
                                <div id="sqtab<?php echo esc_attr($view->post->hash) ?>1" class="sq-tab-pane" role="tabpanel">
                                    <div class="sq-card sq-border-0">
                                        <?php if (!$view->post->sq->do_metas) { ?>
                                            <div class="sq-row">
                                                <div class="sq-text-center sq-col-sm-12 sq-my-5 sq-mx-0 sq-px-0 sq-text-danger"><?php echo sprintf(esc_html__("Post Type (%s) was excluded from %sSquirrly > SEO Settings%s. Squirrly SEO will not load for this post type on the frontend", _SQ_PLUGIN_NAME_), '<strong>' . $view->post->post_type . '</strong>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="sq-card-body sq_tab_meta sq_tabcontent <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-d-none' : ''; ?>">
                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) { ?>
                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                            <input type="hidden" id="activate_sq_auto_metas" value="1"/>
                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-lg" data-input="activate_sq_auto_metas" data-action="sq_ajax_seosettings_save" data-name="sq_auto_metas"><?php echo esc_html__("Activate Metas", _SQ_PLUGIN_NAME_); ?></button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="<?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_metas')) ? 'sq_deactivated' : ''); ?>">

                                                    <div class="sq_tab_preview">
                                                        <div class="sq-row sq-border-bottom sq-mb-2 sq-pb-2">
                                                            <div class="sq-col-sm-7">
                                                                <div class="sq_message"><?php echo esc_html__("How this page will appear on Search Engines", _SQ_PLUGIN_NAME_) ?>:</div>
                                                            </div>
                                                            <div class="sq-col-sm-5 sq-text-right ">
                                                                <div class="sq-refresh"></div>
                                                                <input type="button" class="sq_snippet_btn_refresh sq-btn sq-btn-sm sq-btn-warning sq-px-3 sq-rounded-0" value="<?php echo esc_html__("Refresh", _SQ_PLUGIN_NAME_) ?>"/>
                                                                <input type="button" class="sq_snippet_btn_edit sq-btn sq-btn-sm sq-btn-primary sq-px-3 sq-rounded-0" value="<?php echo esc_html__("Edit Snippet", _SQ_PLUGIN_NAME_) ?>"/>
                                                            </div>
                                                        </div>
                                                        <?php if ($view->post->post_title <> esc_html__("Auto Draft") && $view->post->post_title <> esc_html__("AUTO-DRAFT")) { ?>
                                                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-mx-auto sq-border">
                                                                <ul class="sq-p-3 sq-m-0" style="min-height: 125px;">
                                                                    <li class="sq_snippet_title sq-text-info sq-font-weight-bold" title="<?php echo esc_attr($preview_title) ?>"><?php echo esc_html($preview_title) ?></li>
                                                                    <li class="sq_snippet_url sq-text-link" title="<?php echo urldecode($view->post->url) ?>"><?php echo urldecode($view->post->url) ?></li>
                                                                    <li class="sq_snippet_description sq-text-black-50" title="<?php echo esc_attr($preview_description) ?>"><?php echo esc_html($preview_description) ?></li>
                                                                    <li class="sq_snippet_keywords sq-text-black-50"><?php echo esc_html($preview_keywords) ?></li>
                                                                </ul>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-border">
                                                                <div style="padding: 20px"><?php echo esc_html__("Please save the post first to be able to edit the Squirrly SEO Snippet", _SQ_PLUGIN_NAME_) ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="sq_tab_edit">
                                                        <div class="sq-row">
                                                            <div class="sq-col-sm  sq-border-bottom sq-text-right sq-mb-2 sq-pb-2">
                                                                <input type="button" class="sq_snippet_btn_cancel sq-btn sq-btn-sm sq-btn-warning sq-rounded-0" value="<?php echo esc_html__("Cancel") ?>"/>
                                                                <input type="button" class="sq_snippet_btn_save sq-btn sq-btn-sm sq-btn-primary sq-px-5 sq-rounded-0" value="<?php echo esc_html__("Save") ?>"/>
                                                            </div>
                                                        </div>

                                                        <div class="sq-row">
                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_title')) { ?>
                                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                            <input type="hidden" id="activate_sq_auto_title" value="1"/>
                                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_title" data-action="sq_ajax_seosettings_save" data-name="sq_auto_title"><?php echo esc_html__("Activate Title", _SQ_PLUGIN_NAME_); ?></button>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_title')) ? 'sq_deactivated' : ''); ?>">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Title", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php sprintf(esc_html__("Tips: Length %s-%s chars", _SQ_PLUGIN_NAME_), 10, $view->post->sq_adm->title_maxlength); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo($loadpatterns ? 'sq_pattern_field' : '') ?>" data-patternid="<?php echo esc_attr($view->post->hash) ?>">
                                                                        <textarea autocomplete="off" rows="1" name="sq_title" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo($loadpatterns ? esc_html__("Pattern", _SQ_PLUGIN_NAME_) . ': ' . esc_attr($view->post->sq_adm->patterns->title) : esc_attr($view->post->sq->title)) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearTitle($view->post->sq_adm->title) ?></textarea>
                                                                        <input type="hidden" id="sq_title_preview_<?php echo esc_attr($view->post->hash) ?>" name="sq_title_preview" value="<?php echo esc_attr($view->post->sq->title) ?>">

                                                                        <div class="sq-col-sm-12 sq-px-0">
                                                                            <div class="sq-text-right sq-small">
                                                                                <span class="sq_length" data-maxlength="<?php echo (int)$view->post->sq_adm->title_maxlength ?>"><?php echo strlen($view->post->sq_adm->title) ?>/<?php echo (int)$view->post->sq_adm->title_maxlength ?></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="sq-actions">
                                                                            <div class="sq-action">
                                                                                <span style="display: none" class="sq-value sq-title-value" data-value="<?php echo esc_attr($view->post->sq->title) ?>"></span>
                                                                                <span class="sq-action-title" title="<?php echo esc_attr($view->post->sq->title) ?>"><?php echo esc_html__("Current Title", _SQ_PLUGIN_NAME_) ?>: <span class="sq-title-value"><?php echo esc_html($view->post->sq->title) ?></span></span>
                                                                            </div>
                                                                            <?php if (isset($view->post->post_title) && $view->post->post_title <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->post_title) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->post_title) ?>"><?php echo esc_html__("Default Title", _SQ_PLUGIN_NAME_) ?>: <span><?php echo esc_html($view->post->post_title) ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($view->post->sq_adm->patterns->title <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->sq_adm->patterns->title) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->sq_adm->patterns->title) ?>"><?php echo($loadpatterns ? esc_html__("Pattern", _SQ_PLUGIN_NAME_) . ': <span>' . esc_html($view->post->sq_adm->patterns->title) . '</span>' : '') ?></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>


                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_description')) { ?>
                                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                            <input type="hidden" id="activate_sq_auto_description" value="1"/>
                                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_description" data-action="sq_ajax_seosettings_save" data-name="sq_auto_description"><?php echo esc_html__("Activate Description", _SQ_PLUGIN_NAME_); ?></button>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_description')) ? 'sq_deactivated' : ''); ?>">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Meta Description", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php sprintf(esc_html__("Tips: Length %s-%s chars", _SQ_PLUGIN_NAME_), 10, $view->post->sq_adm->description_maxlength); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo($loadpatterns ? 'sq_pattern_field' : '') ?>" data-patternid="<?php echo esc_attr($view->post->hash) ?>">
                                                                        <textarea autocomplete="off" rows="3" name="sq_description" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo($loadpatterns ? esc_html__("Pattern", _SQ_PLUGIN_NAME_) . ': ' . esc_attr($view->post->sq_adm->patterns->description) : esc_attr($view->post->sq->description)) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearDescription($view->post->sq_adm->description) ?></textarea>
                                                                        <input type="hidden" id="sq_description_preview_<?php echo esc_attr($view->post->hash) ?>" name="sq_description_preview" value="<?php echo esc_attr($view->post->sq->description) ?>">

                                                                        <div class="sq-col-sm-12 sq-px-0">
                                                                            <div class="sq-text-right sq-small">
                                                                                <span class="sq_length" data-maxlength="<?php echo (int)$view->post->sq_adm->description_maxlength ?>"><?php echo strlen($view->post->sq_adm->description) ?>/<?php echo (int)$view->post->sq_adm->description_maxlength ?></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="sq-actions">
                                                                            <?php if (isset($view->post->sq->description) && $view->post->sq->description <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value sq-description-value" data-value="<?php echo esc_attr($view->post->sq->description) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->sq->description) ?>"><?php echo esc_html__("Current Description", _SQ_PLUGIN_NAME_) ?>: <span><?php echo esc_html($view->post->sq->description) ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if (isset($view->post->post_excerpt) && $view->post->post_excerpt <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->post_excerpt) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->post_excerpt) ?>"><?php echo esc_html__("Default Description", _SQ_PLUGIN_NAME_) ?>: <span><?php echo esc_html($view->post->post_excerpt) ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($view->post->sq_adm->patterns->description <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->sq_adm->patterns->description) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->sq_adm->patterns->description) ?>"><?php echo($loadpatterns ? esc_html__("Pattern", _SQ_PLUGIN_NAME_) . ': ' . '<span>' . esc_html($view->post->sq_adm->patterns->description) . '</span>' : '') ?></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>


                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords')) { ?>
                                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                            <input type="hidden" id="activate_sq_auto_keywords" value="1"/>
                                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_keywords" data-action="sq_ajax_seosettings_save" data-name="sq_auto_keywords"><?php echo esc_html__("Activate Keywords", _SQ_PLUGIN_NAME_); ?></button>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_keywords')) ? 'sq_deactivated' : ''); ?>">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Meta Keywords", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg">
                                                                        <input type="text" autocomplete="off" name="sq_keywords" class="sq-form-control sq-input-lg" value="<?php echo SQ_Classes_Helpers_Sanitize::clearKeywords($view->post->sq_adm->keywords) ?>" placeholder="<?php echo esc_html__("+ Add keyword", _SQ_PLUGIN_NAME_) ?>"/>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_canonical')) { ?>
                                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                            <input type="hidden" id="activate_sq_auto_canonical" value="1"/>
                                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_canonical" data-action="sq_ajax_seosettings_save" data-name="sq_auto_canonical"><?php echo esc_html__("Activate Canonical", _SQ_PLUGIN_NAME_); ?></button>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-input-group sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_canonical')) ? 'sq_deactivated' : ''); ?>">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Canonical link", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php echo esc_html__("Leave it blank if you don't have an external canonical", _SQ_PLUGIN_NAME_); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg">
                                                                        <input type="text" autocomplete="off" name="sq_canonical" class="sq-form-control sq-input-lg sq-toggle" value="<?php echo urldecode($view->post->sq_adm->canonical) ?>" placeholder="<?php echo esc_html__("Found", _SQ_PLUGIN_NAME_) . ': ' . urldecode($view->post->url) ?>"/>

                                                                        <div class="sq-actions">
                                                                            <?php if (!is_admin() && !is_network_admin()) { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value sq-canonical-value" data-value=""></span>
                                                                                    <span class="sq-action-title"><?php echo esc_html__("Current", _SQ_PLUGIN_NAME_) ?>: <span class="sq-canonical-value"></span></span>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <?php if (isset($view->post->url) && $view->post->url <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->url) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->url) ?>"><?php echo esc_html__("Default Link", _SQ_PLUGIN_NAME_) ?>: <span><?php echo urldecode($view->post->url) ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>


                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="sq-card-footer sq-py-0 sq-my-0 <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-mt-5' : ''; ?>">
                                            <div class="sq-row">
                                                <div class="sq-text-center sq-col-sm-12 sq-my-4 sq-mx-0 sq-px-0 sq-text-danger" style="font-size: 18px; <?php echo ($view->post->sq_adm->doseo == 1) ? 'display: none' : ''; ?>">
                                                    <?php echo esc_html__("To edit the snippet, you have to activate Squirrly SEO for this page first", _SQ_PLUGIN_NAME_) ?>
                                                </div>
                                            </div>
                                            <div class="sq-row">

                                                <div class="sq-col-sm-8 sq-row sq-my-0 sq-mx-0 sq-px-0">
                                                    <div class="sq-checker sq-col-sm-12 sq-row sq-my-2 sq-py-1 sq-px-4">
                                                        <div class="sq-col-sm-12 sq-p-0 sq-switch redgreen sq-switch-sm">
                                                            <input type="checkbox" id="sq_doseo_<?php echo esc_attr($view->post->hash) ?>" name="sq_doseo" class="sq-switch" <?php echo ($view->post->sq_adm->doseo == 1) ? 'checked="checked"' : ''; ?> value="1"/>
                                                            <label for="sq_doseo_<?php echo esc_attr($view->post->hash) ?>" class="sq-ml-2"><?php echo esc_html__("Activate Squirrly Snippet for this page", _SQ_PLUGIN_NAME_); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="sq-col-sm-4 sq-text-right sq-small sq-py-3 sq-px-2 sq-font-italic sq-text-black-50">
                                                    <?php echo esc_html__("Post Type", _SQ_PLUGIN_NAME_) ?>:
                                                    <strong><?php echo (string)$view->post->post_type ?></strong> |
                                                    <?php echo esc_html__("OG Type", _SQ_PLUGIN_NAME_) ?>:
                                                    <strong><?php echo (string)$view->post->sq->og_type ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="sqtab<?php echo esc_attr($view->post->hash) ?>2" class="sq-tab-pane" role="tabpanel">
                                    <div class="sq-card sq-border-0">
                                        <div class="sq-card-body sq_tab_jsonld sq_tabcontent <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-d-none' : ''; ?>">
                                            <div class="sq-row">
                                                <div class="sq-col-sm  sq-border-bottom sq-text-right sq-mb-2 sq-pb-2">
                                                    <input type="button" class="sq_snippet_btn_refresh sq-btn sq-btn-sm sq-btn-warning sq-px-3 sq-rounded-0" value="<?php echo esc_html__("Refresh", _SQ_PLUGIN_NAME_) ?>"/>
                                                    <input type="button" class="sq_snippet_btn_save sq-btn sq-btn-sm sq-btn-primary sq-px-5 sq-rounded-0" value="<?php echo esc_html__("Save") ?>"/>
                                                </div>
                                            </div>

                                            <div class="sq-row">

                                                <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                    <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld')) { ?>
                                                        <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                            <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                                <input type="hidden" id="activate_sq_auto_jsonld" value="1"/>
                                                                <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-lg" data-input="activate_sq_auto_jsonld" data-action="sq_ajax_seosettings_save" data-name="sq_auto_jsonld"><?php echo esc_html__("Activate JSON-LD", _SQ_PLUGIN_NAME_); ?></button>
                                                            </div>
                                                        </div>
                                                    <?php } elseif (!$view->post->sq->do_jsonld) { ?>
                                                        <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                            <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                                <?php echo sprintf(esc_html__("JSON-LD is disable for this Post Type (%s). See %sSquirrly > SEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), $view->post->post_type, '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php
                                                    SQ_Classes_ObjController::getClass('SQ_Models_Services_JsonLD');
                                                    //Hook the json_ld
                                                    $jsoncode = apply_filters('sq_json_ld', false);
                                                    if($jsoncode) {
                                                        $jsoncode = str_replace(array("\n", "\r"), "", $jsoncode);
                                                        $jsoncode = SQ_Classes_Helpers_Sanitize::normalizeChars($jsoncode);
                                                        $jsoncode = wp_json_encode($jsoncode);
                                                    }

                                                    //normalize the chars for form submit
                                                    if ($jsonld_data = (($view->post->sq_adm->jsonld <> '') ? $view->post->sq_adm->jsonld : $jsoncode)) {
                                                        $jsonld_data = wp_unslash($jsonld_data);
                                                        $jsonld_data = trim($jsonld_data, '""');
                                                        $jsonld_data = strip_tags($jsonld_data);
                                                    } else {
                                                        $jsonld_data = '';
                                                    }
                                                    ?>

                                                    <div class="sq-col-sm-12 sq-row sq-py-0 sq-m-0 sq-px-0  <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld') || !$view->post->sq->do_jsonld) ? 'sq_deactivated' : ''); ?>">
                                                        <div class="sq-col-sm-12 sq-row sq-my-0 sq-mx-0 sq-px-0">

                                                            <div class="sq-col-sm-12 sq-row sq-my-2 sq-px-0 sq-mx-0 sq-py-1 sq-px-2">
                                                                <div class="sq-col-sm-4 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                    <?php echo esc_html__("JSON-LD Schema Types", _SQ_PLUGIN_NAME_); ?>:<a href="https://howto.squirrly.co/kb/bulk-seo/#bulk_seo_snippet_jsonld" target="_blank"><i class="fa fa-question-circle m-0 px-1" style="display: inline; color:inherit !important;"></i></a>
                                                                    <div class="sq-small sq-text-black-50 sq-my-1 sq-pr-4"><?php echo esc_html__("JSON-LD will load the Schema for the selected types.", _SQ_PLUGIN_NAME_); ?></div>
                                                                    <div class="sq-small sq-text-black-50 sq-my-3 sq-pr-4"><?php echo sprintf(esc_html__("Setup JSON-LD for this Post Type by using %s SEO Automation %s", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '">', '</a>'); ?></div>
                                                                </div>
                                                                <?php
                                                                $jsonld_types = json_decode(SQ_ALL_JSONLD_TYPES, true);

                                                                if (in_array($view->post->post_type, array('search', 'category', 'tag', 'archive', 'attachment', 'tax-post_tag', 'tax-post_cat', 'tax-product_tag', 'tax-product_cat'))) $jsonld_types = array('website');
                                                                if (in_array($view->post->post_type, array('home', 'shop'))) $jsonld_types = array('website', 'local store', 'local restaurant');
                                                                if ($view->post->post_type == 'profile') $jsonld_types = array('profile');
                                                                if ($view->post->post_type == 'product') $jsonld_types = array('product');

                                                                $sq_jsonld_types = array();
                                                                $patterns = SQ_Classes_Helpers_Tools::getOption('patterns');
                                                                if(isset($patterns[$view->post->post_type]['jsonld_types'])){
                                                                    $sq_jsonld_types = $patterns[$view->post->post_type]['jsonld_types'];
                                                                    foreach ($sq_jsonld_types as &$jsonld_type) {
                                                                        $jsonld_type = ucwords($jsonld_type);
                                                                    }
                                                                }

                                                                $view->post->sq_adm->jsonld_types = array_filter((array)$view->post->sq_adm->jsonld_types);

                                                                ?>
                                                                <div class="sq-col-sm-8 sq-p-0 sq-input-group">
                                                                    <select multiple name="sq_jsonld_types[]" class="sq_jsonld_types sq-form-control sq-bg-input sq-mb-1" style="min-height: <?php echo ((count($jsonld_types) + 2) * 20) . 'px !important;' ?>">
                                                                        <option <?php echo(empty((array)$view->post->sq_adm->jsonld_types) ? 'selected="selected"' : '') ?> value=""><?php echo esc_html__("SEO Automation", _SQ_PLUGIN_NAME_) . ' (' . join(', ', $sq_jsonld_types) ?>)</option>
                                                                        <?php foreach ($jsonld_types as $post_type => $jsonld_type) { ?>
                                                                            <option <?php echo(in_array($jsonld_type, (array)$view->post->sq_adm->jsonld_types) ? 'selected="selected"' : '') ?> value="<?php echo esc_attr($jsonld_type) ?>">
                                                                                <?php echo ucwords($jsonld_type) ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <div class="sq-small sq-text-warning sq-my-1 sq-pr-4"><?php echo esc_html__("Hold Control key (or Command on Mac) to select multiple types.", _SQ_PLUGIN_NAME_); ?></div>

                                                                </div>

                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-my-2 sq-px-0 sq-mx-0 sq-py-1 sq-px-2">

                                                                <div class="sq-col-sm-4 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                    <?php echo esc_html__("JSON-LD Breadcrumbs Schema", _SQ_PLUGIN_NAME_); ?><a href="https://howto.squirrly.co/kb/json-ld-structured-data/#breadcrumbs_schema" target="_blank"><i class="fa fa-question-circle m-0 px-1" style="display: inline; color:inherit !important;"></i></a>
                                                                    <div class="sq-small text-black-50 sq-my-1 sq-pr-4"><?php echo sprintf(esc_html__("Manage BreadcrumbsList Schema from %s JSON-LD Settings %s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'jsonld') . '">', '</a>'); ?></div>
                                                                </div>

                                                                <div class="sq-col-sm-8 sq-p-0 sq-input-group">
                                                                    <?php if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_breadcrumbs')) { ?>
                                                                        <div class="sq-text-success sq-font-weight-bold"><?php echo esc_html__("Active", _SQ_PLUGIN_NAME_); ?></div>
                                                                    <?php } else { ?>
                                                                        <div class="sq-text-danger sq-font-weight-bold"><?php echo esc_html__("Not Active", _SQ_PLUGIN_NAME_); ?></div>
                                                                    <?php } ?>
                                                                </div>

                                                            </div>

                                                            <?php if ($view->post->post_type == 'product'){ ?>
                                                            <div class="sq-col-sm-12 sq-row sq-my-2 sq-px-0 sq-mx-0 sq-py-1 sq-px-2">

                                                                <div class="sq-col-sm-4 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                    <?php echo esc_html__("Woocommerce Product Support", _SQ_PLUGIN_NAME_); ?><a href="https://howto.squirrly.co/kb/json-ld-structured-data/#woocommerce" target="_blank"><i class="fa fa-question-circle m-0 px-1" style="display: inline; color:inherit !important;"></i></a>
                                                                    <div class="sq-small sq-text-black-50 sq-my-1 sq-pr-4"><?php echo sprintf(esc_html__("Manage Woocommerce Support from %s JSON-LD Settings %s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'jsonld') . '">', '</a>'); ?></div>
                                                                </div>

                                                                <div class="sq-col-sm-8 sq-p-0 sq-input-group">
                                                                    <?php if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_product_defaults')) { ?>
                                                                        <div class="sq-text-success sq-font-weight-bold"><?php echo esc_html__("Active", _SQ_PLUGIN_NAME_); ?></div>
                                                                    <?php } else { ?>
                                                                        <div class="sq-text-danger sq-font-weight-bold"><?php echo esc_html__("Not Active", _SQ_PLUGIN_NAME_); ?></div>
                                                                    <?php } ?>
                                                                </div>

                                                            </div>
                                                            <?php } ?>

                                                            <?php if (SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) { ?>
                                                                <div class="sq-col-sm-12 sq-row sq-my-2 sq-px-0 sq-mx-0 sq-py-1 sq-px-2 ">

                                                                    <div class="sq-col-sm-4 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Remove other JSON-LD Schema", _SQ_PLUGIN_NAME_); ?><a href="https://howto.squirrly.co/kb/json-ld-structured-data/#remove_duplicates" target="_blank"><i class="fa fa-question-circle m-0 pl-1 pr-0" style="display: inline; color:inherit !important;"></i></a>
                                                                        <div class="sq-small text-black-50 sq-my-1 sq-pr-4"><?php echo sprintf(esc_html__("Manage Duplicate Schema remover from %s JSON-LD Settings %s.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'jsonld') . '">', '</a>'); ?></div>
                                                                    </div>

                                                                    <div class="sq-col-sm-8 sq-p-0 sq-input-group">
                                                                        <?php if (SQ_Classes_Helpers_Tools::getOption('sq_jsonld_clearcode')) { ?>
                                                                            <div class="sq-text-info sq-font-weight-bold"><?php echo esc_html__("Active", _SQ_PLUGIN_NAME_); ?></div>
                                                                        <?php } else { ?>
                                                                            <div class="sq-text-info sq-font-weight-bold"><?php echo esc_html__("Not Active", _SQ_PLUGIN_NAME_); ?></div>
                                                                        <?php } ?>
                                                                    </div>

                                                                </div>

                                                                <div class="sq-col-sm-12 sq-row sq-my-2 sq-px-0 sq-mx-0 sq-py-1 sq-px-2">

                                                                    <div class="sq-col-sm-12 sq-row sq-p-0 sq-m-0">
                                                                        <div class="sq-col-sm-4 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                            <?php echo esc_html__("JSON-LD Code", _SQ_PLUGIN_NAME_); ?>:<a href="https://howto.squirrly.co/kb/bulk-seo/#jsonld_custom_code" target="_blank"><i class="fa fa-question-circle m-0 px-1" style="display: inline; color:inherit !important;"></i></a>
                                                                            <div class="sq-small sq-text-black-50 sq-my-1 sq-pr-4"><?php echo esc_html__("Let Squirrly load the JSON-LD Schema for the selected types.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                        <div class="sq-col-sm-8 sq-p-0 sq-input-group">
                                                                            <select class="sq_jsonld_code_type sq-form-control sq-bg-input sq-mb-1" name="sq_jsonld_code_type">
                                                                                <option <?php echo(($view->post->sq_adm->jsonld == '') ? 'selected="selected"' : '') ?> value="auto"><?php echo esc_html__("(Auto)", _SQ_PLUGIN_NAME_) ?></option>
                                                                                <option <?php echo(($view->post->sq_adm->jsonld <> '') ? 'selected="selected"' : '') ?> value="custom"><?php echo esc_html__("Custom Code", _SQ_PLUGIN_NAME_) ?></option>
                                                                            </select>
                                                                            <div class="sq-small sq-text-black-50 sq-my-1 sq-pr-4"><?php echo sprintf(esc_html__("Use Advanced Custom Fields (ACF) plugin to add custom JSON-LD. %s Learn More %s", _SQ_PLUGIN_NAME_),'<a href="https://howto.squirrly.co/kb/json-ld-structured-data/#ACF" class="sq-m-0 sq-p-0" target="_blank" style="font-weight: bold !important; font-size: 12px !important;">', '</a>'); ?></div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <div class="sq_jsonld_custom_code sq-col-sm-12 sq-row sq-my-2 sq-mx-0 sq-py-1 sq-px-2" <?php echo(($view->post->sq_adm->jsonld == '') ? 'style="display: none;"' : '') ?>>
                                                                    <div class="sq-col-sm-4 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Custom JSON-LD Code", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small text-black-50 sq-my-1 sq-pr-4"><?php echo sprintf(esc_html__("Add JSON-LD code from %sSchema Generator Online%s.", _SQ_PLUGIN_NAME_), '<a href="https://technicalseo.com/seo-tools/schema-markup-generator/" class="sq-m-0 sq-p-0" target="_blank" style="font-weight: bold !important; font-size: 12px !important;">', '</a>'); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-8 sq-p-0 sq-sq-m-0">
                                                                        <textarea class="sq-form-control sq-m-0" name="sq_jsonld" rows="5" style="font-size: 12px !important;"><?php echo (string)$jsonld_data ?></textarea>
                                                                    </div>
                                                                </div>

                                                            <?php } ?>


                                                            <div class="sq-col-sm-12 sq-p-0 sq-py-1 sq-my-3 sq-small">
                                                                <form method="post" target="_blank" action="https://search.google.com/test/rich-results">
                                                                    <button type="submit" class="sq-btn sq-btn-secondary sq-btn-block">
                                                                        <i class="fa fa-google"></i> <?php echo esc_html__("Validate JSON-LD", _SQ_PLUGIN_NAME_) ?>
                                                                    </button>
                                                                    <textarea name="code_snippet" style="display: none"><?php echo (string)$jsonld_data; ?></textarea>
                                                                </form>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="sq-card-footer sq-py-0 sq-my-0 <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-mt-5' : ''; ?>">
                                            <div class="sq-row">
                                                <div class="sq-text-center sq-col-sm-12 sq-my-4 sq-mx-0 sq-px-0 sq-text-danger" style="font-size: 18px; <?php echo ($view->post->sq_adm->doseo == 1) ? 'display: none' : ''; ?>">
                                                    <?php echo esc_html__("To edit the snippet, you have to activate Squirrly SEO for this page first", _SQ_PLUGIN_NAME_) ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div id="sqtab<?php echo esc_attr($view->post->hash) ?>3" class="sq-tab-pane" role="tabpanel">
                                    <div class="sq-card sq-border-0">
                                        <?php if (!$view->post->sq->do_og) { ?>
                                            <div class="sq-row">
                                                <div class="sq-text-center sq-col-sm-12 sq-my-5 sq-mx-0 sq-px-0 sq-text-danger"><?php echo sprintf(esc_html__("Post Type (%s) was excluded from %sSquirrly > SEO Settings%s. Squirrly SEO will not load for this post type on the frontend.", _SQ_PLUGIN_NAME_), '<strong>' . $view->post->post_type . '</strong>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="sq-card-body sq_tab_facebook sq_tabcontent <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-d-none' : ''; ?>">
                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) { ?>
                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                            <input type="hidden" id="activate_sq_auto_facebook" value="1"/>
                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-lg" data-input="activate_sq_auto_facebook" data-action="sq_ajax_seosettings_save" data-name="sq_auto_facebook"><?php echo esc_html__("Activate Open Graph", _SQ_PLUGIN_NAME_); ?></button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="<?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_facebook')) ? 'sq_deactivated' : ''); ?>">

                                                    <div class="sq_tab_preview">
                                                        <div class="sq-row sq-border-bottom sq-mb-2 sq-pb-2">
                                                            <div class="sq-col-sm">
                                                                <div class="sq_message"><?php echo esc_html__("How this page appears on Facebook", _SQ_PLUGIN_NAME_) ?>:</div>

                                                            </div>
                                                            <div class="sq-col-sm sq-text-right ">
                                                                <div class="sq-refresh"></div>
                                                                <input type="button" class="sq_snippet_btn_refresh sq-btn sq-btn-sm sq-btn-warning sq-px-3 sq-rounded-0" value="<?php echo esc_html__("Refresh", _SQ_PLUGIN_NAME_) ?>"/>
                                                                <input type="button" class="sq_snippet_btn_edit sq-btn sq-btn-sm sq-btn-primary sq-px-3 sq-rounded-0" value="<?php echo esc_html__("Edit Open Graph", _SQ_PLUGIN_NAME_) ?>"/>
                                                            </div>
                                                            <?php
                                                            if ($view->post->sq->og_media <> '') {
                                                                try {
                                                                    if (defined('WP_CONTENT_DIR') && $imagepath = str_replace(content_url(), WP_CONTENT_DIR, $view->post->sq->og_media)) {

                                                                        if (file_exists($imagepath)) {
                                                                            list($width, $height) = @getimagesize($imagepath);

                                                                            if ((int)$width > 0 && (int)$width < 500) { ?>
                                                                                <div class="sq-col-sm-12">
                                                                                    <div class="sq-alert sq-alert-danger"><?php echo esc_html__("The image size must be at least 500 pixels wide", _SQ_PLUGIN_NAME_) ?></div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }

                                                                } catch (Exception $e) {
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php if ($view->post->post_title <> esc_html__("Auto Draft") && $view->post->post_title <> esc_html__("AUTO-DRAFT")) { ?>
                                                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-mx-auto sq-border">
                                                                <ul class="sq-p-3 sq-m-0" style="min-height: 125px;">
                                                                    <?php if ($view->post->sq->og_media <> '') { ?>
                                                                        <li class="sq_snippet_image">
                                                                            <img src="<?php echo esc_attr($view->post->sq->og_media) ?>">
                                                                        </li>
                                                                    <?php } elseif ($view->post->post_attachment <> '') { ?>
                                                                        <li class="sq_snippet_image sq_snippet_post_atachment">
                                                                            <img src="<?php echo esc_attr($view->post->post_attachment) ?>" title="<?php echo esc_html__("This is the Featured Image. You can change it if you edit the snippet and upload another image.", _SQ_PLUGIN_NAME_) ?>">
                                                                        </li>
                                                                    <?php } ?>

                                                                    <li class="sq_snippet_title sq-text-info sq-font-weight-bold"><?php echo($view->post->sq->og_title <> '' ? esc_html($view->post->sq->og_title) : SQ_Classes_Helpers_Sanitize::truncate(esc_html($view->post->sq->title), 10, (int)$view->post->sq->og_title_maxlength)) ?></li>
                                                                    <li class="sq_snippet_description sq-text-black-50"><?php echo($view->post->sq->og_description <> '' ? esc_html($view->post->sq->og_description) : SQ_Classes_Helpers_Sanitize::truncate(esc_html($view->post->sq->description), 10, (int)$view->post->sq->og_description_maxlength)) ?></li>
                                                                    <li class="sq_snippet_author sq-text-link"><?php echo str_replace(array('//facebook.com/', '//www.facebook.com/', 'https:', 'http:'), '', esc_html($view->post->sq->og_author)) ?></li>
                                                                    <li class="sq_snippet_sitename sq-text-black-50"><?php echo get_bloginfo('title') ?></li>
                                                                </ul>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-border">
                                                                <div style="padding: 20px"><?php echo esc_html__("Please save the post first to be able to edit the Squirrly SEO Snippet.", _SQ_PLUGIN_NAME_) ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="sq_tab_edit">
                                                        <div class="sq-row">
                                                            <div class="sq-col-sm  sq-border-bottom sq-text-right sq-mb-2 sq-pb-2">
                                                                <input type="button" class="sq_snippet_btn_cancel sq-btn sq-btn-sm sq-btn-warning sq-rounded-0" value="<?php echo esc_html__("Cancel") ?>"/>
                                                                <input type="button" class="sq_snippet_btn_save sq-btn sq-btn-sm sq-btn-primary sq-px-5 sq-rounded-0" value="<?php echo esc_html__("Save") ?>"/>
                                                            </div>
                                                        </div>

                                                        <div class="sq-row">
                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Media Image", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg">
                                                                        <button class="sq_get_og_media sq-btn sq-btn-warning sq-form-control sq-input-lg"><?php echo esc_html__("Upload", _SQ_PLUGIN_NAME_) ?></button>
                                                                        <span><?php echo esc_html__("Image size must be at least 500 pixels wide", _SQ_PLUGIN_NAME_) ?></span>
                                                                    </div>

                                                                </div>

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <input type="hidden" name="sq_og_media" value="<?php echo esc_attr($view->post->sq_adm->og_media) ?>"/>
                                                                    <div style="max-width: 470px;" class="sq-position-relative sq-offset-sm-3">
                                                                        <span class="sq_og_image_close">x</span>
                                                                        <img class="sq_og_media_preview" src=""/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Title", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php sprintf(esc_html__("Tips: Length %s-%s chars", _SQ_PLUGIN_NAME_), 10, (int)$view->post->sq_adm->og_title_maxlength); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo($loadpatterns ? 'sq_pattern_field' : '') ?>" data-patternid="<?php echo esc_attr($view->post->hash) ?>">
                                                                        <textarea autocomplete="off" rows="1" name="sq_og_title" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo($loadpatterns ? esc_html__("Pattern", _SQ_PLUGIN_NAME_) . ': ' . esc_attr($view->post->sq_adm->patterns->title) : $view->post->sq->og_title) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearTitle($view->post->sq_adm->og_title) ?></textarea>
                                                                        <input type="hidden" id="sq_title_preview_<?php echo esc_attr($view->post->hash) ?>" name="sq_title_preview" value="<?php echo esc_attr($view->post->sq->og_title) ?>">

                                                                        <div class="sq-col-sm-12 sq-px-0">
                                                                            <div class="sq-text-right sq-small">
                                                                                <span class="sq_length" data-maxlength="<?php echo (int)$view->post->sq_adm->og_title_maxlength ?>"><?php echo strlen($view->post->sq_adm->og_title) ?>/<?php echo (int)$view->post->sq_adm->og_title_maxlength ?></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="sq-actions">
                                                                            <div class="sq-action">
                                                                                <span style="display: none" class="sq-value sq-title-value" data-value="<?php echo esc_attr($view->post->sq->og_title) ?>"></span>
                                                                                <span class="sq-action-title" title="<?php echo esc_attr($view->post->sq->og_title) ?>"><?php echo esc_html__("Current Title", _SQ_PLUGIN_NAME_) ?>: <span class="sq-title-value"><?php echo esc_html($view->post->sq->og_title) ?></span></span>
                                                                            </div>
                                                                            <?php if (isset($view->post->post_title) && $view->post->post_title <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->post_title) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->post_title) ?>"><?php echo esc_html__("Default Title", _SQ_PLUGIN_NAME_) ?>: <span><?php echo esc_html($view->post->post_title) ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($view->post->sq_adm->patterns->title <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->sq_adm->patterns->title) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->sq_adm->patterns->title) ?>"><?php echo($loadpatterns ? esc_html__("Pattern", _SQ_PLUGIN_NAME_) . ': ' . '<span>' . esc_html($view->post->sq_adm->patterns->title) . '</span>' : '') ?></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Description", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php sprintf(esc_html__("Tips: Length %s-%s chars", _SQ_PLUGIN_NAME_), 10, $view->post->sq_adm->og_description_maxlength); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo($loadpatterns ? 'sq_pattern_field' : '') ?>" data-patternid="<?php echo esc_attr($view->post->hash) ?>">
                                                                        <textarea autocomplete="off" rows="3" name="sq_og_description" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo($loadpatterns ? esc_html__("Pattern", _SQ_PLUGIN_NAME_) . ': ' . esc_attr($view->post->sq_adm->patterns->description) : esc_attr($view->post->sq->og_description)) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearDescription($view->post->sq_adm->og_description) ?></textarea>
                                                                        <input type="hidden" id="sq_description_preview_<?php echo esc_attr($view->post->hash) ?>" name="sq_description_preview" value="<?php echo esc_attr($view->post->sq->og_description) ?>">

                                                                        <div class="sq-col-sm-12 sq-px-0">
                                                                            <div class="sq-text-right sq-small">
                                                                                <span class="sq_length" data-maxlength="<?php echo (int)$view->post->sq_adm->og_description_maxlength ?>"><?php echo strlen($view->post->sq_adm->og_description) ?>/<?php echo (int)$view->post->sq_adm->og_description_maxlength ?></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="sq-actions">
                                                                            <?php if (isset($view->post->sq->og_description) && $view->post->sq->og_description <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value sq-description-value" data-value="<?php echo esc_attr($view->post->sq->og_description) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->sq->og_description) ?>"><?php echo esc_html__("Current Description", _SQ_PLUGIN_NAME_) ?>: <span><?php echo esc_html($view->post->sq->og_description) ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if (isset($view->post->post_excerpt) && $view->post->post_excerpt <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->post_excerpt) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->post_excerpt) ?>"><?php echo esc_html__("Default Description", _SQ_PLUGIN_NAME_) ?>: <span><?php echo esc_html($view->post->post_excerpt) ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($view->post->sq_adm->patterns->description <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->sq_adm->patterns->description) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->sq_adm->patterns->description) ?>"><?php echo($loadpatterns ? esc_html__("Pattern", _SQ_PLUGIN_NAME_) . ': ' . '<span>' . esc_html($view->post->sq_adm->patterns->description) . '</span>' : '') ?></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Author Link", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php echo esc_html__("For multiple authors, separate their Facebook links with commas", _SQ_PLUGIN_NAME_); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg">
                                                                        <input type="text" autocomplete="off" name="sq_og_author" class="sq-form-control sq-input-lg " value="<?php echo urldecode($view->post->sq_adm->og_author) ?>"/>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("OG Type", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"></div>
                                                                    </div>
                                                                    <?php
                                                                    $og_types = json_decode(SQ_ALL_OG_TYPES, true);

                                                                    if (in_array($view->post->post_type, array('home', 'search', 'category', 'tag', 'archive', 'attachment', 'tax-post-tag', 'tax-post-cat', 'tax-product-tag', 'tax-product-cat', 'shop'))) $og_types = array('website');
                                                                    if ($view->post->post_type == 'profile') $og_types = array('profile');
                                                                    ?>
                                                                    <div class="sq-col-sm-4 sq-p-0 sq-input-group">
                                                                        <select name="sq_og_type" class="sq-form-control sq-bg-input sq-mb-1">
                                                                            <option <?php echo(($view->post->sq_adm->og_type == '') ? 'selected="selected"' : '') ?> value=""><?php echo esc_html__("(Auto)", _SQ_PLUGIN_NAME_) ?></option>
                                                                            <?php foreach ($og_types as $post_type => $og_type) { ?>
                                                                                <option <?php echo(($view->post->sq_adm->og_type == $og_type) ? 'selected="selected"' : '') ?> value="<?php echo esc_attr($og_type) ?>">
                                                                                    <?php echo ucfirst($og_type) ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>

                                                                </div>

                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sq-card-footer sq-py-0 sq-my-0 <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-mt-5' : ''; ?>">
                                                <div class="sq-row">
                                                    <div class="sq-text-center sq-col-sm-12 sq-my-4 sq-mx-0 sq-px-0 sq-text-danger" style="font-size: 18px; <?php echo ($view->post->sq_adm->doseo == 1) ? 'display: none' : ''; ?>">
                                                        <?php echo esc_html__("To edit the snippet, you have to activate Squirrly SEO for this page first", _SQ_PLUGIN_NAME_) ?>
                                                    </div>
                                                </div>
                                                <div class="sq-row">
                                                    <div class="sq-col-sm-12 sq-text-right sq-small sq-py-3 sq-px-2 sq-font-italic sq-text-black-50">
                                                        <?php echo esc_html__("Post Type", _SQ_PLUGIN_NAME_) ?>:
                                                        <strong><?php echo (string)$view->post->post_type ?></strong> |
                                                        <?php echo esc_html__("OG Type", _SQ_PLUGIN_NAME_) ?>:
                                                        <strong><?php echo (string)$view->post->sq->og_type ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>
                                <div id="sqtab<?php echo esc_attr($view->post->hash) ?>4" class="sq-tab-pane" role="tabpanel">
                                    <div class="sq-card sq-border-0">
                                        <?php if (!$view->post->sq->do_twc) { ?>
                                            <div class="sq-row">
                                                <div class="sq-text-center sq-col-sm-12 sq-my-5 sq-mx-0 sq-px-0 sq-text-danger"><?php echo sprintf(esc_html__("Post Type (%s) was excluded from %sSquirrly > SEO Settings%s. Squirrly SEO will not load for this post type on the frontend.", _SQ_PLUGIN_NAME_), '<strong>' . $view->post->post_type . '</strong>', '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?></div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="sq-card-body sq_tab_twitter sq_tabcontent <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-d-none' : ''; ?>">
                                                <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) { ?>
                                                    <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                        <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                            <input type="hidden" id="activate_sq_auto_twitter" value="1"/>
                                                            <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-lg" data-input="activate_sq_auto_twitter" data-action="sq_ajax_seosettings_save" data-name="sq_auto_twitter"><?php echo esc_html__("Activate Twitter Card", _SQ_PLUGIN_NAME_); ?></button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="<?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_twitter')) ? 'sq_deactivated' : ''); ?>">

                                                    <div class="sq_tab_preview">
                                                        <div class="sq-row sq-border-bottom sq-mb-2 sq-pb-2">
                                                            <div class="sq-col-sm">
                                                                <div class="sq_message"><?php echo esc_html__("How this page appears on Twitter", _SQ_PLUGIN_NAME_) ?>:</div>

                                                            </div>
                                                            <div class="sq-col-sm sq-text-right ">
                                                                <div class="sq-refresh"></div>
                                                                <input type="button" class="sq_snippet_btn_refresh sq-btn sq-btn-sm sq-btn-warning sq-px-3 sq-rounded-0" value="<?php echo esc_html__("Refresh", _SQ_PLUGIN_NAME_) ?>"/>
                                                                <input type="button" class="sq_snippet_btn_edit sq-btn sq-btn-sm sq-btn-primary sq-px-3 sq-rounded-0" value="<?php echo esc_html__("Edit Twitter Card", _SQ_PLUGIN_NAME_) ?>"/>
                                                            </div>

                                                            <?php
                                                            if ($view->post->sq->tw_media <> '') {
                                                                try {
                                                                    if (defined('WP_CONTENT_DIR') && $imagepath = str_replace(content_url(), WP_CONTENT_DIR, $view->post->sq->tw_media)) {

                                                                        if (file_exists($imagepath)) {
                                                                            list($width, $height) = @getimagesize($imagepath);

                                                                            if ((int)$width > 0 && (int)$width < 500) { ?>
                                                                                <div class="sq-col-sm-12">
                                                                                    <div class="sq-alert sq-alert-danger"><?php echo esc_html__("The image size must be at least 500 pixels wide", _SQ_PLUGIN_NAME_) ?></div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }

                                                                } catch (Exception $e) {
                                                                }
                                                            }
                                                            ?>

                                                        </div>
                                                        <?php if ($view->post->post_title <> esc_html__("Auto Draft") && $view->post->post_title <> esc_html__("AUTO-DRAFT")) { ?>
                                                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-mx-auto sq-border">
                                                                <ul class="sq-p-3 sq-m-0" style="min-height: 125px;">
                                                                    <?php if ($view->post->sq->tw_media <> '') { ?>
                                                                        <li class="sq_snippet_image <?php echo((($view->post->sq_adm->tw_type == '' && $socials->twitter_card_type == 'summary') || $view->post->sq_adm->tw_type == 'summary') ? 'sq_snippet_smallimage' : '') ?>">
                                                                            <img src="<?php echo esc_attr($view->post->sq->tw_media) ?>">
                                                                        </li>
                                                                    <?php } elseif ($view->post->post_attachment <> '') { ?>
                                                                        <li class="sq_snippet_image sq_snippet_post_atachment <?php echo((($view->post->sq_adm->tw_type == '' && $socials->twitter_card_type == 'summary') || $view->post->sq_adm->tw_type == 'summary') ? 'sq_snippet_smallimage' : '') ?>">
                                                                            <img src="<?php echo esc_attr($view->post->post_attachment) ?>" title="<?php echo esc_html__("This is the Featured Image. You can change it if you edit the snippet and upload another image.", _SQ_PLUGIN_NAME_) ?>">
                                                                        </li>
                                                                    <?php } ?>

                                                                    <li class="sq_snippet_title sq-text-info sq-font-weight-bold"><?php echo($view->post->sq->tw_title <> '' ? esc_html($view->post->sq->tw_title) : SQ_Classes_Helpers_Sanitize::truncate(esc_html($view->post->sq->title), 10, (int)$view->post->sq->tw_title_maxlength)) ?></li>
                                                                    <li class="sq_snippet_description sq-text-black-50"><?php echo($view->post->sq->tw_description <> '' ? esc_html($view->post->sq->tw_description) : SQ_Classes_Helpers_Sanitize::truncate(esc_html($view->post->sq->description), 10, (int)$view->post->sq->tw_description_maxlength)) ?></li>
                                                                    <li class="sq_snippet_sitename sq-text-black-50"><?php echo parse_url(get_bloginfo('url'), PHP_URL_HOST) ?></li>
                                                                </ul>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="sq_snippet_preview sq-mb-2 sq-p-0 sq-border">
                                                                <div style="padding: 20px"><?php echo esc_html__("Please save the post first to be able to edit the Squirrly SEO Snippet", _SQ_PLUGIN_NAME_) ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="sq_tab_edit">
                                                        <div class="sq-row">
                                                            <div class="sq-col-sm  sq-border-bottom sq-text-right sq-mb-2 sq-pb-2">
                                                                <input type="button" class="sq_snippet_btn_cancel sq-btn sq-btn-sm sq-btn-warning sq-rounded-0" value="<?php echo esc_html__("Cancel") ?>"/>
                                                                <input type="button" class="sq_snippet_btn_save sq-btn sq-btn-sm sq-btn-primary sq-px-5 sq-rounded-0" value="<?php echo esc_html__("Save") ?>"/>
                                                            </div>
                                                        </div>

                                                        <div class="sq-row">
                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Media Image", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg">
                                                                        <button class="sq_get_tw_media sq-btn sq-btn-warning sq-form-control sq-input-lg"><?php echo esc_html__("Upload", _SQ_PLUGIN_NAME_) ?></button>
                                                                        <span><?php echo esc_html__("Image size must be at least 500 pixels wide", _SQ_PLUGIN_NAME_) ?></span>
                                                                    </div>

                                                                </div>

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <input type="hidden" name="sq_tw_media" value="<?php echo esc_attr($view->post->sq_adm->tw_media) ?>"/>
                                                                    <div style="max-width: 470px;" class="sq-position-relative sq-offset-sm-3">
                                                                        <span class="sq_tw_image_close">x</span>
                                                                        <img class="sq_tw_media_preview" src=""/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Title", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php sprintf(esc_html__("Tips: Length %s-%s chars", _SQ_PLUGIN_NAME_), 10, $view->post->sq_adm->og_title_maxlength); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo($loadpatterns ? 'sq_pattern_field' : '') ?>" data-patternid="<?php echo esc_attr($view->post->hash) ?>">
                                                                        <textarea autocomplete="off" rows="1" name="sq_tw_title" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo($loadpatterns ? esc_html__("Pattern", _SQ_PLUGIN_NAME_) . ': ' . esc_attr($view->post->sq_adm->patterns->title) : esc_attr($view->post->sq->tw_title)) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearTitle($view->post->sq_adm->tw_title) ?></textarea>
                                                                        <input type="hidden" id="sq_title_preview_<?php echo esc_attr($view->post->hash) ?>" name="sq_title_preview" value="<?php echo esc_attr($view->post->sq->tw_title) ?>">

                                                                        <div class="sq-col-sm-12 sq-px-0">
                                                                            <div class="sq-text-right sq-small">
                                                                                <span class="sq_length" data-maxlength="<?php echo (int)$view->post->sq_adm->tw_title_maxlength ?>"><?php echo strlen($view->post->sq_adm->tw_title) ?>/<?php echo (int)$view->post->sq_adm->tw_title_maxlength ?></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="sq-actions">
                                                                            <div class="sq-action">
                                                                                <span style="display: none" class="sq-value sq-title-value" data-value="<?php echo esc_attr($view->post->sq->tw_title) ?>"></span>
                                                                                <span class="sq-action-title" title="<?php echo esc_attr($view->post->sq->tw_title) ?>"><?php echo esc_html__("Current Title", _SQ_PLUGIN_NAME_) ?>: <span class="sq-title-value"><?php echo esc_html($view->post->sq->tw_title) ?></span></span>
                                                                            </div>
                                                                            <?php if (isset($view->post->post_title) && $view->post->post_title <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->post_title) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->post_title) ?>"><?php echo esc_html__("Default Title", _SQ_PLUGIN_NAME_) ?>: <span><?php echo esc_html($view->post->post_title) ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($view->post->sq_adm->patterns->title <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->sq_adm->patterns->title) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->sq_adm->patterns->title) ?>"><?php echo($loadpatterns ? esc_html__("Pattern", _SQ_PLUGIN_NAME_) . ': ' . '<span>' . esc_html($view->post->sq_adm->patterns->title) . '</span>' : '') ?></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Description", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php sprintf(esc_html__("Tips: Length %s-%s chars", _SQ_PLUGIN_NAME_), 10, $view->post->sq_adm->og_description_maxlength); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg <?php echo($loadpatterns ? 'sq_pattern_field' : '') ?>" data-patternid="<?php echo esc_attr($view->post->hash) ?>">
                                                                        <textarea autocomplete="off" rows="3" name="sq_tw_description" class="sq-form-control sq-input-lg sq-toggle" placeholder="<?php echo($loadpatterns ? esc_html__("Pattern", _SQ_PLUGIN_NAME_) . ': ' . esc_attr($view->post->sq_adm->patterns->description) : esc_attr($view->post->sq->tw_description)) ?>"><?php echo SQ_Classes_Helpers_Sanitize::clearDescription($view->post->sq_adm->tw_description) ?></textarea>
                                                                        <input type="hidden" id="sq_description_preview_<?php echo esc_attr($view->post->hash) ?>" name="sq_description_preview" value="<?php echo esc_attr($view->post->sq->tw_description) ?>">

                                                                        <div class="sq-col-sm-12 sq-px-0">
                                                                            <div class="sq-text-right sq-small">
                                                                                <span class="sq_length" data-maxlength="<?php echo (int)$view->post->sq_adm->tw_description_maxlength ?>"><?php echo strlen($view->post->sq_adm->tw_description) ?>/<?php echo (int)$view->post->sq_adm->tw_description_maxlength ?></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="sq-actions">
                                                                            <?php if (isset($view->post->sq->tw_description) && $view->post->sq->tw_description <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value sq-description-value" data-value="<?php echo esc_attr($view->post->sq->tw_description) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->sq->tw_description) ?>"><?php echo esc_html__("Current Description", _SQ_PLUGIN_NAME_) ?>: <span><?php echo esc_html($view->post->sq->tw_description) ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if (isset($view->post->post_excerpt) && $view->post->post_excerpt <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->post_excerpt) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->post_excerpt) ?>"><?php echo esc_html__("Default Description", _SQ_PLUGIN_NAME_) ?>: <span><?php echo esc_html($view->post->post_excerpt) ?></span></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                            <?php if ($view->post->sq_adm->patterns->description <> '') { ?>
                                                                                <div class="sq-action">
                                                                                    <span style="display: none" class="sq-value" data-value="<?php echo esc_attr($view->post->sq_adm->patterns->description) ?>"></span>
                                                                                    <span class="sq-action-title" title="<?php echo esc_attr($view->post->sq_adm->patterns->description) ?>"><?php echo($loadpatterns ? esc_html__("Pattern", _SQ_PLUGIN_NAME_) . ': ' . '<span>' . esc_html($view->post->sq_adm->patterns->description) . '</span>' : '') ?></span>
                                                                                </div>
                                                                            <?php } ?>

                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>


                                                            <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                                <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0">
                                                                    <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                        <?php echo esc_html__("Card Type", _SQ_PLUGIN_NAME_); ?>:
                                                                        <div class="sq-small sq-text-black-50 sq-my-1"><?php echo sprintf(esc_html__("Every change needs %sTwitter Card Validator%s", _SQ_PLUGIN_NAME_), '<br /><a href="https://cards-dev.twitter.com/validator?url=' . esc_url($view->post->url) . '" target="_blank" ><strong>', '</strong></a>'); ?></div>
                                                                    </div>
                                                                    <div class="sq-col-sm-6 sq-p-0 sq-input-group">
                                                                        <select name="sq_tw_type" class="sq-form-control sq-bg-input sq-mb-1">
                                                                            <option <?php echo(($view->post->sq_adm->tw_type == '') ? 'selected="selected"' : '') ?> value=""><?php echo esc_html__("(Auto)", _SQ_PLUGIN_NAME_) ?></option>
                                                                            <option <?php echo(($view->post->sq_adm->tw_type == 'summary') ? 'selected="selected"' : '') ?> value="summary"><?php echo esc_html__("summary", _SQ_PLUGIN_NAME_) ?></option>
                                                                            <option <?php echo(($view->post->sq_adm->tw_type == 'summary_large_image') ? 'selected="selected"' : '') ?> value="summary_large_image"><?php echo esc_html__("summary_large_image", _SQ_PLUGIN_NAME_) ?></option>

                                                                        </select>
                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sq-card-footer sq-py-0 sq-my-0 <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-mt-5' : ''; ?>">
                                                <div class="sq-row">
                                                    <div class="sq-text-center sq-col-sm-12 sq-my-4 sq-mx-0 sq-px-0 sq-text-danger" style="font-size: 18px; <?php echo ($view->post->sq_adm->doseo == 1) ? 'display: none' : ''; ?>">
                                                        <?php echo esc_html__("To edit the snippet, you have to activate Squirrly SEO for this page first", _SQ_PLUGIN_NAME_) ?>
                                                    </div>
                                                </div>
                                                <div class="sq-row">
                                                    <div class="sq-col-sm-12 sq-text-right sq-small sq-py-3 sq-px-2 sq-font-italic sq-text-black-50">
                                                        <?php echo esc_html__("Post Type", _SQ_PLUGIN_NAME_) ?>:
                                                        <strong><?php echo (string)$view->post->post_type ?></strong> |
                                                        <?php echo esc_html__("Twitter Type", _SQ_PLUGIN_NAME_) ?>:
                                                        <strong><?php echo($view->post->sq_adm->tw_type <> '' ? (string)$view->post->sq_adm->tw_type : (string)$socials->twitter_card_type) ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div id="sqtab<?php echo esc_attr($view->post->hash) ?>6" class="sq-tab-pane" role="tabpanel">
                                    <div class="sq-card sq-border-0">
                                        <?php if (get_option('blog_public') == 0) { ?>
                                            <div class="sq-row">
                                                <div class="sq-text-center sq-col-sm-12 sq-my-5 sq-mx-0 sq-px-0 sq-text-danger">
                                                    <?php echo sprintf(esc_html__("You selected '%s' in %sSettings > Reading%s. It's important to uncheck that option.", _SQ_PLUGIN_NAME_), esc_html__("Discourage search engines from indexing this site"), '<a href="' . admin_url('options-reading.php') . '" target="_blank"><strong>', '</strong></a>') ?>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="sq-card-body sq_tab_visibility sq_tabcontent <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-d-none' : ''; ?>">

                                                <div class="sq-row">
                                                    <div class="sq-col-sm  sq-border-bottom sq-text-right sq-mb-2 sq-pb-2">
                                                        <input type="button" class="sq_snippet_btn_refresh sq-btn sq-btn-sm sq-btn-warning sq-px-3 sq-rounded-0" value="<?php echo esc_html__("Refresh", _SQ_PLUGIN_NAME_) ?>"/>
                                                        <input type="button" class="sq_snippet_btn_save sq-btn sq-btn-sm sq-btn-primary sq-px-5 sq-rounded-0" value="<?php echo esc_html__("Save") ?>"/>
                                                    </div>
                                                </div>

                                                <div class="sq-row">


                                                    <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                        <?php if (isset($patterns[$view->post->post_type]['noindex']) && $patterns[$view->post->post_type]['noindex']) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                                    <?php echo sprintf(esc_html__("This Post Type (%s) has Nofollow set in Automation. See %sSquirrly > SEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), $view->post->post_type, '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?>
                                                                </div>
                                                            </div>
                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                    <input type="hidden" id="activate_sq_auto_noindex" value="1"/>
                                                                    <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_noindex" data-action="sq_ajax_seosettings_save" data-name="sq_auto_noindex"><?php echo esc_html__("Activate Robots Meta", _SQ_PLUGIN_NAME_); ?></button>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex') || $patterns[$view->post->post_type]['noindex']) ? 'sq_deactivated' : ''); ?>">
                                                            <div class="sq-col-sm-12 sq-row sq-my-0 sq-mx-0 sq-px-0">


                                                                <div class="sq-checker sq-col-sm-12 sq-row sq-my-2 sq-py-1 sq-px-4">
                                                                    <div class="sq-col-sm-12 sq-p-0 sq-switch redgreen sq-switch-sm">
                                                                        <input type="checkbox" id="sq_noindex_<?php echo esc_attr($view->post->hash) ?>" name="sq_noindex" class="sq-switch" <?php echo ($view->post->sq_adm->noindex == 0) ? 'checked="checked"' : ''; ?> value="0"/>
                                                                        <label for="sq_noindex_<?php echo esc_attr($view->post->hash) ?>" class="sq-ml-2"><?php echo esc_html__("Let Google Index This Page", _SQ_PLUGIN_NAME_); ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">

                                                        <?php if (isset($patterns[$view->post->post_type]['nofollow']) && $patterns[$view->post->post_type]['nofollow']) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                                    <?php echo sprintf(esc_html__("This Post Type (%s) has Nofollow set in Automation. See %sSquirrly > SEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), $view->post->post_type, '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?>
                                                                </div>
                                                            </div>
                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex')) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                    <input type="hidden" id="activate_sq_auto_noindex" value="1"/>
                                                                    <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_noindex" data-action="sq_ajax_seosettings_save" data-name="sq_auto_noindex"><?php echo esc_html__("Activate Robots Meta", _SQ_PLUGIN_NAME_); ?></button>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_noindex') || $patterns[$view->post->post_type]['nofollow']) ? 'sq_deactivated' : ''); ?>">
                                                            <div class="sq-col-sm-12 sq-row sq-my-0 sq-mx-0 sq-px-0">


                                                                <div class="sq-checker sq-col-sm-12 sq-row sq-my-2 sq-py-1 sq-px-4">
                                                                    <div class="sq-col-sm-12 sq-p-0 sq-switch redgreen sq-switch-sm">
                                                                        <input type="checkbox" id="sq_nofollow_<?php echo esc_attr($view->post->hash) ?>" name="sq_nofollow" class="sq-switch" <?php echo ($view->post->sq_adm->nofollow == 0) ? 'checked="checked"' : ''; ?> value="0"/>
                                                                        <label for="sq_nofollow_<?php echo esc_attr($view->post->hash) ?>" class="sq-ml-2"><?php echo esc_html__("Send Authority to this page", _SQ_PLUGIN_NAME_); ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="sq-col-sm-12 sq-row sq-mx-0 sq-px-0 sq-my-1 sq-py-1">
                                                        <?php if (!$view->post->sq->do_sitemap) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-center">
                                                                    <?php echo sprintf(esc_html__("Show in sitemap for this Post Type (%s) was excluded from %sSquirrly > SEO Settings > Automation%s.", _SQ_PLUGIN_NAME_), $view->post->post_type, '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '#tab=nav-' . $view->post->post_type . '" target="_blank"><strong>', '</strong></a>') ?>
                                                                </div>
                                                            </div>
                                                        <?php } elseif (!SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap')) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                    <input type="hidden" id="activate_sq_auto_sitemap" value="1"/>
                                                                    <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_sitemap" data-action="sq_ajax_seosettings_save" data-name="sq_auto_sitemap"><?php echo esc_html__("Activate Sitemap", _SQ_PLUGIN_NAME_); ?></button>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_sitemap') || !$view->post->sq->do_sitemap) ? 'sq_deactivated' : ''); ?>">
                                                            <div class="sq-col-sm-12 sq-row sq-my-0 sq-mx-0 sq-px-0">

                                                                <div class="sq-checker sq-col-sm-12 sq-row sq-my-2 sq-py-1 sq-px-4">
                                                                    <div class="sq-col-sm-12 sq-p-0 sq-switch redgreen sq-switch-sm">
                                                                        <input type="checkbox" id="sq_nositemap_<?php echo esc_attr($view->post->hash) ?>" name="sq_nositemap" class="sq-switch" <?php echo ($view->post->sq_adm->nositemap == 0) ? 'checked="checked"' : ''; ?> value="0"/>
                                                                        <label for="sq_nositemap_<?php echo esc_attr($view->post->hash) ?>" class="sq-ml-2"><?php echo esc_html__("Show it in Sitemap.xml", _SQ_PLUGIN_NAME_); ?></label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="sq-col-sm-12 sq-border-top sq-row sq-mx-0 sq-px-0 sq-my-3 sq-py-4">
                                                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_redirects')) { ?>
                                                            <div class="sq_deactivated_label sq-col-sm-12 sq-row sq-m-0 sq-p-2 sq-pr-3 sq_save_ajax">
                                                                <div class="sq-col-sm-12 sq-p-0 sq-text-right">
                                                                    <input type="hidden" id="activate_sq_auto_redirects" value="1"/>
                                                                    <button type="button" class="sq-btn sq-btn-link sq-text-danger sq-btn-sm" data-input="activate_sq_auto_redirects" data-action="sq_ajax_seosettings_save" data-name="sq_auto_redirects"><?php echo esc_html__("Activate Redirects", _SQ_PLUGIN_NAME_); ?></button>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="sq-col-sm-12 sq-row sq-py-0 sq-px-0 sq-input-group sq-m-0 <?php echo((!SQ_Classes_Helpers_Tools::getOption('sq_auto_redirects')) ? 'sq_deactivated' : ''); ?>">
                                                            <div class="sq-col-sm-3 sq-p-0 sq-pr-3 sq-font-weight-bold">
                                                                <?php echo esc_html__("301 Redirect", _SQ_PLUGIN_NAME_); ?>:
                                                                <div class="sq-small sq-text-black-50 sq-my-1"><?php echo esc_html__("Leave it blank if you don't want to add a 301 redirect to another URL", _SQ_PLUGIN_NAME_); ?></div>
                                                            </div>
                                                            <div class="sq-col-sm-9 sq-p-0 sq-input-group sq-input-group-lg">
                                                                <input type="text" autocomplete="off" name="sq_redirect" class="sq-form-control sq-input-lg sq-toggle" value="<?php echo urldecode($view->post->sq_adm->redirect) ?>"/>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="sq-card-footer sq-py-0 sq-my-0 <?php echo ($view->post->sq_adm->doseo == 0) ? 'sq-mt-5' : ''; ?>">
                                                <div class="sq-row">
                                                    <div class="sq-text-center sq-col-sm-12 sq-my-4 sq-mx-0 sq-px-0 sq-text-danger" style="font-size: 18px; <?php echo ($view->post->sq_adm->doseo == 1) ? 'display: none' : ''; ?>">
                                                        <?php echo esc_html__("To edit the snippet, you have to activate Squirrly SEO for this page first", _SQ_PLUGIN_NAME_) ?>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- ================ End Tabs ================= -->
                            </div>


                        </div>

                    </div>
                </div>
                <?php
            } else { ?>

                <div class="sq_snippet_wrap sq-card sq-col-sm-12 sq-p-0 sq-m-0 sq-border-0">
                    <div class="sq-card-body sq-p-0">
                        <div class="sq-close sq-close-absolute sq-m-2">x</div>
                        <div class="sq-col-sm-12 sq-m-4 sq-text-center sq-text-black-50">
                            <?php echo esc_html__("Loading Squirrly Snippet ...", _SQ_PLUGIN_NAME_) ?>
                        </div>
                    </div>
                </div>

                <?php
            }
        } else { ?>

            <div class="sq_snippet_wrap sq-card sq-col-sm-12 sq-p-0 sq-m-0 sq-border-0">
                <div class="sq-card-body sq-p-0">
                    <div class="sq-close sq-close-absolute sq-m-2">x</div>
                    <div class="sq-col-sm-12 sq-m-4 sq-text-center sq-text-black-50">

                    </div>
                </div>
            </div>

            <?php
        }
    } else {
        ?>
        <div class="sq_snippet_wrap sq-card sq-col-sm-12 sq-p-0 sq-m-0 sq-border-0">
            <div class="sq-card-body sq-p-0">
                <div class="sq-close sq-close-absolute sq-m-2">x</div>
                <div class="sq-col-sm-12 sq-m-4 sq-text-center sq-text-danger">
                    <?php echo esc_html__("Enable Squirrly SEO to load Squirrly Snippet", _SQ_PLUGIN_NAME_) ?>
                </div>
            </div>
        </div>
        <?php
    }
 ?>
<script>
    var __sq_save_message = "<?php echo esc_html__("Saved!", _SQ_PLUGIN_NAME_) ?>";
    var __sq_error_message = "<?php echo esc_html__("Couldn't save your changes. Immunify360 or some other service on your web hosting account interferes with your WordPress. Please contact the hosting provider`s support team", _SQ_PLUGIN_NAME_) ?>";
</script>