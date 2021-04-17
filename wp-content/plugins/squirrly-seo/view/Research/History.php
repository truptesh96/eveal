<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'suggested'), 'sq_research'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons_content p-3 py-4">
                            <div class="sq_icons sq_history_icon m-2"></div>
                        </div>
                        <h3 class="card-title"><?php echo esc_html__("Research History", _SQ_PLUGIN_NAME_); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#history" target="_blank"><i class="fa fa-question-circle"></i></a>
                            </div>
                        </h3>
                        <div class="card-title-description m-2"><?php echo esc_html__("See the Keyword Researches you made in the last 30 days", _SQ_PLUGIN_NAME_); ?></div>
                    </div>
                    <div id="sq_history" class="card col-12 p-0 tab-panel border-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-0">
                            <div class="col-12 m-0 p-0">
                                <div class="card col-12 my-4 p-0 px-1 border-0 ">
                                    <?php if (is_array($view->kr) && !empty($view->kr)) { ?>
                                        <table class="sq_krhistory_list table table-striped table-hover" cellpadding="0" cellspacing="0" border="0">
                                            <thead>
                                            <tr>
                                                <th scope="col"><?php echo esc_html__("Keyword", _SQ_PLUGIN_NAME_) ?></th>
                                                <th scope="col" title="<?php echo esc_html__("Country", _SQ_PLUGIN_NAME_) ?>"><?php echo esc_html__("Co", _SQ_PLUGIN_NAME_) ?></th>
                                                <th style="width: 160px;"><?php echo esc_html__("Date", _SQ_PLUGIN_NAME_) ?></th>
                                                <th style="width: 160px;"><?php echo esc_html__("Details", _SQ_PLUGIN_NAME_) ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($view->kr as $key => $kr) {
                                                ?>
                                                <tr>
                                                    <td style="350px" class="sq_kr_keyword" title="<?php echo esc_attr($kr->keyword) ?>"><?php echo esc_html($kr->keyword) ?></td>
                                                    <td style="90px"><?php echo esc_html($kr->country) ?></td>
                                                    <td style="120px">
                                                        <div data-datetime="<?php echo strtotime($kr->datetime) ?>"><?php echo date(get_option('date_format'), strtotime($kr->datetime)) ?></div>
                                                    </td>
                                                    <td style="20px">
                                                        <button type="button" data-id="<?php echo (int)$kr->id ?>" data-destination="#history<?php echo (int)$kr->id ?>" class="sq_history_details btn btn-success btn-sm px-5"><?php echo esc_html__("Show All Keywords", _SQ_PLUGIN_NAME_) ?></button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="card-body">
                                            <h4 class="text-center"><?php echo esc_html__("Welcome to Keyword Research History", _SQ_PLUGIN_NAME_); ?></h4>
                                            <h5 class="text-center"><?php echo esc_html__("See your research results and compare them over time", _SQ_PLUGIN_NAME_); ?>:</h5>
                                            <div class="col-12 my-4 text-center">
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') ?>" class="btn btn-lg btn-primary">
                                                    <i class="fa fa-plus-square-o"></i> <?php echo esc_html__("Go Find New Keywords", _SQ_PLUGIN_NAME_); ?>
                                                </a>
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