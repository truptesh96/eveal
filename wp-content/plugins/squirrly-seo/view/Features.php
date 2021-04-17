<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_form_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white p-0 m-2">
        <div class="sq_flex flex-grow-1 mx-0 px-2">
            <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockFeatures')->init(); ?>
        </div>

        <div class="sq_col_side sticky">
            <?php if (SQ_Classes_Helpers_Tools::getMenuVisible('show_ads')) { ?>
                <div class="card col-12 p-0 my-2">
                    <div class="my-3 py-3">
                        <div class="col-12 row py-0 m-0">
                            <div class="checker col-12 row m-0 p-0 text-center">
                                <div class="col-12 my-2 mx-auto p-0 font-weight-bold" style="font-size: 18px;"><?php echo esc_html__("We Need Your Support", _SQ_PLUGIN_NAME_) ?></div>

                                <div class="col-12 my-2 p-0">
                                    <a href="https://wordpress.org/support/view/plugin-reviews/squirrly-seo#postform" target="_blank">
                                        <img src="<?php echo _SQ_ASSETS_URL_ . 'img/5stars.png' ?>" style="width: 180px;">
                                    </a>
                                </div>
                                <div class="col-12 my-2 p-0">
                                    <a href="https://wordpress.org/support/view/plugin-reviews/squirrly-seo#postform" target="_blank" class="font-weight-bold" style="font-size: 16px;">
                                        <?php echo esc_html__("Rate us if you like Squirrly", _SQ_PLUGIN_NAME_) ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if (current_user_can('sq_manage_snippets')) { ?>
                <div class="card col-12 p-0 my-2">
                    <div class="my-4 py-4">
                        <div class="col-12 row py-0 m-0">
                            <div class="checker col-12 row m-0 p-0">
                                <div class="col-12 p-0  m-0 sq-switch sq-switch-sm sq_save_ajax">
                                    <input type="checkbox" id="sq_seoexpert" name="sq_seoexpert" class="sq-switch" data-action="sq_ajax_seosettings_save" data-input="sq_seoexpert" data-name="sq_seoexpert" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_seoexpert') ? 'checked="checked"' : '') ?> value="1"/>
                                    <label for="sq_seoexpert" class="ml-1"><?php echo esc_html__("Show Advanced SEO", _SQ_PLUGIN_NAME_); ?></label>
                                    <div class="text-black-50 m-0 mt-2 p-1" style="font-size: 13px;"><?php echo esc_html__("Switch off to have the simplified version of the settings, intended for Non-SEO Experts.", _SQ_PLUGIN_NAME_); ?></div>
                                    <div class="text-black-50 m-0 mt-2 p-1" style="font-size: 13px;"><?php echo esc_html__("By switching off, you'll let our AI to select the best possible settings and to coordinate our 450 SEO features for your website.", _SQ_PLUGIN_NAME_); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>


            <div class="card col-12 p-0 my-2">
                <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockKnowledgeBase')->init(); ?>
            </div>
        </div>
    </div>
</div>
