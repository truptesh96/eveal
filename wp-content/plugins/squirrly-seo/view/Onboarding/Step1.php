<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php $next_step = 'step2'; ?>
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
                            <form method="post" action="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', $next_step) ?>" class="p-0 m-0">
                                <?php SQ_Classes_Helpers_Tools::setNonce('sq_onboarding_settings', 'sq_nonce'); ?>
                                <input type="hidden" name="action" value="sq_onboarding_settings"/>

                                <div class="row col-12 pt-0 pb-4 ">
                                    <div class="col-12 pt-0 pb-4 border-bottom tab-panel">
                                        <div class="p-2 ">
                                            <h3 class="card-title text-center"><?php echo esc_html__("Let us know how to setup your website", _SQ_PLUGIN_NAME_); ?></h3>
                                            <div class="small text-black-50 text-center"><?php echo esc_html__("You can also modify all the settings later.", _SQ_PLUGIN_NAME_); ?></div>
                                        </div>
                                        <div class="col-12 row mx-0 my-5">
                                            <div class="col-4 p-0 pr-3 font-weight-bold">
                                                <div class="font-weight-bold"><?php echo esc_html__("Your Website Type", _SQ_PLUGIN_NAME_); ?>:</div>
                                                <div class="small text-black-50 my-1"><?php echo esc_html__("SEO Automation will setup SEO Patterns and Post Types based on your website type.", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                            <div class="col-6 p-0 input-group">

                                                <select name="sq_onboarding_data[website_type]" class="form-control bg-input mb-1">
                                                    <option value="ecommerce"><?php echo esc_html__("E-commerce", _SQ_PLUGIN_NAME_); ?></option>
                                                    <option value="personal"><?php echo esc_html__("Personal", _SQ_PLUGIN_NAME_); ?></option>
                                                    <option value="news"><?php echo esc_html__("Blog/News", _SQ_PLUGIN_NAME_); ?></option>
                                                    <option value="magazine"><?php echo esc_html__("Magazine", _SQ_PLUGIN_NAME_); ?></option>
                                                    <option value="portofolio"><?php echo esc_html__("Portfolio", _SQ_PLUGIN_NAME_); ?></option>
                                                    <option value="business"><?php echo esc_html__("Small Business", _SQ_PLUGIN_NAME_); ?></option>
                                                    <option value="local"><?php echo esc_html__("Local Business", _SQ_PLUGIN_NAME_); ?></option>
                                                    <option value="directory"><?php echo esc_html__("Directory", _SQ_PLUGIN_NAME_); ?></option>
                                                    <option value="other"><?php echo esc_html__("Other", _SQ_PLUGIN_NAME_); ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 row mx-0 my-5">
                                            <div class="col-4 p-0 pr-3 font-weight-bold">
                                                <div class="font-weight-bold"><?php echo esc_html__("Your SEO Level", _SQ_PLUGIN_NAME_); ?>:</div>
                                                <div class="small text-black-50 my-1"><?php echo esc_html__("SEO Settings will load data based on your SEO knowledge.", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                            <div class="col-6 p-0 input-group">
                                                <select name="sq_onboarding_data[seo_level]" class="form-control bg-input mb-1">
                                                    <option value="normal"><?php echo esc_html__("Non-SEO Expert", _SQ_PLUGIN_NAME_); ?></option>
                                                    <option value="expert"><?php echo esc_html__("SEO Expert", _SQ_PLUGIN_NAME_); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 m-0 p-0 py-2 text-right">
                                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', $next_step) ?>" class="btn rounded-0 btn-link btn-lg text-black-50 px-3 mx-4 float-sm-left"><?php echo esc_html__("Skip Step", _SQ_PLUGIN_NAME_); ?></a>

                                    <button type="submit" class="btn rounded-0 btn-success btn-lg px-3 mx-4 float-sm-right">
                                        <?php echo esc_html__("Save & Continue", _SQ_PLUGIN_NAME_) . ' >' ?>
                                    </button>
                                </div>
                            </form>

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