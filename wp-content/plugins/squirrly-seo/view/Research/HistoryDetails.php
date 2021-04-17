<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<td colspan="8">
    <div class="col-12 m-0 p-0">
        <div class="card col-12 my-4 p-0 px-0 border-0 ">
            <table class="table table-striped" cellpadding="0" cellspacing="0" border="0">
                <thead>
                <tr>
                    <th ><?php echo esc_html__("Keyword", _SQ_PLUGIN_NAME_) ?></th>
                    <th title="<?php echo esc_html__("Competition", _SQ_PLUGIN_NAME_) ?>">
                        <i class="fa fa-comments-o"></i>
                        <?php echo esc_html__("Competition", _SQ_PLUGIN_NAME_) ?>
                    </th>
                    <th title="<?php echo esc_html__("SEO Search Volume", _SQ_PLUGIN_NAME_) ?>">
                        <i class="fa fa-search"></i>
                        <?php echo esc_html__("SV", _SQ_PLUGIN_NAME_) ?>
                    </th>
                    <th title="<?php echo esc_html__("Recent discussions", _SQ_PLUGIN_NAME_) ?>">
                        <i class="fa fa-users"></i>
                        <?php echo esc_html__("Discussion", _SQ_PLUGIN_NAME_) ?>
                    </th>
                    <th title="<?php echo esc_html__("Trending", _SQ_PLUGIN_NAME_) ?>">
                        <i class="fa fa-bar-chart"></i>
                        <?php echo esc_html__("Trend", _SQ_PLUGIN_NAME_) ?>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($view->kr) && isset($view->kr->keyword)) {
                    $view->kr->keyword = explode(',', $view->kr->keyword);
                    $view->kr->data = json_decode($view->kr->data);
                    if (!empty($view->kr->data))
                        foreach ($view->kr->data as $nr => $row) {
                            $in_briefcase = false;
                            if (!empty($view->keywords))
                                foreach ($view->keywords as $krow) {
                                    if (trim(strtolower($krow->keyword)) == trim(strtolower($row->keyword))) {
                                        $in_briefcase = true;
                                        break;
                                    }
                                }
                            ?>
                            <tr class="<?php echo($in_briefcase ? 'bg-briefcase' : '') ?> " >
                                <td nowrap="nowrap" style="width: 40%;"><?php echo esc_html($row->keyword) ?></td>
                                <?php if (!empty($row->stats)) { ?>
                                    <td nowrap="nowrap" style="width: 20%;">
                                        <span class="sq_top_keywords_rank" style="color:<?php echo(isset($row->stats->sc->color) ? esc_attr($row->stats->sc->color) : '#fff') ?>"><?php echo(isset($row->stats->sc->text) ? esc_html($row->stats->sc->text) : '-') ?></span>
                                    </td>
                                    <td nowrap="nowrap text-right" style="width: 15%;">
                                        <span class="sq_top_keywords_rank"><?php echo(isset($row->stats->sv->absolute) ? (is_numeric($row->stats->sv->absolute) ? number_format($row->stats->sv->absolute, 0, '.', ',') : esc_html($row->stats->sv->absolute)) : '-') ?></span>
                                    </td>
                                    <td nowrap="nowrap" style="width: 15%;">
                                        <span class="sq_top_keywords_rank"><?php echo(isset($row->stats->tw->text) ? esc_html($row->stats->tw->text) : '-') ?></span>
                                    </td>

                                    <td nowrap="nowrap" style="width: 0.5%;">
                                        <div style="width: 60px;height: 30px;">
                                            <canvas class="sq_trend" data-values=" <?php echo join(',', (array)$row->stats->td->absolute) ?>"></canvas>
                                        </div>
                                    </td>
                                <?php } else { ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                <?php } ?>
                                <td class="px-0 py-2" style="width: 20px">
                                    <div class="sq_sm_menu">
                                        <div class="sm_icon_button sm_icon_options">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </div>
                                        <div class="sq_sm_dropdown">
                                            <ul class="p-2 m-0 text-left">
                                                <li class="sq_research_selectit border-bottom m-0 p-1 py-2 noloading">
                                                    <?php  $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('/post-new.php?keyword=' . SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword, 'url')); ?>
                                                    <a href="<?php echo (string)$edit_link ?>" target="_blank" class="sq-nav-link">
                                                        <i class="sq_icons_small sq_sla_icon"></i>
                                                        <?php echo esc_html__("Optimize for this", _SQ_PLUGIN_NAME_) ?>
                                                    </a>
                                                </li>
                                                <?php if ($in_briefcase) { ?>
                                                    <li class="bg-briefcase m-0 p-1 py-2 text-black-50">
                                                        <i class="sq_icons_small sq_briefcase_icon"></i>
                                                        <?php echo esc_html__("Already in briefcase", _SQ_PLUGIN_NAME_); ?>
                                                    </li>
                                                <?php } else { ?>
                                                    <li class="sq_research_add_briefcase m-0 p-1 py-2" data-keyword="<?php echo SQ_Classes_Helpers_Sanitize::escapeKeyword($row->keyword) ?>">
                                                        <i class="sq_icons_small sq_briefcase_icon"></i>
                                                        <?php echo esc_html__("Add to briefcase", _SQ_PLUGIN_NAME_); ?>
                                                    </li>
                                                <?php } ?>

                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</td>