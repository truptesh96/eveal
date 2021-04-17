<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php
$next_step = 'step4';
if ($view->platforms && count((array)$view->platforms) > 0) {
    $next_step = 'step3';
}
?>
<div id="sq_wrap">
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'step1'), 'sq_onboarding'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">

                <div class="card col-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top row">
                        <div class="col-8 m-0 p-0 py-2 bg-title rounded-top">
                            <div class="sq_icons sq_squirrly_icon m-1 mx-3"></div>
                            <h3 class="card-title"><?php echo esc_html__("Welcome to Squirrly SEO 2021 (Smart Strategy)", _SQ_PLUGIN_NAME_); ?></h3>
                        </div>
                    </div>
                    <div class="card col-12 p-0 m-0 border-0  border-0">
                        <div class="card-body" style="min-width: 800px; min-height: 430px;">

                            <div class="row col-12 pt-0 pb-4 ">
                                <div class="col-5 m-0 p-2 py-5">
                                    <div class="col-12 card-title py-5 text-success text-center" style="font-size: 24px; line-height: 35px; margin-top: 20px;"><?php echo esc_html__("Your Private SEO Consultant Sets Up the SEO for Your WordPress", _SQ_PLUGIN_NAME_); ?>:</div>
                                </div>
                                <div class="col-7 m-0 p-0">
                                    <div class="col-12 my-2 px-2 pt-3">
                                        <div id="checkbox1" class="checkbox my-2">
                                            <label style="cursor: initial">
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php echo sprintf(esc_html__("Getting %s SEO Automation %s ready on your WP", _SQ_PLUGIN_NAME_),'<strong style="color: rgb(38, 128, 180);">','</strong>'); ?>
                                            </label>
                                        </div>

                                        <div id="checkbox2" class="checkbox my-2">
                                            <label style="cursor: initial">
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php echo sprintf(esc_html__("Activating %s SEO METAs %s", _SQ_PLUGIN_NAME_),'<strong style="color: rgb(38, 128, 180);">','</strong>'); ?>
                                            </label>
                                        </div>

                                        <div id="checkbox3" class="checkbox my-2">
                                            <label style="cursor: initial">
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php echo sprintf(esc_html__("Activating %s JSON-LD Schema %s", _SQ_PLUGIN_NAME_),'<strong style="color: rgb(38, 128, 180);">','</strong>'); ?>
                                            </label>
                                        </div>

                                        <div id="checkbox4" class="checkbox my-2">
                                            <label style="cursor: initial">
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php echo sprintf(esc_html__("Activating %s Open Graph %s", _SQ_PLUGIN_NAME_),'<strong style="color: rgb(38, 128, 180);">','</strong>'); ?>
                                            </label>
                                        </div>

                                        <div id="checkbox5" class="checkbox my-2">
                                            <label style="cursor: initial">
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php echo sprintf(esc_html__("Activating %s Twitter Cards %s", _SQ_PLUGIN_NAME_),'<strong style="color: rgb(38, 128, 180);">','</strong>'); ?>
                                            </label>
                                        </div>

                                        <div id="checkbox6" class="checkbox my-2">
                                            <label style="cursor: initial">
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php echo sprintf(esc_html__("Creating your %s Sitemap XML %s", _SQ_PLUGIN_NAME_),'<strong style="color: rgb(38, 128, 180);">','</strong>'); ?>
                                            </label>
                                        </div>

                                        <div id="checkbox7" class="checkbox my-2">
                                            <label style="cursor: initial">
                                                <input type="checkbox" value="" disabled>
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                <?php echo sprintf(esc_html__("Creating %s Robots.txt %s", _SQ_PLUGIN_NAME_),'<strong style="color: rgb(38, 128, 180);">','</strong>'); ?>
                                            </label>
                                        </div>

                                        <div id="field8" class="fields mt-1 pt-2 border-top" style="display: none; color: green; font-size: 27px;">
                                            <?php echo esc_html__("Success! You are all setup", _SQ_PLUGIN_NAME_); ?>
                                            <i class="fa fa-thumbs-up" style="font-size: 34px !important;"></i>
                                        </div>


                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 m-0 p-0 py-2 text-right">

                        <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', $next_step) ?>" class="btn rounded-0 btn-success btn-lg px-3 mx-4 float-sm-right"><?php echo esc_html__("Continue", _SQ_PLUGIN_NAME_) . ' >'; ?></a>
                    </div>
                </div>

                <div class="text-center my-3">
                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" class="text-black-50"><?php echo esc_html__("Return to Dashboard", _SQ_PLUGIN_NAME_); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<noscript>
    <style>
        #sq_preloader {
            display: none;
        }

        #sq_wrap .checkbox .cr .cr-icon {
            opacity: 1 !important;
            font-size: 14px !important;
            top: 3px;
            left: 6px !important;
        }</style>
</noscript>

