<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php if (SQ_Classes_Helpers_Tools::getValue('sid', false)) {
    $days_back = (int)SQ_Classes_Helpers_Tools::getValue('days_back', 90);
    if (!empty($view->focuspages)) {
        foreach ($view->focuspages as $index => $focuspage) {
            $scores[] = array('date', 'score');
            $progress = array();

            if ($stats = $focuspage->stats) {
                $stats_progress = $stats->progress;

                if (!empty($stats)) {
                    foreach ($stats as $name => $values) {
                        switch ($name) {
                            case 'score':
                                if (!empty($values)) {
                                    foreach ($values as $date => $value) {
                                        $scores[] = array(date('m/d/Y', strtotime($date)), $value);
                                    }
                                } else {
                                    $scores[] = array(date('m/d/Y'), 0);
                                }
                                break;
                            case 'serp':
                                if (!empty($values)) {
                                    foreach ($values as $keyword => $rankings) {
                                        $focus_keyword = $keyword;
                                        $serp[] = array('date', 'rank');
                                        foreach ($rankings as $date => $value) {
                                            $serp[] = array(date('m/d/Y', strtotime($date)), $value);
                                        }
                                        break;
                                    }
                                }
                                break;
                            case 'page_views':
                                if (!empty($values)) {
                                    $views[] = array('date', 'views');
                                    foreach ($values as $date => $value) {
                                        $views[] = array(sprintf(esc_html__("Week %s of %s", _SQ_PLUGIN_NAME_), date('W', strtotime($date)), date('Y', strtotime($date))), $value);
                                    }
                                }
                                break;
                        }
                    }
                }

                if (!empty($stats_progress)) {
                    foreach ($stats_progress as $name => $value) {
                        switch ($name) {
                            case 'ranking':
                                if (!empty($value)) {
                                    foreach ($value as $keyword => $increase) {
                                        $progress[] = sprintf(esc_html__("Rank increased %s positions for the keyword: %s", _SQ_PLUGIN_NAME_), '<strong>' . $increase . '</strong>', '<br /><strong>' . $keyword . '</strong>');
                                    }
                                }
                                break;
                            case 'time':
                                if ($value && $value > 60) {
                                    $progress[] = sprintf(esc_html__("Time on Page increased with %s minutes", _SQ_PLUGIN_NAME_), '<strong>' . number_format(($value / 60), 0, '.', ',') . '</strong>');
                                }
                                break;
                            case 'traffic':
                                if ($value) {
                                    $progress[] = sprintf(esc_html__("Page Traffic increased with %s visits", _SQ_PLUGIN_NAME_), '<strong>' . $value . '</strong>');
                                }
                                break;
                            case 'clicks':
                                if ($value) {
                                    foreach ($value as $keyword => $increase) {
                                        $progress[] = sprintf(esc_html__("Organic Clicks increased with %s for the keyword: %s", _SQ_PLUGIN_NAME_), '<strong>' . $increase . '</strong>', '<br /><strong>' . $keyword . '</strong>');
                                    }
                                }
                                break;
                            case 'authority':
                                if ($value) {
                                    $progress[] = sprintf(esc_html__("Page Authority increased with %s", _SQ_PLUGIN_NAME_), '<strong>' . $value . '</strong>');
                                }
                                break;
                            case 'social':
                                if ($value) {
                                    $progress[] = sprintf(esc_html__("You got %s Social Shares", _SQ_PLUGIN_NAME_), '<strong>' . $value . '</strong>');
                                }
                                break;
                            case 'seo':
                                if ($value) {
                                    foreach ($value as $seo => $time) {
                                        if ($seo == 'loading_time' && $time) {
                                            $progress[] = sprintf(esc_html__("Page loads with %ss faster", _SQ_PLUGIN_NAME_), '<strong>' . $time . '</strong>');
                                        }
                                    }
                                }
                                break;
                        }
                    }
                }
            }

            //prevent chart error
            if (count($scores) == 1) {
                $scores[] = array(date('m/d/Y'), 0);
            }
        }
    }
    ?>
    <td style="width: 100%; padding: 0; margin: 0;">
        <div class="sq_stats row p-2 m-0 ">
            <div class="card col p-0 m-1 bg-white shadow-sm">
                <div class="card-content overflow-hidden m-0">
                    <div class="media align-items-stretch">
                        <div class="sq_stats_icons_content p-3 py-4 media-middle">
                            <i class="sq_stats_icons sq_stats_sdasd m-0 p-0"></i>
                        </div>
                        <div class="media-body p-3">
                            <h5><?php echo esc_html__("Chances of Ranking", _SQ_PLUGIN_NAME_) ?></h5>
                            <span class="small"><?php echo sprintf(esc_html__("the latest %s days evolution for this Focus Page", _SQ_PLUGIN_NAME_), $days_back) ?></span>
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
                            <span class="small"><?php echo sprintf(esc_html__("the latest %s days evolution for this Focus Page", _SQ_PLUGIN_NAME_), $days_back); ?></span>

                            <div class="media-right py-3 media-middle ">
                                <?php if (!empty($progress)) {
                                    foreach ($progress as $value) {
                                        echo '<h6 class="col-12 px-0 text-success" style="line-height: 25px;font-size: 14px;"><i class="fa fa-arrow-up" style="font-size: 9px !important;margin: 0 5px;vertical-align: middle;"></i> ' . $value . '</h6>';
                                    }
                                    ?>
                                <a class="mt-2 btn btn-sm btn-light border" href="https://twitter.com/intent/tweet?text=<?php echo urlencode('I love the results I get for my Focus Page with Squirrly SEO plugin for #WordPress. @SquirrlyHQ #SEO') ?>">Share Your Success</a><?php
                                } else {
                                    echo '<h4 class="col-12 px-0 text-info">' . esc_html__("No progress found yet", _SQ_PLUGIN_NAME_) . '</h4>';
                                } ?>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($serp) && count($serp) > 2 && $focus_keyword <> '' && !empty($views) && count($views) > 2) { ?>
            <div class="sq_stats row px-2 py-0 m-0 ">
                <div class="card col p-0 m-1 bg-white shadow-sm">
                    <div class="card-content  overflow-hidden m-0">
                        <div class="media align-items-stretch">
                            <div class="sq_stats_icons_content p-3 py-4 media-middle">
                                <i class="sq_stats_icons m-0 p-0"></i>
                            </div>
                            <div class="media-body p-3">
                                <h5><?php echo esc_html__("Keyword Ranking", _SQ_PLUGIN_NAME_) ?></h5>
                                <span class="small"><?php echo sprintf(esc_html__("the latest %s days ranking for %s", _SQ_PLUGIN_NAME_), $days_back, '<strong>' . $focus_keyword . '</strong>') ?></span>
                                <div class="media-right py-3 media-middle ">
                                    <div class="col-12 px-0">
                                        <div id="sq_chart_serp" class="sq_chart no-p" style="width:95%; height: 90px;"></div>
                                        <script>
                                            if (typeof google !== 'undefined') {
                                                google.setOnLoadCallback(function () {
                                                    drawRankingChart("sq_chart_serp", <?php echo wp_json_encode($serp) ?> , true);
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
                            <div class="media-body p-3">
                                <h5><?php echo esc_html__("Page Traffic", _SQ_PLUGIN_NAME_) ?></h5>
                                <span class="small"><?php echo sprintf(esc_html__("the latest %s days page views", _SQ_PLUGIN_NAME_), $days_back) ?></span>
                                <div class="media-right py-3 media-middle ">
                                    <div class="col-12 px-0">
                                        <div id="sq_chart_views" class="sq_chart no-p" style="width:95%; height: 90px;"></div>
                                        <script>
                                            if (typeof google !== 'undefined') {
                                                google.setOnLoadCallback(function () {
                                                    drawTrafficChart("sq_chart_views", <?php echo wp_json_encode($views) ?> , false);
                                                });
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
    </td>
<?php } ?>
