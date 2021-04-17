<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap" class="sq_overview">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_form_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white p-0 m-0">
        <div class="sq_flex flex-grow-1 mx-0 px-2">
            <?php $view->getJourneyNotification(); ?>
            <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockStats')->init(); ?>
            <?php if (current_user_can('sq_manage_snippets')) { ?>
                <?php if (SQ_Classes_Helpers_Tools::getMenuVisible('show_seogoals')) { ?>
                    <?php SQ_Classes_ObjController::getClass('SQ_Controllers_CheckSeo')->init(); ?>
                <?php } ?>
                <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockJorney')->init(); ?>
            <?php } else {
                echo '<div class="col-12 alert alert-success text-center mx-0 my-3 p-3">' . esc_html__("You do not have permission to access Daily Goals. You need Squirrly SEO Editor role.", _SQ_PLUGIN_NAME_) . '</div>';
            } ?>

            <div class="card col-12 my-3 py-3">
                <div class="card-body m-0 p-0">
                    <div class="row text-left m-0 p-0">
                        <div class="px-5 py-3" style="max-width: 350px;width: 40%;">
                            <img src="<?php echo _SQ_ASSETS_URL_ . 'img/squirrly_features.png' ?>" style="width: 250px">
                        </div>
                        <div class="col px-2 py-3">
                            <div class="col-12 m-0 p-0">
                                <h3 class="card-title" style="color: green;"><?php echo esc_html__("What's Included in Squirrly SEO Plugin", _SQ_PLUGIN_NAME_); ?></h3>
                            </div>

                            <div class="sq_separator"></div>
                            <div class="col-12 m-2 p-0">
                                <div class="card-title-description m-2 text-black-50"><?php echo sprintf(esc_html__("With a total of over %s400%s free in-depth features that only Squirrly can offer.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></div>
                            </div>
                            <div class="col-12 m-0 p-4 text-right">
                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_features') ?>" class="btn btn-sm btn-success m-0 py-2 px-4"><?php echo esc_html__("See what features are included in Squirrly SEO", _SQ_PLUGIN_NAME_); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sq_col_side sticky">
            <div class="card col-12 p-0 my-2">
                <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                <?php if (SQ_Classes_Helpers_Tools::getMenuVisible('show_panel') && current_user_can('manage_options')) { ?>
                    <div class="sq_account_info" style="min-height: 20px;"></div>
                <?php } ?>
            </div>

            <div class="card col-12 p-0 my-2">
                <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockConnect')->init(); ?>
            </div>

            <?php if (SQ_Classes_Helpers_Tools::getMenuVisible('show_ads')) { ?>
                <div class="card col-12 p-0 my-2">
                    <div class="my-3 py-3">
                        <div class="col-12 row p-0 m-0">
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

            <div class="card col-12 p-0 my-2">
                <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockKnowledgeBase')->init(); ?>
            </div>
        </div>
    </div>
</div>
