<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php SQ_Classes_ObjController::getClass('SQ_Controllers_Snippet')->init(); ?>
    <?php SQ_Classes_ObjController::getClass('SQ_Controllers_Patterns')->init(); ?>
    <?php $patterns = SQ_Classes_Helpers_Tools::getOption('patterns'); ?>
    <?php do_action('sq_notices'); ?>


    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_snippet')) {
            echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_) . '</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'bulkseo'), 'sq_bulkseo'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons_content p-3 py-4">
                            <div class="sq_icons sq_bulkseo_icon m-2"></div>
                        </div>
                        <h3 class="card-title"><?php echo esc_html__("Bulk SEO", _SQ_PLUGIN_NAME_); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto.squirrly.co/kb/bulk-seo/" target="_blank"><i class="fa fa-question-circle"></i></a>
                            </div>
                        </h3>
                        <div class="card-title-description m-2"><?php echo esc_html__("Simplify the SEO process for all your post type and optimize them in just minutes.", _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_seosettings_bulkseo" class="card col-12 p-0 tab-panel border-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="row px-2">
                            <form id="sq_bulkseo_form" method="get" class="form-inline col-12 ignore">
                                <input type="hidden" name="page" value="<?php echo SQ_Classes_Helpers_Tools::getValue('page') ?>">
                                <input type="hidden" name="tab" value="<?php echo SQ_Classes_Helpers_Tools::getValue('tab') ?>">
                                <div class="sq_filter_label col-12 row p-2">
                                    <?php if (isset($view->labels) && !empty($view->labels)) {
                                        $keyword_labels = SQ_Classes_Helpers_Tools::getValue('slabel', array());
                                        foreach ($view->labels as $category => $label) {
                                            if ($label->show) {
                                                ?>
                                                <input type="checkbox" name="slabel[]" onclick="jQuery('input[type=submit]').trigger('click');" id="search_checkbox_<?php echo esc_attr($category) ?>" style="display: none;" value="<?php echo esc_attr($category) ?>" <?php echo(in_array((string)$category, (array)$keyword_labels) ? 'checked' : '') ?> />
                                                <label for="search_checkbox_<?php echo esc_attr($category) ?>" class="sq_circle_label fa <?php echo(in_array((string)$category, (array)$keyword_labels) ? 'sq_active' : '') ?>" data-id="<?php echo esc_attr($category) ?>" style="background-color: <?php echo esc_attr($label->color) ?>" title="<?php echo esc_attr($label->name) ?>"><?php echo esc_html($label->name) ?></label>
                                                <?php
                                            }
                                        }
                                    } ?>
                                </div>

                                <div class="col-12 row px-0 mx-0">

                                    <div class="col-5 py-2 pl-0 pr-1 mx-0">

                                        <select name="stype" class="d-inline-block m-0 p-1" onchange="jQuery('form#sq_bulkseo_form').submit();">
                                            <?php
                                            foreach ($patterns as $pattern => $type) {
                                                if (in_array($pattern, array('custom', 'tax-category', 'search', 'archive', '404'))) continue;
                                                if (strpos($pattern, 'product') !== false || strpos($pattern, 'shop') !== false) {
                                                    if (!SQ_Classes_Helpers_Tools::isEcommerce()) continue;
                                                }

                                                ?>
                                                <option <?php echo(($pattern == SQ_Classes_Helpers_Tools::getValue('stype', 'post')) ? 'selected="selected"' : '') ?> value="<?php echo esc_attr($pattern) ?>"><?php echo ucwords(str_replace(array('-', '_'), ' ', esc_html($pattern))); ?></option>
                                                <?php
                                            }

                                            $filter = array('public' => true, '_builtin' => false);
                                            $types = get_post_types($filter);
                                            foreach ($types as $pattern => $type) {
                                                if (in_array($pattern, array_keys($patterns))) {
                                                    continue;
                                                }
                                                ?>
                                                <option <?php echo(($pattern == SQ_Classes_Helpers_Tools::getValue('stype', 'post')) ? 'selected="selected"' : '') ?> value="<?php echo esc_attr($pattern) ?>"><?php echo ucwords(str_replace(array('-', '_'), ' ', $pattern)); ?></option>
                                                <?php
                                            }

                                            $filter = array('public' => true,);
                                            $taxonomies = get_taxonomies($filter);
                                            foreach ($taxonomies as $pattern => $type) {
                                                //remove tax that are already included in patterns
                                                if (in_array($pattern, array('post_tag', 'post_format', 'product_cat', 'product_tag', 'product_shipping_class'))) continue;
                                                if (in_array($pattern, array_keys($patterns))) continue;
                                                ?>
                                                <option <?php echo(($pattern == SQ_Classes_Helpers_Tools::getValue('stype', 'post')) ? 'selected="selected"' : '') ?> value="<?php echo esc_attr($pattern) ?>"><?php echo ucwords(str_replace(array('-', '_'), ' ', esc_html($pattern))); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>

                                        <?php if (!empty($view->pages)) {
                                            foreach ($view->pages as $index => $post) {
                                                if (isset($post->ID)) {
                                                    ?>
                                                    <select name="sstatus" class="d-inline-block m-0 p-1" onchange="jQuery('form#sq_bulkseo_form').submit();">
                                                        <option <?php echo((!SQ_Classes_Helpers_Tools::getIsset('sstatus') || SQ_Classes_Helpers_Tools::getValue('sstatus', false) == '') ? 'selected="selected"' : 'all') ?> value=""><?php echo esc_html__("Any status", _SQ_PLUGIN_NAME_); ?></option>
                                                        <?php

                                                        $statuses = array('draft', 'publish', 'pending', 'future', 'private');
                                                        foreach ($statuses as $status) { ?>
                                                            <option <?php echo(($status == SQ_Classes_Helpers_Tools::getValue('sstatus', false)) ? 'selected="selected"' : '') ?> value="<?php echo esc_attr($status) ?>"><?php echo ucfirst(esc_html($status)); ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php
                                                    break;
                                                }
                                            }
                                        } ?>

                                    </div>
                                    <div class="col-7 p-0 py-2 mx-0">
                                        <div class="d-flex flex-row justify-content-end p-0 m-0">
                                            <input type="search" class="d-inline-block align-middle col-6 p-1 mr-1" id="post-search-input" autofocus name="skeyword" value="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword(SQ_Classes_Helpers_Tools::getValue('skeyword')) ?>"/>
                                            <input type="submit" class="btn btn-primary" value="<?php echo esc_html__("Search", _SQ_PLUGIN_NAME_) ?>"/>
                                            <?php if ((SQ_Classes_Helpers_Tools::getIsset('skeyword') && SQ_Classes_Helpers_Tools::getValue('skeyword') <> '#all') || SQ_Classes_Helpers_Tools::getIsset('slabel') || SQ_Classes_Helpers_Tools::getIsset('sid') || SQ_Classes_Helpers_Tools::getIsset('sstatus')) { ?>
                                                <button type="button" class="btn btn-info ml-1 p-v-xs" onclick="location.href = '<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo', array('stype=' . SQ_Classes_Helpers_Tools::getValue('stype', 'post'))) ?>';" style="cursor: pointer"><?php echo esc_html__("Show All", _SQ_PLUGIN_NAME_) ?></button>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <div class="card-body p-0 position-relative">
                            <?php
                            $post_type = SQ_Classes_Helpers_Tools::getValue('stype', 'post');
                            $categories = SQ_Classes_ObjController::getClass('SQ_Models_BulkSeo')->getCategories();
                            ?>
                            <div class="sq_overflow col-12 m-0 p-2 flexcroll">
                                <div class="card col-12 my-1 p-0 border-0 " style="display: inline-block;">

                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th><?php echo esc_html__("Title", _SQ_PLUGIN_NAME_) ?></th>
                                            <?php
                                            if (!empty($categories)) {
                                                foreach ($categories as $category_title) {
                                                    echo '<th>' . $category_title . '</th>';
                                                }
                                            }
                                            ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $loaded_posts = array();
                                        if (!empty($view->pages)) {
                                            foreach ($view->pages as $index => $post) {
                                                if (!$post) continue; //don't load post if errors
                                                if (in_array($post->hash, $loaded_posts)) continue; //don't load post for multiple times

                                                $can_edit_post = ($post->ID ? current_user_can('edit_post', $post->ID) : false);
                                                $can_edit_tax = ($post->term_id ? current_user_can('edit_term', $post->term_id) : false);
                                                if (!current_user_can('sq_manage_snippets') && !$can_edit_tax && !$can_edit_post) continue;
                                                ?>
                                                <tr id="sq_row_<?php echo esc_attr($post->hash) ?>" class="<?php echo((int)$index % 2 ? 'even' : 'odd') ?>">
                                                    <?php
                                                    $view->post = $post;
                                                    echo $view->getView('BulkSeo/BulkseoRow');
                                                    ?>
                                                </tr>

                                                <div id="sq_blocksnippet_<?php echo esc_attr($post->hash) ?>" data-snippet="backend" class="sq_blocksnippet shadow-sm border-bottom" style="display: none"><?php
                                                    SQ_Classes_ObjController::getClass('SQ_Controllers_Snippet')->setPost($post);
                                                    echo SQ_Classes_ObjController::getClass('SQ_Controllers_Snippet')->getView('Blocks/Snippet'); ?>
                                                </div>
                                                <?php
                                                $loaded_posts[] = $post->hash;
                                            }
                                        } else { ?>
                                            <tr id="sq_row" class="even">
                                                <td colspan="<?php echo(count((array)$categories) + 1) ?>" class="text-center">
                                                    <?php if ((SQ_Classes_Helpers_Tools::getIsset('skeyword') && SQ_Classes_Helpers_Tools::getValue('skeyword') <> '#all') || SQ_Classes_Helpers_Tools::getIsset('slabel') || SQ_Classes_Helpers_Tools::getIsset('sid') || SQ_Classes_Helpers_Tools::getIsset('sstatus')) { ?>
                                                        <?php echo sprintf(esc_html__("No data for this filter. %sShow All%s records for this post type.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo', array('stype=' . SQ_Classes_Helpers_Tools::getValue('stype', 'post'))) . '" >', '</a>') ?>
                                                    <?php } else { ?>
                                                        <?php echo esc_html__("No data found for this post type. Try other post types.", _SQ_PLUGIN_NAME_) ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="nav-previous alignleft"><?php the_posts_pagination(array(
                                            'mid_size' => 3,
                                            'base' => 'admin.php%_%',
                                            'format' => '?spage=%#%',
                                            'current' => SQ_Classes_Helpers_Tools::getValue('spage', 1),
                                            'prev_text' => esc_html__("Prev Page", _SQ_PLUGIN_NAME_),
                                            'next_text' => esc_html__("Next Page", _SQ_PLUGIN_NAME_),
                                        ));; ?></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sq_col_side sticky">
                <div class="card col-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <div class="sq_assistant">
                        <ul class="p-0 mx-5">
                            <li class="completed text-black-50 p-0 m-0">
                                <img src="<?php echo _SQ_ASSETS_URL_ . 'img/help/bs_steps.png' ?>" style="max-width: 100%">
                            </li>
                        </ul>
                    </div>
                    <?php
                    $loaded_posts = array();
                    if (!empty($view->pages)) {
                        foreach ($view->pages as $post) {
                            if (in_array($post->hash, $loaded_posts)) continue; //don't load post for multiple times
                            ?>
                            <div id="sq_assistant_<?php echo esc_attr($post->hash) ?>" class="sq_assistant">
                                <?php
                                $categories = apply_filters('sq_assistant_categories_page', $post->hash);

                                if (!empty($categories)) {
                                    foreach ($categories as $index => $category) {
                                        if (isset($category->assistant)) {
                                            echo (string)$category->assistant;
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <?php
                            $loaded_posts[] = $post->hash;

                        }
                    } ?>
                </div>
            </div>

        </div>
    </div>
</div>
