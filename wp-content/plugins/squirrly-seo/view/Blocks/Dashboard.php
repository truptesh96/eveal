<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php
$tasks_completed = SQ_Classes_ObjController::getClass('SQ_Controllers_CheckSeo')->getCongratulations();
$tasks_incompleted = SQ_Classes_ObjController::getClass('SQ_Controllers_CheckSeo')->getNotifications();
?>
<div id="sq_dashboard_content" style="position: relative;">
    <?php do_action('sq_form_notices'); ?>

    <div id="sq_dashboard_content_inner">
        <table class="sq_strength">
            <tr>
                <td class="sq_strength-meter" style="display: none">
                    <div class="sq_strength-data">
                        <div class="sq_level-indicator">
                            <span class="sq_fill"> <img class="sq_mask" alt="" src="<?php echo _SQ_ASSETS_URL_ . 'img/squirrly_filled.png' ?>"></span>
                            <em class="sq_level-separator" style="height:135px;"></em>
                        </div>
                    </div>
                    <img class="sq_mask" alt="" src="<?php echo _SQ_ASSETS_URL_ . 'img/squirrly_blank.png' ?>">
                </td>
                <td class="sq_subtitle">
                    <?php echo esc_html__("Upgrade your SEO with Squirrly and improve your rankings on Google", _SQ_PLUGIN_NAME_) ?>
                </td>
            </tr>
        </table>

        <?php if (!empty($tasks_completed)) {
            $tasks_completed = array_values($tasks_completed);

            ?>
            <div class="sq_dashboard_title">
                <strong><?php echo esc_html__("Congratulations! you have success messages", _SQ_PLUGIN_NAME_) ?>:
            </div>
            <div class="sq_dashboard_description">
                <ul>
                    <?php
                    foreach ($tasks_completed as $index => $row) { ?>
                        <li>
                            <span style="<?php echo($row['color'] ? 'color:' . esc_attr($row['color']) . ';' : 'color:darkgreen;') ?>">
                                <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/' . esc_attr($row['image']) ?>" alt=""  style="max-width: 20px; vertical-align: middle" />
                                <?php echo(isset($row['message']) ? (string)$row['message'] : '') ?>
                            </span>
                        </li>
                        <?php
                        if ($index > 0) break;
                    }
                    ?>
                    <?php if (count((array)$tasks_completed) > 2) { ?>
                        <li>
                            <span style="<?php echo($row['color'] ? 'color:' . esc_attr($row['color']) . ';' : 'color:orangered;') ?>">
                                <?php echo '+' . (count((array)$tasks_completed) - 2) . ' ' . esc_html__("others", _SQ_PLUGIN_NAME_) ?>
                            </span>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="sq_dashboard_buttons">
                <a class="wp_button" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>">
                    <?php if (count($tasks_completed) > 2) { ?>
                        <span><?php echo sprintf(esc_html__("See %s other achievements", _SQ_PLUGIN_NAME_), '+' . (count($tasks_completed) - 2)) ?></span>
                    <?php } else { ?>
                        <span><?php echo esc_html__("See today's achievements", _SQ_PLUGIN_NAME_) ?></span>
                    <?php } ?>
                </a>
            </div>
        <?php } ?>

        <?php if (!empty($tasks_incompleted)) {
            $tasks_incompleted = array_values($tasks_incompleted);
            ?>
            <div class="sq_dashboard_title"><?php echo esc_html__("You got new goals", _SQ_PLUGIN_NAME_) ?>:</div>
            <div class="sq_dashboard_description">
                <ul>
                    <?php
                    //$tasks_incompleted = array_slice($tasks_incompleted, 0, 2);
                    foreach ($tasks_incompleted as $index => $row) { ?>
                        <li>
                            <span style="<?php echo($row['color'] ? 'color:' . esc_attr($row['color']) . ';' : 'color:orangered;') ?>">
                                 <?php echo(isset($row['warning']) ? (string)$row['warning'] : '') ?>
                            </span>
                        </li>
                        <?php
                        if ($index > 0) break;
                    } ?>

                    <?php if (count((array)$tasks_incompleted) > 2) { ?>
                        <li>
                            <span style="<?php echo($row['color'] ? 'color:' . esc_attr($row['color']) . ';' : 'color:orangered;') ?>">
                                <?php echo '+' . (count((array)$tasks_incompleted) - 2) . ' ' . esc_html__("others", _SQ_PLUGIN_NAME_) ?>
                            </span>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="sq_dashboard_buttons">
                <a class="wp_button" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>#tasks">
                    <?php if (count($tasks_incompleted) > 2) { ?>
                        <span><?php echo sprintf(esc_html__("See %s other goals", _SQ_PLUGIN_NAME_), '+' . (count($tasks_incompleted) - 2)) ?></span>
                    <?php } else { ?>
                        <span><?php echo esc_html__("See today's goals", _SQ_PLUGIN_NAME_) ?></span>
                    <?php } ?>
                </a>
            </div>
        <?php } else { ?>
            <div class="sq_dashboard_nogoals">
                <h4><?php echo sprintf(esc_html__("No other goals for today. %sGood job!", _SQ_PLUGIN_NAME_), '<br />'); ?></h4>
                <div>
                    <a class="wp_button" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'pagelist') ?>" class="btn btn-sm btn-success" style="font-size: 14px"><?php echo esc_html__("Rank your best pages with Focus Pages", _SQ_PLUGIN_NAME_); ?></a>
                </div>
                <div>
                    <a class="wp_button" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo') ?>" class="btn btn-sm btn-success" style="font-size: 14px"><?php echo esc_html__("Boost your SEO with Bulk SEO", _SQ_PLUGIN_NAME_); ?></a>
                </div>
            </div>
        <?php } ?>

    </div>
</div>

<script>
    var sq_profilelevel = function (level) {
        jQuery('.sq_level-separator').animate({height: level}, 500);
        jQuery('.sq_fill-marker').animate({top: level}, 500);
        jQuery('.sq_current-level-description').animate({top: level}, 500);
    };

    setTimeout(function () {
        sq_profilelevel(0);
    }, 1000);

    <?php if (current_user_can('sq_manage_snippets')) {?>
    (function ($) {
        $.fn.sq_widget_recheck = function () {
            var $this = this;
            var $div = $this.find('.inside');

            $div.find('#sq_dashboard_content').html('<div style="font-size: 18px; text-align: center; font-weight: bold; margin: 30px 0;"><?php echo esc_html__("Checking the website ...", _SQ_PLUGIN_NAME_) ?></div><div class="sq_loading"></div>');
            $.post(
                sqQuery.ajaxurl,
                {
                    action: 'sq_ajaxcheckseo',
                    sq_nonce: sqQuery.nonce
                }
            ).done(function (response) {
                if (typeof response.data !== 'undefined') {
                    $div.html(response.data);
                }
            }).error(function () {
                $div.html('');
            });
        };

        $(document).ready(function () {
            <?php
            $report_time = SQ_Classes_Helpers_Tools::getOption('seoreport_time');
            if (empty($report_time) || (time() - (int)$report_time) > (3600 * 12)) { ?>
            $('#sq_dashboard_widget').sq_widget_recheck();
            <?php }?>
        });
    })(jQuery);
    <?php }?>

</script>