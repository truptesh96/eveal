<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php if (!empty($view->auditpages)) { ?>
    <div class="card-body p-2">
        <?php

        $call_timestamp = 0;
        if (get_transient('sq_auditpage_all')) {
            $call_timestamp = (int)get_transient('sq_auditpage_all');
        }

        if (isset($view->audit->audit_datetime) && $view->audit->audit_datetime) {
            $audit_timestamp = strtotime($view->audit->audit_datetime) + ((int)get_option('gmt_offset') * 3600);
            $audit_timestamp = date(get_option('date_format') . ' ' . get_option('time_format'), $audit_timestamp);
        } else {
            $audit_timestamp = '';
        }


        if (!empty($view->audit) && (int)$view->audit->score > 0) {
            $color = false;
            $view->audit->error = isset($view->audit->error) ? (bool)$view->audit->error : false;

            if ((int)$view->audit->score > 0) {
                $color = '#dd3333';
                if (((int)$view->audit->score >= 50)) $color = 'orange';
                if (((int)$view->audit->score >= 90)) $color = '#20bc49';
            }

            if ($view->audit->score < 50) {
                $message = esc_html__("Your score is low. A medium score is over 50, and a good score is over 80.", _SQ_PLUGIN_NAME_);
            } elseif ($view->audit->score >= 50 && $view->audit->score < 80) {
                $message = esc_html__("Your score is medium. A good score is over 80.", _SQ_PLUGIN_NAME_);
            } elseif ($view->audit->score >= 80 && $view->audit->score < 100) {
                $message = esc_html__("Your score is good. Keep it as high as posible for good results.", _SQ_PLUGIN_NAME_);
            }
            ?>
            <div class="sq_audit_score row p-2">
                <?php if (SQ_Classes_Helpers_Tools::getValue('sid', false)) { ?>
                    <div class="col row sq_audit_header">
                        <div class="m-2 p-0 text-center" style="width: 115px;">
                            <input id="knob_<?php echo (int)$view->audit->id ?>" type="text" value="<?php echo (int)$view->audit->score ?>" class="dial" style="box-shadow: none; border: none; background: none; width: 1px; color: white" title="<?php echo esc_html__("Audit Score", _SQ_PLUGIN_NAME_) ?>">
                            <script>jQuery("#knob_<?php echo (int)$view->audit->id ?>").knob({
                                    'min': 0,
                                    'max': 100,
                                    'readOnly': true,
                                    'width': 100,
                                    'height': 100,
                                    'skin': "tron",
                                    'fgColor': '<?php echo esc_attr($color)  ?>'
                                });</script>
                        </div>
                        <div class="col">
                            <div>
                                <span class="sq_audit_header_title"><?php echo esc_html__("Your audit score is", _SQ_PLUGIN_NAME_) . ': ' ?></span>
                                <span class="sq_audit_header_score"><?php echo (int)$view->audit->score ?></span>
                            </div>
                            <div class="sq_audit_header_message"><?php echo wp_kses_post($message) ?></div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col sq_audit_header">
                        <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'addpage') ?>" class="btn btn-lg btn-primary text-white mx-1">
                            <i class="fa fa-plus-square-o"></i> <?php echo esc_html__("Add a new page for Audit", _SQ_PLUGIN_NAME_); ?>
                        </a>
                    </div>
                <?php } ?>


                <div class="float-right text-right m-0 mx-3">
                    <div class="my-1">
                        <?php echo esc_html__("Audit Date", _SQ_PLUGIN_NAME_) . ': ' ?>
                        <span class="text-danger"><?php echo (string)$audit_timestamp ?></span>
                    </div>
                    <form method="post" class="sq_auditpages_request p-0 m-0">
                        <?php SQ_Classes_Helpers_Tools::setNonce('sq_audits_update', 'sq_nonce'); ?>
                        <input type="hidden" name="action" value="sq_audits_update"/>
                        <button type="submit" class="btn btn-sm bg-warning text-white inline p-0 px-2 m-0" <?php if ($call_timestamp > time() - 3600) {
                            echo 'disabled="disabled"' . ' title="' . esc_html__("You can refresh the audit once every hour", _SQ_PLUGIN_NAME_) . '"';
                        } ?>>
                            <?php echo esc_html__("Request Website Audit", _SQ_PLUGIN_NAME_) ?>
                        </button>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="sq_audit_score row p-2">
                <div class="col-8 sq_audit_header">
                    <?php if ($call_timestamp > 0) { ?>
                        <h3 class="card-title text-info">
                            <i class="fa fa-clock-o" style="font-size: 26px !important;" aria-hidden="true"></i> <?php echo esc_html__("Audit in progress", _SQ_PLUGIN_NAME_); ?>
                        </h3>
                    <?php } ?>
                </div>
                <div class="col-4 float-right text-right">
                    <div class="my-1">
                        <?php echo esc_html__("Audit not ready yet", _SQ_PLUGIN_NAME_) ?>
                    </div>
                    <form method="post" class="sq_auditpages_request p-0 m-0">
                        <?php SQ_Classes_Helpers_Tools::setNonce('sq_audits_update', 'sq_nonce'); ?>
                        <input type="hidden" name="action" value="sq_audits_update"/>
                        <button type="submit" class="btn btn-sm bg-warning text-white inline p-0 px-2 m-0" <?php if ($call_timestamp > time() - 3600) {
                            echo 'disabled="disabled"' . ' title="' . esc_html__("You can refresh the audit once every hour", _SQ_PLUGIN_NAME_) . '"';
                        } ?>>
                            <?php echo esc_html__("Request Website Audit", _SQ_PLUGIN_NAME_) ?>
                        </button>
                    </form>
                </div>
            </div>

            <?php
        }
        ?>

    </div>
    <?php if (!SQ_Classes_Helpers_Tools::getValue('sid', false)) { ?>
        <?php if (!empty($view->audit)) { ?>
            <?php
            $days_back = (int)SQ_Classes_Helpers_Tools::getValue('days_back', 30);
            if (!empty($view->audit->stats)) {
                $scores = [];
                $positive_changes = 0;
                $audits = [];
                $scores[] = array(esc_html__("Date", _SQ_PLUGIN_NAME_), esc_html__("On-Page", _SQ_PLUGIN_NAME_), esc_html__("Off-Page", _SQ_PLUGIN_NAME_));
                if (!empty($view->audit->stats)) {

                    foreach ($view->audit->stats as $name => $values) {
                        switch ($name) {
                            case 'score':
                                if (!empty($values)) {
                                    foreach ($values as $date => $value) {

                                        $audits[$date] = $value;

                                        if (isset($value->onpage) && isset($value->offpage)) {
                                            $scores[] = array(date('m/d/Y', strtotime($date)), (int)$value->onpage, (int)$value->offpage);
                                        }
                                    }
                                } else {
                                    $scores[] = array(date('m/d/Y'), 0, 0);
                                }
                                break;
                            case 'tasks':
                                if (!empty($values)) {
                                    foreach ($values as $group => $completed) {
                                        if (!empty($completed)) {
                                            $progress[] = sprintf(esc_html__("You've completed %s tasks from %s", _SQ_PLUGIN_NAME_), '<strong>' . count($completed) . '</strong>', '<strong>' . ucfirst($group) . '</strong>');
                                        }
                                    }
                                }
                                break;
                        }
                    }

                }

                //prevent chart error
                if (count($scores) == 1) {
                    $scores[] = array(date('m/d/Y'), 0, 0);
                }

                ?>
                <div class="sq_stats row p-2 m-0 ">
                    <div class="card col p-0 m-1 bg-white shadow-sm">
                        <div class="card-content overflow-hidden m-0">
                            <div class="media align-items-stretch">
                                <div class="sq_stats_icons_content p-3 py-4 media-middle">
                                    <i class="sq_stats_icons sq_stats_sdasd m-0 p-0"></i>
                                </div>
                                <div class="media-body p-3">
                                    <h5><?php echo esc_html__("Scores", _SQ_PLUGIN_NAME_) ?></h5>
                                    <span class="small"><?php echo sprintf(esc_html__("the latest %s days evolution for Audit", _SQ_PLUGIN_NAME_), $days_back) ?></span>
                                    <div class="media-right py-3 media-middle ">
                                        <div class="col-12 px-0">
                                            <div id="sq_chart_score" class="sq_chart no-p" style="width:95%; height: 90px;"></div>
                                            <script>
                                                if (typeof google !== 'undefined') {
                                                    google.setOnLoadCallback(function () {
                                                        drawScoreChart("sq_chart_score", <?php echo wp_json_encode($scores) ?> , false);
                                                    });
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card col p-0 m-1 bg-white shadow-sm">
                        <div class="card-content  overflow-hidden m-0">
                            <div class="media align-items-stretch">
                                <div class="sq_stats_icons_content p-3 py-4 media-middle">
                                    <i class="sq_stats_icons m-0 p-0"></i>
                                </div>
                                <div class="media-body p-3" style="min-height: 187px;">
                                    <h5><?php echo esc_html__("Progress & Achievements", _SQ_PLUGIN_NAME_) ?></h5>
                                    <span class="small"><?php echo sprintf(esc_html__("the latest %s days progress for Audit Pages", _SQ_PLUGIN_NAME_), $days_back); ?></span>

                                    <div class="media-right py-3 media-middle ">
                                        <?php if (!empty($progress)) {
                                            foreach ($progress as $value) {
                                                echo '<h6 class="col-12 px-0 text-success" style="line-height: 25px;font-size: 14px;"><i class="fa fa-arrow-up" style="font-size: 9px !important;margin: 0 5px;vertical-align: middle;"></i> ' . $value . '</h6>';
                                            }
                                            ?>
                                        <a class="mt-2 btn btn-sm btn-light border" href="https://twitter.com/intent/tweet?text=<?php echo urlencode('I love the results I get with Squirrly SEO Audit for my website. @SquirrlyHQ #SEO') ?>">Share Your Success</a><?php
                                        } else {
                                            echo '<h4 class="col-12 px-0 text-info">' . esc_html__("No progress found yet", _SQ_PLUGIN_NAME_) . '</h4>';
                                        } ?>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card col-12 px-0 py-2 border-0 m-0">
                    <div class="card-body p-1">
                        <h4 class="card-title"><?php echo esc_html__("Audit History", _SQ_PLUGIN_NAME_) ?></h4>
                        <div class="card-text mx-0 my-2 p-0">
                            <form class="sq_form_bulk_submit" method="get">
                                <div class="col-5 p-0 m-0 my-2">

                                    <input type="hidden" name="page" value="sq_audits">
                                    <input type="hidden" name="tab" value="compare">
                                    <button type="button" class="sq_bulk_submit btn btn-sm btn-success"><?php echo esc_html__("Compare Audits", _SQ_PLUGIN_NAME_); ?></button>

                                </div>

                                <table class="sqd_blog_list table table-light table-striped table-hover">
                                    <thead class="thead-light">
                                    <tr>
                                        <th style="width: 10px;"></th>
                                        <th scope="col" class="text-center"><?php echo esc_html__("Audit Score", _SQ_PLUGIN_NAME_) ?></th>
                                        <th scope="col" class="text-right"><?php echo esc_html__("Page(s)", _SQ_PLUGIN_NAME_) ?></th>
                                        <th scope="col" class="text-center"><?php echo esc_html__("Date", _SQ_PLUGIN_NAME_) ?></th>
                                        <th scope="col" ></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cnt = 0;
                                    foreach ($audits as $date => $audit) {
                                        $cnt++;
                                        ?>
                                        <tr id="sq_tr<?php echo (int)$audit->id ?>">
                                            <td style="width: 10px;">
                                                <input type="checkbox" name="sid[]" class="sq_bulk_input" value="<?php echo (int)$audit->id ?>"/>
                                            </td>
                                            <td class="text-center font-weight-bold td-blue"><?php echo (int)$audit->onpage ?></td>
                                            <td class="text-right font-weight-bold"><?php if (isset($audit->urls)) {
                                                    echo count((array)$audit->urls) . ' ' . esc_html__("pages", _SQ_PLUGIN_NAME_);
                                                } ?></td>
                                            <td class="text-center"><?php echo date('d M Y', strtotime($date)) ?></td>
                                            <td >
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_audits', 'audit', array('sid=' . (int)$audit->id)) ?>" class="btn <?php echo ($cnt == 1 ? 'btn-success' : 'btn-light border') ?> btn-sm" style="min-width: 150px"><?php echo ($cnt == 1 ? esc_html__("Show Latest Audit", _SQ_PLUGIN_NAME_) : esc_html__("Show Audit", _SQ_PLUGIN_NAME_)) ?></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>

            <?php }
        } ?>
    <?php } ?>
<?php } ?>