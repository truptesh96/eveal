<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'step3'), 'sq_onboarding'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">

                <div class="card col-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top row">
                        <div class="col-8 m-0 p-0 py-2 bg-title rounded-top">
                            <div class="sq_icons sq_squirrly_icon m-1 mx-3"></div>
                            <h3 class="card-title"><?php echo esc_html__("Import SEO & Settings", _SQ_PLUGIN_NAME_); ?></h3>
                        </div>

                    </div>
                    <div class="card col-12 p-0 m-0 border-0 tab-panel border-0">
                        <div class="card-body p-0" style="min-width: 800px;min-height: 430px">
                            <div class="col-12 m-0 p-0">
                                <div class="col-12 p-0 border-0 ">

                                    <div class="col-12 pt-0 pb-4 tab-panel">
                                        <?php
                                        add_filter('sq_themes', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'getAvailableThemes'));
                                        add_filter('sq_plugins', array(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport'), 'getAvailablePlugins'));
                                        $platforms = apply_filters('sq_importList', false);
                                        if ($platforms && count((array)$platforms) > 0) {
                                            ?>
                                            <div class="col-12 card-title pt-4 text-center" style="font-size: 23px; line-height: 35px"><?php echo esc_html__("We've detected another SEO Plugin on your site.", _SQ_PLUGIN_NAME_); ?></div>

                                            <div id="sq_onboarding">

                                                <div class="col-12 card-title m-2 mt-5 text-center" style="font-size: 20px; line-height: 35px"><?php echo sprintf(esc_html__("%sImport your settings and SEO%s from the following plugin into your new Squirrly SEO", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?>:</div>

                                                <div class="col-12 pt-0 pb-4 ml-3 tab-panel">
                                                    <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                                        <div class="col-12 row py-2 mx-0 my-3">
                                                            <div class="col-10 offset-1 p-0 input-group">
                                                                <?php
                                                                if ($platforms && count((array)$platforms) > 0) {
                                                                    ?>
                                                                    <select name="sq_import_platform" class="form-control bg-input mb-1">
                                                                        <?php
                                                                        foreach ($platforms as $path => $settings) {
                                                                            ?>
                                                                            <option value="<?php echo esc_attr($path) ?>"><?php echo ucfirst(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($path)); ?></option>
                                                                        <?php } ?>
                                                                    </select>

                                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_importall', 'sq_nonce'); ?>
                                                                    <input type="hidden" name="action" value="sq_seosettings_importall"/>
                                                                    <button type="submit" class="btn rounded-0 btn-success px-3 mx-2" style="min-width: 140px; max-height: 50px;"><?php echo esc_html__("Import", _SQ_PLUGIN_NAME_); ?></button>
                                                                <?php } else { ?>
                                                                    <div class="col-12 my-2"><?php echo esc_html__("We couldn't find any SEO plugin or theme to import from.", _SQ_PLUGIN_NAME_); ?></div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </form>


                                                    <div class="card-body m-0 py-0">
                                                        <div class="col-12 mt-5 mx-2">
                                                            <h5 class="text-left my-3 text-info"><?php echo esc_html__("What you gain", _SQ_PLUGIN_NAME_); ?>:</h5>
                                                            <ul style="list-style: circle; margin-left: 30px;">
                                                                <li style="font-size: 15px;"><?php echo esc_html__("Everything will be the same in your site, and Google will keep all your rankings safe.", _SQ_PLUGIN_NAME_); ?></li>
                                                                <li style="font-size: 15px;"><?php echo esc_html__("Squirrly SEO covers everything that Google used to see from the old plugin, and brings new stuff in. That's why Google will do more than keep your rankings safe. It might award you with brand new page 1 positions if you use Squirrly.", _SQ_PLUGIN_NAME_); ?></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-12 mt-5 mx-2">
                                                            <h5 class="text-left my-3 text-info"><?php echo esc_html__("If you decide to switch back", _SQ_PLUGIN_NAME_); ?>:</h5>
                                                            <ul style="list-style: circle; margin-left: 30px;">
                                                                <li style="font-size: 15px;"><?php echo esc_html__("you can always switch back, without any issues. Your old plugin will remain the same. We don't delete it.", _SQ_PLUGIN_NAME_); ?></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 my-3 p-0 py-3 border-top">
                                                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step4') ?>" class="btn rounded-0 btn-success btn-lg px-3 mx-4 float-sm-right"><?php echo esc_html__("Continue", _SQ_PLUGIN_NAME_) . ' >'; ?></a>
                                                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'step4') ?>" class="btn rounded-0 btn-default btn-lg px-3 mx-4 float-sm-right"><?php echo esc_html__("Skip this step", _SQ_PLUGIN_NAME_); ?></a>
                                                </div>
                                            </div>

                                        <?php } else { ?>
                                            <div class="col-12 card-title pt-5 text-center" style="font-size: 23px; line-height: 35px"><?php echo esc_html__("We haven't detected other SEO Plugins on your site.", _SQ_PLUGIN_NAME_); ?></div>

                                            <div class="text-center m-5">
                                                <?php echo esc_html__("Click Continue to go to the next step.", _SQ_PLUGIN_NAME_); ?>
                                            </div>

                                        <?php } ?>
                                    </div>

                                </div>

                            </div>

                        </div>
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
        #sq_wrap .checkbox .cr .cr-icon {
            opacity: 1 !important;
            font-size: 14px !important;
            top: 3px;
            left: 6px !important;
        }</style>
</noscript>

