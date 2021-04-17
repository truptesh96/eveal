<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">

                <div class="card col-12 p-0">

                    <div class="card-body p-2 bg-title rounded-top row">
                        <div class="col-6 m-0 p-0 py-2 bg-title rounded-top">
                            <div class="sq_icons sq_squirrly_icon m-1 mx-3"></div>
                            <h3 class="card-title"><?php echo esc_html__("14 Days Journey", _SQ_PLUGIN_NAME_); ?></h3>
                        </div>
                    </div>

                    <div class="card col-12 p-0 m-0 border-0  border-0">
                        <div class="card-body p-0">
                            <div class="col-12 m-0 p-0">
                                <div class="card col-12 p-0 border-0 ">

                                    <div class="col-12 pt-0 pb-4 ">

                                        <div class="col-12 card-title py-3 px-4 text-center" style="font-size: 24px; line-height: 35px"><?php echo esc_html__("All you need now is to start driving One of your most valuable pages to Better Rankings.", _SQ_PLUGIN_NAME_); ?></div>
                                        <div class="row py-5 px-5 text-black-50">
                                            <div class="col-6">
                                                <img src="<?php echo _SQ_ASSETS_URL_ . 'img/onboarding/racing_car.png' ?>" style="width: 100%" >
                                            </div>
                                            <div class="col-6">
                                                <div style="font-size: 22px; color: rebeccapurple; line-height: 35px" class="mt-5 mb-2"><?php echo esc_html__("To drive it in the right direction, you have the chance to join (for Free) the 14 Days Journey to Better Rankings.", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                        </div>

                                        <div class="col-12 m-3 px-5 clear">
                                            <div style="font-size: 18px; color: rebeccapurple; line-height: 30px"><?php echo esc_html__("You'll get", _SQ_PLUGIN_NAME_); ?>:</div>
                                            <ul class="m-3 ml-5" style="list-style: disc !important;">
                                                <li class="mb-3 text-black-50" style="font-size: 16px"><?php echo sprintf(esc_html__("the %schance to fix in 14 days%s mistakes from years of ineffective SEO.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></li>
                                                <li class="mb-3 text-black-50" style="font-size: 16px"><?php echo sprintf(esc_html__("the skills you need to %ssucceed in 14 days%s.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></li>
                                                <li class="mb-3 text-black-50" style="font-size: 16px"><?php echo sprintf(esc_html__("access to the private %sJourneyTeam community%s where you can share your experience and talk about it (good and bad, all is accepted).", _SQ_PLUGIN_NAME_), '<a href="https://www.facebook.com/groups/SquirrlySEOCustomerService/" target="_blank" >', '</a>'); ?></li>
                                                <li class="mb-3 text-black-50" style="font-size: 16px"><?php echo sprintf(esc_html__("receive%s help from the JourneyTeam%s and Private Feedback on your journey from Squirrly.", _SQ_PLUGIN_NAME_), '<a href="https://www.facebook.com/groups/SquirrlySEOCustomerService/" target="_blank" >', '</a>'); ?></li>
                                                <li class="mb-3 text-black-50" style="font-size: 16px"><?php echo sprintf(esc_html__("an %sexact recipe to follow for 14 Days%s to bring one of your pages up in rankings, for a hands-on experience.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></li>
                                                <li class="mb-3 text-black-50" style="font-size: 16px"><?php echo sprintf(esc_html__("%sall the costs%s (to third parties) involved with APIs, technology, cloud computing, etc. %sare fully sponsored by Squirrly%s. We sponsor every new member who wishes to become part of the winning JourneyTeam.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<strong>', '</strong>'); ?></li>
                                            </ul>


                                        </div>
                                        <div class="col-12 my-3 p-0 py-3 border-top">
                                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'journey2') ?>" class="btn rounded-0 btn-success btn-lg px-3 mx-4 float-sm-right"><?php echo esc_html__("Continue", _SQ_PLUGIN_NAME_) . ' >'; ?></a>
                                        </div>

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
</div>
