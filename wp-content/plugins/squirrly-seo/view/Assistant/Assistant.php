<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'assistant'), 'sq_assistant'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons_content p-3 py-4">
                            <div class="sq_icons sq_sla_icon m-2"></div>
                        </div>
                        <h3 class="card-title"><?php echo esc_html__("Optimize with Squirrly Live Assistant", _SQ_PLUGIN_NAME_); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/" target="_blank"><i class="fa fa-question-circle"></i></a>
                            </div>
                        </h3>
                        <div class="card-title-description m-2"><?php echo esc_html__("Use Squirrly to optimize the content for your Posts, Pages, Products, Custom Posts, etc.", _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_assistant" class="card col-12 p-0 tab-panel border-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-0">
                            <div class="col-12 m-0 p-0">
                                <div class="row col-12 m-0 py-3 px-0 border-0 ">
                                    <div class="col-6">
                                        <div class="col-12 my-3 p-0 text-right">
                                            <?php if (current_user_can('sq_manage_snippet')) { ?>
                                                <form method="POST">
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_create_demo', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_create_demo"/>
                                                    <button type="submit" class="btn rounded-0 btn-green btn-lg px-5" style="min-width: 280px"><?php echo esc_html__("Practice/Test Round", _SQ_PLUGIN_NAME_); ?></button>
                                                </form>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="col-12 my-3 p-0 text-left">
                                            <div class="dropdown">
                                                <button class="btn btn-success btn-lg dropdown-toggle" style="min-width: 280px" type="button" id="add_new_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?php echo esc_html__("Add New", _SQ_PLUGIN_NAME_); ?>
                                                </button>
                                                <div class="dropdown-menu mt-1" style="min-width: 200px" aria-labelledby="add_new_dropdown">
                                                    <?php
                                                    $types = get_post_types(array('public' => true));
                                                    foreach ($types as $type) {
                                                        $type_data = get_post_type_object($type);
                                                        echo '<a class="dropdown-item" href="post-new.php?post_type=' . $type_data->name . '">' . $type_data->labels->singular_name . '</a>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-12 mt-5 mx-2">
                                <h5 class="text-left my-3 text-info"><?php echo esc_html__("Tips: How to use Squirrly Live Assistant?", _SQ_PLUGIN_NAME_); ?></h5>
                                <ul style="margin-left: 30px;">
                                    <li style="font-size: 15px; list-style: initial;"><?php echo esc_html__("Create a new Post, Page or Product and the Live Assistant will load so you can start optimize the content.", _SQ_PLUGIN_NAME_); ?></li>
                                    <li style="font-size: 15px; list-style: initial;"><?php echo esc_html__("You can also optimize an existing one and update the content for better ranking.", _SQ_PLUGIN_NAME_); ?></li>
                                    <li style="font-size: 15px; list-style: initial;"><?php echo esc_html__("Make sure you optimize the lead pages for one or more keywords and monitor them with Focus Pages.", _SQ_PLUGIN_NAME_); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sq_col_side sticky">
                <div class="card col-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
