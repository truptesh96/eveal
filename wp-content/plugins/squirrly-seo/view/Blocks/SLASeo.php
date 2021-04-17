<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div class="sq_box" style="display: none">
    <div id="sq_blockseo" style="display: none">
        <div class="sq_header"><?php echo esc_html__("Squirrly Live Assistant", _SQ_PLUGIN_NAME_); ?>

            <span id="sq_seo_refresh">
                <?php echo esc_html__("Update", _SQ_PLUGIN_NAME_) ?>
            </span>
            <div style="float: right">
                <div class="sq_auto_sticky" title="<?php echo esc_html__("Split Window", _SQ_PLUGIN_NAME_) ?>">
                    <input id="sq_auto_sticky1" type="checkbox" name="sq_auto_sticky" value="1" <?php echo(SQ_Classes_Helpers_Tools::getUserMeta('sq_auto_sticky') ? "checked" : '') ?> />
                    <label for="sq_auto_sticky1"><span class="sq_switch_img"></label>
                </div>
            </div>
        </div>

        <div class="sq_tasks">
            <ul>
                <li class="sq_tasks_category" style="width: 100%; box-shadow: none !important; margin: 0; padding: 0; margin-top: -14px !important;">
                    <progress class="sq_blockseo_progress" max="100" value="0"></progress>
                </li>
                <?php
                $sla_tasks = SQ_Classes_ObjController::getClass('SQ_Models_Post')->getTasks();
                foreach ($sla_tasks as $category => $row) { ?>
                    <li class="sq_tasks_category" style="display: none"><?php echo esc_html($category) ?></li>
                    <?php foreach ($row as $name => $task) { ?>
                        <li id="<?php echo esc_attr('sq_' . $name) . '' ?>" style="display: none">
                            <?php echo (string)$task['title'] ?>
                            <div class="arrow"><p class="sq_help"><?php echo wp_kses_post($task['help']) ?></p></div>
                        </li>
                    <?php }
                } ?>
                <li class="sq_tasks_category" style="width: 100%; box-shadow: none !important; padding: 0; margin: 0; margin-bottom: -14px !important; line-height: 1px;">
                    <progress class="sq_blockseo_progress" max="100" value="0"></progress>
                </li>
                <script>jQuery("body").prepend('<progress class="sq_blockseo_topprogress" max="100" value="0"></progress>')</script>
            </ul>
        </div>
    </div>
    <div id="sq_research" style="display: none"></div>
</div>