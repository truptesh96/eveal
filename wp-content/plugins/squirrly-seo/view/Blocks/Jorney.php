<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_journey">
    <?php if ($view->days) { ?>
        <div class="card col-12 my-3 p-0">
            <div class="card-body m-0 p-0">
                <div class="row text-left m-0 p-0">
                    <div class="row text-left m-0 p-0">
                        <div class="px-2 py-3" style="max-width: 350px;width: 40%;">
                            <img src="<?php echo _SQ_ASSETS_URL_ . 'img/onboarding/racing_car.png' ?>" style="width: 100%">
                        </div>
                        <div class="col px-2 py-3">
                            <div class="col-12 m-0 p-0">
                                <h3 class="card-title" style="color: green;"><?php echo esc_html__("14 Days Journey Course", _SQ_PLUGIN_NAME_); ?></h3>
                            </div>

                            <div class="sq_separator"></div>
                            <div class="col-12 m-2 p-0">
                                <div class="my-2"><?php echo sprintf(esc_html__("Follow the %sdaily recipe%s from below.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></div>
                                <div class="my-2"><?php echo sprintf(esc_html__("%sJoin%s the rest of the %sJourneyTeam on the Facebook Group%s and if you want you can share with the members that you have started your Journey.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<strong><a href="https://www.facebook.com/groups/SquirrlySEOCustomerService/" target="_blank" >', '</a></strong>'); ?></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="sq_separator"></div>
                <div class="card col-12 p-0 m-0 border-0 tab-panel border-0">
                    <div class="card-body p-0">
                        <div class="col-12 m-0 p-0">
                            <div class="card col-12 m-0 p-0 border-0 ">

                                <div class="col-12 m-0 p-3 text-center">
                                    <?php if ($view->days > 14) { ?>
                                        <h5 class="col-12 card-title py-3 "><?php echo esc_html__("Congratulations! You've completed the 14 Days Journey To Better Ranking", _SQ_PLUGIN_NAME_); ?></h5>
                                    <?php } else { ?>
                                        <h2 class="col-12 card-title py-3 "><?php echo esc_html__("Your 14 Days Journey To Better Ranking", _SQ_PLUGIN_NAME_); ?></h2>
                                    <?php } ?>

                                    <ul class="stepper horizontal horizontal-fix focused" id="horizontal-stepper-fix">
                                        <?php for ($i = 1; $i <= 14; $i++) { ?>
                                            <li class="step <?php echo(((int)$view->days >= $i) ? 'completed' : '') ?>">
                                                <div class="step-title waves-effect waves-dark">
                                                    <?php echo(((int)$view->days >= $i) ? '<a href="https://howto.squirrly.co/wordpress-seo/journey-to-better-ranking-day-' . $i . '/" target="_blank"><i class="fa fa-check-circle" style="color: darkcyan;"></i></a>' : '<i class="fa fa-circle-o"  style="color: darkgrey;"></i>') ?>
                                                    <div><?php echo(((int)$view->days >= $i) ? '<a href="https://howto.squirrly.co/wordpress-seo/journey-to-better-ranking-day-' . $i . '/" target="_blank">' . esc_html__("Day", _SQ_PLUGIN_NAME_) . ' ' . $i . '</a>' : esc_html__("Day", _SQ_PLUGIN_NAME_) . ' ' . $i) ?></div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>

                                    <?php if ((int)$view->days > 14) { ?>
                                        <em class="text-black-50"><?php echo esc_html__("If you missed a day, click on it and read the SEO recipe for it.", _SQ_PLUGIN_NAME_); ?></em>
                                        <div class="small text-center my-2">
                                            <form method="post" class="p-0 m-0">
                                                <?php SQ_Classes_Helpers_Tools::setNonce('sq_journey_close', 'sq_nonce'); ?>
                                                <input type="hidden" name="action" value="sq_journey_close"/>
                                                <button type="submit" class="btn btn-sm text-info btn-link bg-transparent p-0 m-0">
                                                    <?php echo esc_html__("I'm all done. Hide this block.", _SQ_PLUGIN_NAME_) ?>
                                                </button>
                                            </form>
                                        </div>
                                    <?php } else { ?>
                                        <a href="https://howto.squirrly.co/wordpress-seo/journey-to-better-ranking-day-<?php echo (int)$view->days ?>/" target="_blank" class="btn btn-primary m-2 py-2 px-4" style="font-size: 20px;"><?php echo esc_html__("Day", _SQ_PLUGIN_NAME_) . ' ' . $view->days . ': ' . esc_html__("Open the SEO recipe for today", _SQ_PLUGIN_NAME_); ?></a>
                                        <?php
                                        switch ((int)$view->days) {
                                            case 1:
                                                ?>
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'addpage') ?>" target="_blank" class="btn btn-success m-2 py-2 px-4" style="font-size: 20px;"><?php echo esc_html__("Add a page in Focus Pages", _SQ_PLUGIN_NAME_); ?></a><?php
                                                break;
                                            case 2:
                                                ?>
                                                <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'research') ?>" target="_blank" class="btn btn-success m-2 py-2 px-4" style="font-size: 20px;"><?php echo esc_html__("Do Keyword Research", _SQ_PLUGIN_NAME_); ?></a><?php
                                                break;
                                        }
                                        ?>
                                    <?php } ?>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    <?php } else { ?>
        <div class="card col-12 my-3 py-3">
            <div class="card-body m-0 p-0">
                <div class="row text-left m-0 p-0">
                    <div class="px-2 py-3" style="max-width: 350px;width: 40%;">
                        <img src="<?php echo _SQ_ASSETS_URL_ . 'img/onboarding/racing_car.png' ?>" style="width: 100%">
                    </div>
                    <div class="col px-2 py-3">
                        <div class="col-12 m-0 p-0">
                            <h3 class="card-title" style="color: green;"><?php echo esc_html__("14 Days Journey Course", _SQ_PLUGIN_NAME_); ?></h3>
                        </div>

                        <div class="sq_separator"></div>
                        <div class="col-12 m-2 p-0">
                            <div class="card-title-description m-2 text-black-50"><?php echo esc_html__("All you need now is to start driving One of your most valuable pages to Better Rankings.", _SQ_PLUGIN_NAME_); ?></div>
                        </div>
                        <div class="col-12 m-0 p-4 text-right">
                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_onboarding', 'journey1') ?>" class="btn btn-sm btn-success m-0 py-2 px-4"><?php echo esc_html__("I'm ready to start the Journey To Better Ranking", _SQ_PLUGIN_NAME_); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
