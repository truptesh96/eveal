<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php $patterns = SQ_Classes_Helpers_Tools::getOption('patterns'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row flex-nowrap my-0 bg-nav" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_focuspages')) {
            echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_) . '</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'boost'), 'sq_audits'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons_content p-3 py-4">
                            <div class="sq_icons sq_addpage_icon m-2"></div>
                        </div>
                        <h3 class="card-title"><?php echo esc_html__("Add a page in Audit", _SQ_PLUGIN_NAME_); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto.squirrly.co/kb/seo-audit/#add_new_audit_page" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                            </div>
                        </h3>
                        <div class="card-title-description m-2"><?php echo esc_html__("Verifies the online presence of your website by knowing how your website is performing in terms of Blogging, SEO, Social, Authority, Links, and Traffic", _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_auditpage" class="card col-12 p-0 tab-panel border-0">
                        <div class="row px-3">
                            <form id="sq_auditpage_form" method="get" class="form-inline col-12 ignore">
                                <input type="hidden" name="page" value="<?php echo SQ_Classes_Helpers_Tools::getValue('page') ?>">
                                <input type="hidden" name="tab" value="<?php echo SQ_Classes_Helpers_Tools::getValue('tab') ?>">
                                <div class="sq_filter_label col-12 row p-2">
                                    <?php if (isset($view->labels) && !empty($view->labels)) {
                                        $keyword_labels = SQ_Classes_Helpers_Tools::getValue('slabel', array());
                                        foreach ($view->labels as $category => $label) {
                                            if ($label->show) {
                                                $category = sanitize_html_class($category);
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

                                        <select name="stype" class="d-inline-block m-0 p-1" onchange="jQuery('form#sq_auditpage_form').submit();">
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
                                                <option <?php echo(($pattern == SQ_Classes_Helpers_Tools::getValue('stype', 'post')) ? 'selected="selected"' : '') ?> value="<?php echo esc_attr($pattern) ?>"><?php echo ucwords(str_replace(array('-', '_'), ' ', esc_html($pattern))); ?></option>
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
                                                    <select name="sstatus" class="d-inline-block m-0 p-1" onchange="jQuery('form#sq_auditpage_form').submit();">
                                                        <option <?php echo((!SQ_Classes_Helpers_Tools::getValue('sstatus', false)) ? 'selected="selected"' : '') ?> value="all"><?php echo esc_html__("Any status", _SQ_PLUGIN_NAME_); ?></option>
                                                        <?php

                                                        $statuses = array('draft', 'publish', 'pending', 'future', 'private');
                                                        foreach ($statuses as $status) { ?>
                                                            <option <?php echo(($status == SQ_Classes_Helpers_Tools::getValue('sstatus', 'publish')) ? 'selected="selected"' : '') ?> value="<?php echo esc_attr($status) ?>"><?php echo ucfirst(esc_html($status)); ?></option>
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
                                            <input type="search" class="d-inline-block align-middle col-7 p-1 mr-1" id="post-search-input" autofocus name="skeyword" value="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword(SQ_Classes_Helpers_Tools::getValue('skeyword')) ?>"/>
                                            <input type="submit" class="btn btn-primary" value="<?php echo esc_html__("Search", _SQ_PLUGIN_NAME_) ?>"/>
                                            <?php if ((SQ_Classes_Helpers_Tools::getIsset('skeyword') && SQ_Classes_Helpers_Tools::getValue('skeyword') <> '#all') || SQ_Classes_Helpers_Tools::getIsset('slabel') || SQ_Classes_Helpers_Tools::getIsset('sid') || SQ_Classes_Helpers_Tools::getIsset('sstatus')) { ?>
                                                <button type="button" class="btn btn-info ml-1 p-v-xs" onclick="location.href = '<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'addpage', array('stype=' . SQ_Classes_Helpers_Tools::getValue('stype', 'post') ))  ?>';" style="cursor: pointer"><?php echo esc_html__("Show All", _SQ_PLUGIN_NAME_) ?></button>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <?php if (!empty($view->pages)) { ?>
                            <div class="card-body p-0 position-relative">
                                <div class="col-12 m-0 p-2">
                                    <div class="card col-12 my-1 p-0 border-0 " style="display: inline-block;">

                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th><?php echo esc_html__("Title", _SQ_PLUGIN_NAME_) ?></th>
                                                <th><?php echo esc_html__("Option", _SQ_PLUGIN_NAME_) ?></th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($view->pages as $index => $post) {

                                                if (!$post instanceof SQ_Models_Domain_Post) {
                                                    continue;
                                                }

                                                $active = false;
                                                if (!empty($view->auditpage)) {
                                                    foreach ($view->auditpage as $auditpage) {
                                                        if(isset($auditpage->hash)) {
                                                            if ($auditpage->hash == $post->hash) {
                                                                $active = true;
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="col-12 px-0 mx-0 font-weight-bold" style="font-size: 15px"><?php echo wp_kses_post($post->sq->title) ?></div>
                                                        <div class="small " style="font-size: 11px"><?php echo '<a href="' . $post->url . '" class="text-link" rel="permalink" target="_blank">' . urldecode($post->url) . '</a>' ?></div>
                                                    </td>
                                                    <td style="width: 140px; text-align: center; vertical-align: middle">
                                                        <?php if (!$active) { ?>
                                                            <form method="post" class="p-0 m-0">
                                                                <?php SQ_Classes_Helpers_Tools::setNonce('sq_audits_addnew', 'sq_nonce'); ?>
                                                                <input type="hidden" name="action" value="sq_audits_addnew"/>

                                                                <input type="hidden" name="url" value="<?php echo esc_url($post->url); ?>">
                                                                <input type="hidden" name="post_id" value="<?php echo (int)$post->ID; ?>">
                                                                <input type="hidden" name="type" value="<?php echo esc_attr($post->post_type); ?>">
                                                                <input type="hidden" name="term_id" value="<?php echo (int)$post->term_id; ?>">
                                                                <input type="hidden" name="taxonomy" value="<?php echo esc_attr($post->taxonomy); ?>">
                                                                <input type="hidden" name="hash" value="<?php echo esc_attr($post->hash); ?>">

                                                                <button type="submit" class="btn btn-sm text-white btn-success">
                                                                    <?php echo esc_html__("Add Page to Audit", _SQ_PLUGIN_NAME_) ?>
                                                                </button>
                                                            </form>
                                                        <?php } else { ?>
                                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'audits') ?>" class="btn btn-sm text-white bg-success bg-green text-center" style="width: 150px;"><?php echo esc_html__("See Audits", _SQ_PLUGIN_NAME_) ?></a>
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
                        <?php } else { ?>
                            <div class="card-body">
                                <h4 class="text-center"><?php echo esc_html__("No page found. Try other post types.", _SQ_PLUGIN_NAME_); ?></h4>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="sq_col sq_col_side ">
                <div class="card col-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php //echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
