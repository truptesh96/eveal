<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php if (current_user_can('sq_manage_snippets')) { ?>
    <div class="card col-12 p-0 m-0 border-0">
        <div class="card-body px-2 py-1">
            <div id="sq_assistant_sq_seosettings" class="sq_assistant">
                <form method="post" action="">
                    <ul id="sq_assistant_tasks_sq_seosettings" class="p-0 m-0">
                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_cloud_connect')) { ?>

                            <li class="sq_task row border-0 mb-0 pb-2">
                                <?php SQ_Classes_Helpers_Tools::setNonce('sq_cloud_connect', 'sq_nonce'); ?>
                                <input type="hidden" name="action" value="sq_cloud_connect"/>
                                <i class="fa fa-check" title="ssss" data-original-title=""></i>
                                <div class="message" style="display: none"></div>
                                <div class="description" style="display: none"><?php echo sprintf(esc_html__("This option is used to track innerlinks and insights for your Focus Pages and give detailed information about them. %sIt is also useful for sending the optimized posts from %shttps://cloud.squirrly.co%s directly on your WordPress site.", _SQ_PLUGIN_NAME_), '<br /> ', '<a href="https://cloud.squirrly.co" target="_blank">', '</a>'); ?></div>
                                <h4><?php echo esc_html__("Let Squirrly Cloud get data for Focus Pages", _SQ_PLUGIN_NAME_); ?></h4>
                            </li>
                            <div class="text-center m-0 mb-3">
                                <button type="submit" class="btn btn-primary btn-sm inline p-0 px-3 m-0" style="z-index: 1"><?php echo esc_html__("Connect", _SQ_PLUGIN_NAME_); ?></button>
                            </div>

                        <?php } else { ?>

                            <li class="sq_task row completed border-0 mb-0 pb-2">
                                <?php SQ_Classes_Helpers_Tools::setNonce('sq_cloud_disconnect', 'sq_nonce'); ?>
                                <input type="hidden" name="action" value="sq_cloud_disconnect"/>
                                <i class="fa fa-check" title="" data-original-title=""></i>
                                <div class="message" style="display: none"></div>
                                <div class="description" style="display: none"><?php echo sprintf(esc_html__("This option is used to track innerlinks and insights for your Focus Pages and give detailed information about them. %sIt is also useful for sending the optimized posts from %shttps://cloud.squirrly.co%s directly on your WordPress site.", _SQ_PLUGIN_NAME_), '<br /> ', '<a href="https://cloud.squirrly.co" target="_blank">', '</a>'); ?></div>
                                <h4>
                                    <?php echo esc_html__("Let Squirrly Cloud connect to WordPress API", _SQ_PLUGIN_NAME_); ?>
                                </h4>
                            </li>
                            <div class="text-center m-0 mb-3">
                                <button type="submit" class="btn btn-link btn-sm inline p-0 m-0" style="z-index: 1">(<?php echo esc_html__("disconnect", _SQ_PLUGIN_NAME_); ?>)</button>
                            </div>
                        <?php } ?>
                    </ul>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
