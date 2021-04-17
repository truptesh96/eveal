<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'briefcase'), 'sq_research'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons_content p-3 py-4">
                            <div class="sq_icons sq_briefcase_icon m-2"></div>
                        </div>
                        <h3 class="card-title"><?php echo esc_html__("Briefcase", _SQ_PLUGIN_NAME_); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase" target="_blank"><i class="fa fa-question-circle"></i></a>
                            </div>
                        </h3>
                        <div class="card-title-description m-2"><?php echo esc_html__("Briefcase is essential to managing your SEO Strategy. With Briefcase you'll find the best opportunities for keywords you're using in the Awareness Stage, Decision Stage and other stages you may plan for your Customer's Journey.", _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_briefcase" class="card col-12 p-0 tab-panel border-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <?php if (isset($view->keywords) && !empty($view->keywords)) { ?>
                            <div class="row px-3">
                                <form method="get" class="form-inline col-12">
                                    <input type="hidden" name="page" value="<?php echo SQ_Classes_Helpers_Tools::getValue('page') ?>">
                                    <input type="hidden" name="tab" value="<?php echo SQ_Classes_Helpers_Tools::getValue('tab') ?>">
                                    <div class="col-3 p-0">
                                        <h3 class="card-title text-dark p-2"><?php echo esc_html__("Labels", _SQ_PLUGIN_NAME_); ?></h3>
                                    </div>
                                    <div class="col-9 p-0 py-2">
                                        <div class="d-flex flex-row justify-content-end p-0 m-0">
                                            <input type="search" class="d-inline-block align-middle col-7 p-2 mr-2" id="post-search-input" autofocus name="skeyword" value="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword(SQ_Classes_Helpers_Tools::getValue('skeyword')) ?>"/>
                                            <input type="submit" class="btn btn-primary" value="<?php echo esc_html__("Search Keyword", _SQ_PLUGIN_NAME_) ?>"/>
                                            <?php if (SQ_Classes_Helpers_Tools::getIsset('skeyword') || SQ_Classes_Helpers_Tools::getIsset('slabel')) { ?>
                                                <button type="button" class="btn btn-info ml-1 p-v-xs" onclick="location.href = '<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') ?>';" style="cursor: pointer"><?php echo esc_html__("Show All", _SQ_PLUGIN_NAME_) ?></button>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="sq_filter_label p-2">
                                        <?php if (isset($view->labels) && !empty($view->labels)) {
                                            $keyword_labels = SQ_Classes_Helpers_Tools::getValue('slabel', array());
                                            foreach ($view->labels as $label) {
                                                ?>
                                                <input type="checkbox" name="slabel[]" onclick="form.submit();" id="search_checkbox_<?php echo (int)$label->id ?>" style="display: none;" value="<?php echo (int)$label->id ?>" <?php echo(in_array((int)$label->id, (array)$keyword_labels) ? 'checked' : '') ?> />
                                                <label for="search_checkbox_<?php echo (int)$label->id ?>" class="sq_circle_label fa <?php echo(in_array((int)$label->id, (array)$keyword_labels) ? 'sq_active' : '') ?>" data-id="<?php echo (int)$label->id ?>" style="background-color: <?php echo esc_attr($label->color) ?>" title="<?php echo esc_attr($label->name) ?>"><?php echo esc_html($label->name) ?></label>
                                                <?php

                                            }
                                        } ?>
                                    </div>
                                </form>
                            </div>
                        <?php }else{ ?>
                            <div class="row px-3">
                                <form method="get" class="form-inline col-12">
                                    <input type="hidden" name="page" value="<?php echo SQ_Classes_Helpers_Tools::getValue('page') ?>">
                                    <input type="hidden" name="tab" value="<?php echo SQ_Classes_Helpers_Tools::getValue('tab') ?>">
                                    <div class="col-12 p-0 py-2">
                                        <div class="d-flex flex-row justify-content-end p-0 m-0">
                                            <input type="search" class="d-inline-block align-middle col-5 p-2 mr-2" id="post-search-input" autofocus name="skeyword" value="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword(SQ_Classes_Helpers_Tools::getValue('skeyword')) ?>"/>
                                            <input type="submit" class="btn btn-primary" value="<?php echo esc_html__("Search Keyword", _SQ_PLUGIN_NAME_) ?>"/>
                                            <?php if (SQ_Classes_Helpers_Tools::getIsset('skeyword') || SQ_Classes_Helpers_Tools::getIsset('slabel')) { ?>
                                                <button type="button" class="btn btn-info ml-1 p-v-xs" onclick="location.href = '<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') ?>';" style="cursor: pointer"><?php echo esc_html__("Show All", _SQ_PLUGIN_NAME_) ?></button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                        <div class="card-body p-0">
                            <div class="col-12 m-0 p-0">

                                <div class="col-12 my-4 mx-0 p-0 border-0">
                                    <?php if (isset($view->keywords) && !empty($view->keywords)) { ?>
                                        <div class="col-5 p-1">
                                            <select name="sq_bulk_action" class="sq_bulk_action">
                                                <option value=""><?php echo esc_html__("Bulk Actions", _SQ_PLUGIN_NAME_) ?></option>
                                                <option value="sq_ajax_briefcase_bulk_doserp"><?php echo esc_html__("Send to Rankings", _SQ_PLUGIN_NAME_); ?></option>
                                                <option value="sq_ajax_briefcase_bulk_label"><?php echo esc_html__("Assign Label", _SQ_PLUGIN_NAME_); ?></option>
                                                <option value="sq_ajax_briefcase_bulk_delete" data-confirm="<?php echo esc_html__("Ar you sure you want to delete the keywords?", _SQ_PLUGIN_NAME_) ?>"><?php echo esc_html__("Delete") ?></option>
                                            </select>
                                            <button class="sq_bulk_submit btn btn-sm btn-success"><?php echo esc_html__("Apply"); ?></button>

                                            <div id="sq_label_manage_popup_bulk" tabindex="-1" class="sq_label_manage_popup modal" role="dialog">
                                                <div class="modal-dialog" style="width: 600px;">
                                                    <div class="modal-content bg-light">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><?php echo sprintf(esc_html__("Select Labels for: %s", _SQ_PLUGIN_NAME_), esc_html__("selected keywords", _SQ_PLUGIN_NAME_)); ?></h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body" style="min-height: 50px; display: table; margin: 10px 20px 10px 20px;">
                                                            <div class="pb-2 mx-2 small text-black-50"><?php echo esc_html__("By assigning these labels, you will reset the other labels you assigned for each keyword individually.", _SQ_PLUGIN_NAME_); ?></div>
                                                            <?php if (isset($view->labels) && !empty($view->labels)) {
                                                                foreach ($view->labels as $label) {
                                                                    ?>
                                                                    <input type="checkbox" name="sq_labels[]" class="sq_bulk_labels" id="popup_checkbox_bulk_<?php echo (int)$label->id ?>" style="display: none;" value="<?php echo (int)$label->id ?>"/>
                                                                    <label for="popup_checkbox_bulk_<?php echo (int)$label->id ?>" class="sq_checkbox_label fa" style="background-color: <?php echo esc_attr($label->color) ?>" title="<?php echo esc_attr($label->name) ?>"><?php echo esc_html($label->name) ?></label>
                                                                    <?php
                                                                }
                                                            } else { ?>
                                                                <a class="btn btn-warning" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'labels') ?>"><?php echo esc_html__("Add new Label", _SQ_PLUGIN_NAME_); ?></a>
                                                            <?php } ?>
                                                        </div>
                                                        <?php if (isset($view->labels) && !empty($view->labels)) { ?>
                                                            <div class="modal-footer">
                                                                <button class="sq_bulk_submit btn-modal btn btn-success"><?php echo esc_html__("Save Labels", _SQ_PLUGIN_NAME_); ?></button>
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="p-1">
                                            <table class="table table-striped table-hover mx-0 p-0 ">
                                                <thead>
                                                <tr>
                                                    <th style="width: 10px;"><input type="checkbox" class="sq_bulk_select_input" /></th>
                                                    <th><?php echo esc_html__("Keyword", _SQ_PLUGIN_NAME_) ?></th>
                                                    <th><?php echo esc_html__("Usage", _SQ_PLUGIN_NAME_) ?></th>
                                                    <th>
                                                        <?php
                                                        if ($view->checkin->subscription_serpcheck) {
                                                            echo esc_html__("Rank", _SQ_PLUGIN_NAME_);
                                                        } else {
                                                            echo esc_html__("Avg Rank", _SQ_PLUGIN_NAME_);
                                                        }
                                                        ?>
                                                    </th>
                                                    <th title="<?php echo esc_html__("Search Volume", _SQ_PLUGIN_NAME_) ?>"><?php echo esc_html__("SV", _SQ_PLUGIN_NAME_) ?></th>
                                                    <th><?php echo esc_html__("Research", _SQ_PLUGIN_NAME_) ?></th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($view->keywords as $key => $row) {
                                                    $row->rank = false;
                                                    if (!empty($view->rankkeywords)) {
                                                        foreach ($view->rankkeywords as $rankkeyword) {
                                                            if (strtolower($rankkeyword->keyword) == strtolower($row->keyword)) {
                                                                if ($view->checkin->subscription_serpcheck) {
                                                                    if ((int)$rankkeyword->rank > 0) {
                                                                        $row->rank = $rankkeyword->rank;
                                                                    }
                                                                } elseif ((int)$rankkeyword->average_position > 0) {
                                                                    $row->rank = $rankkeyword->average_position;
                                                                }
                                                            }
                                                        }
                                                    }

                                                    ?>
                                                    <tr id="sq_row_<?php echo (int)$row->id ?>">
                                                        <td style="width: 10px;">
                                                            <?php if (current_user_can('sq_manage_settings')) { ?>
                                                                <input type="checkbox" name="sq_edit[]" class="sq_bulk_input" value="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword) ?>"/>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!empty($row->labels)) {
                                                                foreach ($row->labels as $label) {
                                                                    ?>
                                                                    <span class="sq_circle_label fa" style="background-color: <?php echo esc_attr($label->color) ?>" data-id="<?php echo (int)$label->lid ?>" title="<?php echo esc_attr($label->name) ?>"></span>
                                                                    <?php
                                                                }
                                                            } ?>

                                                            <span style="display: block; clear: left; float: left;"><?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword) ?></span>
                                                        </td>
                                                        <td>
                                                            <?php if ($row->count > 0) { ?>
                                                                <span data-value="<?php echo (int)$row->count ?>"><a href="javascript:void(0);" onclick="jQuery('#sq_kr_posts<?php echo (int)$key ?>').modal('show')"><?php echo sprintf(esc_html__("in %s posts", _SQ_PLUGIN_NAME_), $row->count) ?></a></span>
                                                            <?php } else { ?>
                                                                <span data-value="<?php echo (int)$row->count ?>"><?php echo sprintf(esc_html__("in %s posts", _SQ_PLUGIN_NAME_), $row->count) ?></span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if (!$row->rank) { ?>
                                                                <?php if (isset($row->do_serp) && !$row->do_serp) { ?>
                                                                    <button class="sq_research_doserp btn btn-sm btn-link text-black-50 p-0 m-0 text-nowrap" data-value="999" data-success="<?php echo esc_html__("Check Rankings", _SQ_PLUGIN_NAME_) ?>" data-link="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'rankings', array('strict=1', 'skeyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword))) ?>" data-keyword="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword) ?>">
                                                                        <?php echo esc_html__("Send to Rankings", _SQ_PLUGIN_NAME_) ?>
                                                                    </button>
                                                                <?php } elseif ($view->checkin->subscription_serpcheck) { ?>
                                                                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'rankings', array('strict=1', 'skeyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword))) ?>" data-value="999" style="font-weight: bold;font-size: 15px;"><?php echo esc_html__("Not indexed", _SQ_PLUGIN_NAME_) ?></a>
                                                                <?php } else { ?>
                                                                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'rankings', array('strict=1', 'skeyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword))) ?>" data-value="999" style="font-weight: bold;font-size: 15px;"><?php echo esc_html__("GSC", _SQ_PLUGIN_NAME_) ?></a>
                                                                <?php } ?><?php } else { ?>
                                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'rankings', array('strict=1', 'skeyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword))) ?>" data-value="<?php echo (int)$row->rank ?>" target="_blank" style="font-weight: bold;font-size: 15px;"><?php echo (int)$row->rank ?></a>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if (isset($row->research->sv) && isset($row->research->sv->absolute)) {
                                                                echo '<span data-value="' . (int)$row->research->sv->absolute . '">' . ((isset($row->research->sv->absolute) && is_numeric($row->research->sv->absolute)) ? number_format($row->research->sv->absolute, 0, '.', ',') : $row->research->sv->absolute) . '</span>';
                                                            } else {
                                                                echo '<span data-value="0">' . "-" . '</span>';
                                                            } ?>
                                                        </td>
                                                        <td>
                                                            <?php if (isset($row->research->rank->value)) { ?>
                                                                <button data-value="<?php echo esc_attr($row->research->rank->value) ?>" onclick="jQuery('#sq_kr_research<?php echo (int)$key ?>').modal('show');" class="small btn btn-success btn-sm" style="cursor: pointer; width: 100px"><?php echo esc_html__("keyword info", _SQ_PLUGIN_NAME_) ?></button>
                                                                <div class="progress" style="max-width: 100px; max-height: 3px">
                                                                    <?php
                                                                    $progress_color = 'danger';
                                                                    switch ($row->research->rank->value) {
                                                                        case ($row->research->rank->value < 4):
                                                                            $progress_color = 'danger';
                                                                            break;
                                                                        case ($row->research->rank->value < 6):
                                                                            $progress_color = 'warning';
                                                                            break;
                                                                        case ($row->research->rank->value < 8):
                                                                            $progress_color = 'info';
                                                                            break;
                                                                        case ($row->research->rank->value <= 10):
                                                                            $progress_color = 'success';
                                                                            break;
                                                                    }
                                                                    ?>
                                                                    <div class="progress-bar bg-<?php echo esc_attr($progress_color); ?>" role="progressbar" style="width: <?php echo((int)$row->research->rank->value * 10) ?>%" aria-valuenow="<?php echo (int)$row->research->rank->value ?>" aria-valuemin="0" aria-valuemax="10"></div>
                                                                </div>
                                                            <?php } else { ?>
                                                                <button data-value="0" style="cursor: pointer;" class="btn btn-sm btn-default bg-transparent"><?php echo esc_html__("No research data", _SQ_PLUGIN_NAME_) ?></button>
                                                            <?php } ?>
                                                        </td>

                                                        <td class="px-0 py-2" style="width: 20px">
                                                            <div class="sq_sm_menu">
                                                                <div class="sm_icon_button sm_icon_options">
                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                </div>
                                                                <div class="sq_sm_dropdown">
                                                                    <ul class="p-2 m-0 text-left">
                                                                        <li class="sq_research_selectit border-bottom m-0 p-1 py-2 noloading">
                                                                            <?php $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('/post-new.php?keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword, 'url')); ?>
                                                                            <a href="<?php echo (string)$edit_link ?>" target="_blank" class="sq-nav-link">
                                                                                <i class="sq_icons_small sq_sla_icon"></i>
                                                                                <?php echo esc_html__("Optimize for this", _SQ_PLUGIN_NAME_) ?>
                                                                            </a>
                                                                        </li>
                                                                        <?php if (current_user_can('sq_manage_settings')) { ?>
                                                                            <?php if (isset($row->do_serp) && !$row->do_serp) { ?>
                                                                                <li class="sq_research_doserp border-bottom m-0 p-1 py-2" data-success="<?php echo esc_html__("Check Rankings", _SQ_PLUGIN_NAME_) ?>" data-link="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_rankings', 'rankings', array('strict=1', 'skeyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword))) ?>" data-keyword="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword) ?>">
                                                                                    <i class="sq_icons_small sq_ranks_icon"></i>
                                                                                    <span><?php echo esc_html__("Send to Rank Checker", _SQ_PLUGIN_NAME_) ?></span>
                                                                                </li>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                        <li class="border-bottom m-0 p-1 py-2">
                                                                            <i class="sq_icons_small sq_kr_icon"></i>
                                                                            <?php if ($row->research == '') { ?>
                                                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research', array('keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword, 'url'))) ?>" class="sq-nav-link"><?php echo esc_html__("Do a research", _SQ_PLUGIN_NAME_) ?></a>
                                                                            <?php } else { ?>
                                                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research', array('keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword, 'url'))) ?>" class="sq-nav-link"><?php echo esc_html__("Refresh Research", _SQ_PLUGIN_NAME_) ?></a>
                                                                            <?php } ?>
                                                                        </li>
                                                                        <li class="border-bottom m-0 p-1 py-2">
                                                                            <i class="sq_icons_small sq_labels_icon"></i>
                                                                            <span onclick="jQuery('#sq_label_manage_popup<?php echo (int)$key ?>').modal('show')"><?php echo esc_html__("Assign Label", _SQ_PLUGIN_NAME_); ?></span>
                                                                        </li>
                                                                        <?php if (current_user_can('sq_manage_settings')) { ?>
                                                                            <li class="sq_delete m-0 p-1 py-2" data-id="<?php echo (int)$row->id ?>" data-keyword="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword) ?>">
                                                                                <i class="sq_icons_small fa fa-trash-o"></i>
                                                                                <?php echo esc_html__("Delete Keyword", _SQ_PLUGIN_NAME_) ?>
                                                                            </li>
                                                                        <?php } ?>

                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                        <?php foreach ($view->keywords as $key => $row) { ?>

                                            <?php if ($row->count > 0 && isset($row->posts) && !empty($row->posts)) { ?>
                                                <div id="sq_kr_posts<?php echo (int)$key; ?>" tabindex="-1" class="sq_kr_posts modal" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content bg-light">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title"><?php echo esc_html__("Optimized with", _SQ_PLUGIN_NAME_); ?>:
                                                                    <strong><?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword) ?></strong>
                                                                    <span style="font-weight: bold; font-size: 110%"></span>
                                                                </h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body" style="min-height: 90px;">
                                                                <ul class="col-12" style="list-style: initial">
                                                                    <?php
                                                                    foreach ($row->posts as $post_id => $permalink) { ?>
                                                                        <li class="row py-2 border-bottom">
                                                                            <a href="<?php echo get_edit_post_link($post_id, false); ?>" target="_blank"><?php echo (string)$permalink ?></a>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div id="sq_kr_research<?php echo (int)$key; ?>" tabindex="-1" class="sq_kr_research modal" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content bg-light">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><?php echo esc_html__("Keyword", _SQ_PLUGIN_NAME_); ?>:
                                                                <strong><?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword) ?></strong>
                                                                <span style="font-weight: bold; font-size: 110%"></span>
                                                            </h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body" style="min-height: 90px;">
                                                            <ul class="col-12">
                                                                <?php if (!isset($row->country)) $row->country = ''; ?>
                                                                <li class="row py-3 border-bottom">
                                                                    <div class="col-4"><?php echo esc_html__("Country", _SQ_PLUGIN_NAME_) ?>:</div>
                                                                    <div class="col-6"><?php echo esc_html($row->country) ?></div>
                                                                </li>
                                                                <?php if (isset($row->research->sc)) { ?>
                                                                    <li class="row py-3 border-bottom">
                                                                        <div class="col-4"><?php echo esc_html__("Competition", _SQ_PLUGIN_NAME_) ?>:</div>
                                                                        <div class="col-6" style="color: <?php echo esc_attr($row->research->sc->color) ?>"><?php echo($row->research->sc->text <> '' ? esc_html($row->research->sc->text) : '-') ?></div>
                                                                    </li>
                                                                <?php } ?>
                                                                <?php if (isset($row->research->sv)) { ?>
                                                                    <li class="row py-3 border-bottom">
                                                                        <div class="col-4"><?php echo esc_html__("Search Volume", _SQ_PLUGIN_NAME_) ?>:</div>
                                                                        <div class="col-6"><?php echo((isset($row->research->sv->absolute) && is_numeric($row->research->sv->absolute)) ? number_format($row->research->sv->absolute, 0, '.', ',') : esc_attr($row->research->sv->absolute)) ?></div>
                                                                    </li>
                                                                <?php } ?>
                                                                <?php if (isset($row->research->tw)) { ?>
                                                                    <li class="row py-3 border-bottom">
                                                                        <div class="col-4"><?php echo esc_html__("Recent discussions", _SQ_PLUGIN_NAME_) ?>:</div>
                                                                        <div class="col-6"><?php echo($row->research->tw->text <> '' ? esc_html($row->research->tw->text) : '-') ?></div>
                                                                    </li>
                                                                <?php } ?>
                                                                <?php if (isset($row->research->td)) { ?>
                                                                    <li class="row py-3">
                                                                        <div class="col-4"><?php echo esc_html__("Trending", _SQ_PLUGIN_NAME_) ?>:</div>
                                                                        <div class="col-6">
                                                                            <?php if (isset($row->research->td->absolute) && is_array($row->research->td->absolute) && !empty($row->research->td->absolute)) {
                                                                                $last = 0.1;
                                                                                $datachar = [];
                                                                                foreach ($row->research->td->absolute as $td) {
                                                                                    if ((float)$td > 0) {
                                                                                        $datachar[] = $td;
                                                                                        $last = $td;
                                                                                    } else {
                                                                                        $datachar[] = $last;
                                                                                    }
                                                                                }
                                                                                if (!empty($datachar)) {
                                                                                    $row->research->td->absolute = array_splice($datachar, -7);
                                                                                }
                                                                            } else {
                                                                                $row->research->td->absolute = [0.1, 0.1, 0.1, 0.1, 0.1, 0.1, 0.1];
                                                                            }
                                                                            ?>
                                                                            <div style="width: 60px;height: 30px;">
                                                                                <canvas id="sq_trend<?php echo (int)$key; ?>" class="sq_trend" data-values="<?php echo join(',', (array)$row->research->td->absolute) ?>"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="sq_label_manage_popup<?php echo (int)$key ?>" tabindex="-1" class="sq_label_manage_popup modal" role="dialog">
                                                <div class="modal-dialog" style="width: 600px;">
                                                    <div class="modal-content bg-light">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"><?php echo sprintf(esc_html__("Select Labels for: %s", _SQ_PLUGIN_NAME_), '<strong style="font-size: 115%">' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword) . '</strong>'); ?></h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body" style="min-height: 50px; display: table; margin: 10px 20px 10px 20px;">
                                                            <?php if (isset($view->labels) && !empty($view->labels)) {

                                                                $keyword_labels = array();
                                                                if (!empty($row->labels)) {
                                                                    foreach ($row->labels as $label) {
                                                                        $keyword_labels[] = $label->lid;
                                                                    }
                                                                }

                                                                foreach ($view->labels as $label) {
                                                                    ?>
                                                                    <input type="checkbox" name="sq_labels" id="popup_checkbox_<?php echo (int)$key ?>_<?php echo (int)$label->id ?>" style="display: none;" value="<?php echo (int)$label->id ?>" <?php echo(in_array((int)$label->id, $keyword_labels) ? 'checked' : '') ?> />
                                                                    <label for="popup_checkbox_<?php echo (int)$key ?>_<?php echo (int)$label->id ?>" class="sq_checkbox_label fa <?php echo(in_array((int)$label->id, $keyword_labels) ? 'sq_active' : '') ?>" style="background-color: <?php echo esc_attr($label->color) ?>" title="<?php echo esc_attr($label->name) ?>"><?php echo esc_html($label->name) ?></label>
                                                                    <?php
                                                                }

                                                            } else { ?>

                                                                <a class="btn btn-warning" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'labels') ?>"><?php echo esc_html__("Add new Label", _SQ_PLUGIN_NAME_); ?></a>

                                                            <?php } ?>
                                                        </div>
                                                        <?php if (isset($view->labels) && !empty($view->labels)) { ?>
                                                            <div class="modal-footer">
                                                                <button data-keyword="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword) ?>" class="sq_save_keyword_labels btn btn-success"><?php echo esc_html__("Save Labels", _SQ_PLUGIN_NAME_); ?></button>
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                </div>

                                            </div>
                                        <?php } ?>
                                    <?php } elseif (SQ_Classes_Helpers_Tools::getIsset('skeyword') || SQ_Classes_Helpers_Tools::getIsset('slabel')) { ?>
                                        <div class="card-body">
                                            <h4 class="text-center"><?php echo $view->error; ?></h4>
                                        </div>
                                    <?php } else { ?>

                                        <div class="card-body">
                                            <h4 class="text-center"><?php echo esc_html__("Welcome to Squirrly Briefcase", _SQ_PLUGIN_NAME_); ?></h4>
                                            <div class="col-12 m-2 text-center">
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') ?>" class="btn btn-lg btn-primary">
                                                    <i class="fa fa-plus-square-o"></i> <?php echo esc_html__("Go Find New Keywords", _SQ_PLUGIN_NAME_); ?>
                                                </a>

                                                <div class="col-12 mt-5 mx-2">
                                                    <h5 class="text-left my-3 text-info"><?php echo esc_html__("Tips: How to add Keywords in Briefcase?", _SQ_PLUGIN_NAME_); ?></h5>
                                                    <ul>
                                                        <li class="text-left" style="font-size: 15px;"><?php echo sprintf(esc_html__("From %sKeyword Research%s send keywords to Briefcase.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') . '" >', '</a>'); ?></li>
                                                        <li class="text-left" style="font-size: 15px;"><?php echo sprintf(esc_html__("From Briefcase you can use the keywords in %sSquirrly Live Assistant%s to optimize your pages.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant', 'assistant') . '" >', '</a>'); ?></li>
                                                        <li class="text-left" style="font-size: 15px;"><?php echo esc_html__("If you already have a list of keywords, Import the keywords usign the below button.", _SQ_PLUGIN_NAME_); ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if (current_user_can('sq_manage_settings')) { ?>
                                        <div class="col-12 row py-2 mx-0 my-3 mt-4 pt-4 border-bottom-0 border-top">
                                            <div class="col-8 p-0 pr-3">
                                                <div class="font-weight-bold"><?php echo esc_html__("Backup/Restore Briefcase Keywords", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_backup_keywords" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                </div>
                                                <div class="small text-black-50"><?php echo esc_html__("Keep your briefcase keywords safe in case you change your domain or reinstall the plugin", _SQ_PLUGIN_NAME_); ?></div>
                                                <div class="small text-black-50"><?php echo sprintf(esc_html__("%sLearn how to import keywords into briefcase%s", _SQ_PLUGIN_NAME_), '<a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#briefcase_backup_keywords" target="_blank">', '</a>'); ?></div>
                                            </div>
                                            <div class="col-4 p-0 text-center">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_briefcase_backup', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_briefcase_backup"/>
                                                    <button type="submit" class="btn rounded-0 btn-success my-1 px-2 mx-2 noloading" style="min-width: 175px"><?php echo esc_html__("Download Keywords", _SQ_PLUGIN_NAME_); ?></button>
                                                </form>
                                                <div>
                                                    <button type="button" class="btn rounded-0 btn-success my-1 px-2 mx-2" style="min-width: 175px" onclick="jQuery('.sq_briefcase_restore_dialog').modal('show')" data-dismiss="modal"><?php echo esc_html__("Import Keywords", _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                                <div class="sq_briefcase_restore_dialog modal" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content bg-light">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title"><?php echo esc_html__("Restore Briefcase Keywords", _SQ_PLUGIN_NAME_); ?></h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form name="import" action="" method="post" enctype="multipart/form-data">
                                                                    <div class="col-12 row py-2 mx-0 my-3">
                                                                        <div class="col-4 p-0 pr-3">
                                                                            <div class="font-weight-bold"><?php echo esc_html__("Restore Keywords", _SQ_PLUGIN_NAME_); ?>:</div>
                                                                            <div class="small text-black-50"><?php echo esc_html__("Upload the file with the saved Squirrly Briefcase Keywords.", _SQ_PLUGIN_NAME_); ?></div>
                                                                        </div>
                                                                        <div class="col-8 p-0 input-group">
                                                                            <div class="col-8 form-group m-0 p-0 my-2">
                                                                                <input type="file" class="form-control-file" name="sq_upload_file">
                                                                            </div>
                                                                            <div class="col-4 form-group m-0 p-0 my-2">
                                                                                <?php SQ_Classes_Helpers_Tools::setNonce('sq_briefcase_restore', 'sq_nonce'); ?>
                                                                                <input type="hidden" name="action" value="sq_briefcase_restore"/>
                                                                                <button type="submit" class="btn rounded-0 btn-success btn-sm px-3 mx-2"><?php echo esc_html__("Upload", _SQ_PLUGIN_NAME_); ?></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sq_col_side sticky">
                <div class="card col-12 p-0">
                    <div class="card-body f-gray-dark p-0">
                        <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                        <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>