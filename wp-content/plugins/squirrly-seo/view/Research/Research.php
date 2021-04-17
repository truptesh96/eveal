<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab', 'research'), 'sq_research'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">
                <?php do_action('sq_form_notices'); ?>

                <div class="card col-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top">
                        <div class="sq_icons_content p-3 py-4">
                            <i class="sq_icons sq_kr_icon m-2"></i>
                        </div>
                        <h3 class="card-title">
                            <?php echo esc_html__("Keyword Research", _SQ_PLUGIN_NAME_); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto.squirrly.co/kb/keyword-research-and-seo-strategy/#keyword_research" target="_blank"><i class="fa fa-question-circle"></i></a>
                            </div>
                        </h3>
                        <div class="card-title-description m-2">
                            <?php echo esc_html__("You can now find long-tail keywords that are easy to rank for. Get personalized competition data for each keyword you research, thanks to Squirrly's Market Intelligence Features.", _SQ_PLUGIN_NAME_) ?>
                        </div>
                    </div>
                    <div id="sq_settings">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="sq_message sq_error" style="display: none"></div>

                        <div class="col-12 p-0 py-3">

                            <?php
                            if (isset($view->error) && $view->error == 'limit_exceeded') { ?>
                                <div class="sq_step sq_step1 my-2">
                                    <h4 class="sq_limit_exceeded text-warning text-center">
                                        <?php echo esc_html__("You've reached your Keyword Research Limit", _SQ_PLUGIN_NAME_) ?>
                                        <a href="<?php echo SQ_Classes_RemoteController::getMySquirrlyLink('account') ?>" target="_blank"><?php echo esc_html__("Check Your Account", _SQ_PLUGIN_NAME_) ?></a>
                                    </h4>

                                    <h4 class="text-success text-center mt-5 mb-2"><?php echo esc_html__("Add a keyword to Briefcase", _SQ_PLUGIN_NAME_) ?></h4>
                                    <form method="post" class="p-0 m-0">
                                        <div class="col-8 offset-2">
                                            <input type="text" name="keyword" class="form-control mb-2" autofocus value="<?php echo SQ_Classes_Helpers_Tools::getValue('keyword', '') ?>">
                                            <div class="my-2 text-black-50 small text-center"><?php echo esc_html__("It's best if you focus on finding Long-Tail Keywords.", _SQ_PLUGIN_NAME_) ?></div>
                                        </div>
                                        <div class="col-12 mt-3 text-center">
                                            <?php SQ_Classes_Helpers_Tools::setNonce('sq_briefcase_addkeyword', 'sq_nonce'); ?>
                                            <input type="hidden" name="action" value="sq_briefcase_addkeyword"/>
                                            <button type="submit" class="sqd-submit btn btn-success btn-lg px-5">
                                                <?php echo esc_html__("Add to Briefcase", _SQ_PLUGIN_NAME_) ?>
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            <?php } else { ?>
                                <div class="sq_step sq_step1 my-2">
                                    <h4 class="text-success text-center my-4"><?php echo esc_html__("Step 1/4: Enter a starting 2-3 words keyword", _SQ_PLUGIN_NAME_) ?></h4>

                                    <div class="col-8 offset-2">
                                        <h6 class="my-2 text-info">
                                            <strong><?php echo esc_html__("Enter a keyword that matches your business", _SQ_PLUGIN_NAME_) ?>:</strong>
                                        </h6>
                                        <input type="text" name="sq_input_keyword" autofocus class="form-control sq_input_keyword mb-2" value="<?php echo SQ_Classes_Helpers_Tools::getValue('keyword', '') ?>">
                                        <input type="hidden" name="post_id" value="<?php echo SQ_Classes_Helpers_Tools::getValue('post_id', false) ?>">
                                        <div class="my-2 text-black-50 small text-center"><?php echo esc_html__("Focus on finding Long Tail Keywords.", _SQ_PLUGIN_NAME_) ?></div>
                                        <h4 class="sq_research_error text-warning text-center" style="display: none"><?php echo esc_html__("You need to enter a keyword first", _SQ_PLUGIN_NAME_) ?></h4>
                                    </div>
                                    <div class="row col-12 mt-3">
                                        <div class="col-6 text-left">
                                        </div>
                                        <div class="col-6 text-right">
                                            <button type="button" class="sqd-submit btn btn-success btn-lg px-5" onclick="jQuery.sq_steps(2)"><?php echo esc_html__("Next", _SQ_PLUGIN_NAME_) ?> >></button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="sq_step sq_step2 my-2" style="display: none">
                                <h4 class="text-success text-center my-4"><?php echo esc_html__("Step 2/4: Choose a country for your keyword research", _SQ_PLUGIN_NAME_) ?></h4>

                                <div class="col-8 offset-2">
                                    <h6 class="my-2 text-info">
                                        <strong><?php echo esc_html__("Select country", _SQ_PLUGIN_NAME_) ?>:</strong>
                                    </h6>


                                    <select class="form-control" name="sq_select_country">
                                        <option value="com"><?php echo esc_html__("Global Search", _SQ_PLUGIN_NAME_) ?></option>
                                        <?php
                                        if (isset($view->countries) && !empty($view->countries)) {
                                            foreach ($view->countries as $key => $country) {
                                                echo '<option value="' . $key . '" ' . (isset($_COOKIE['sq_country']) && sanitize_text_field($_COOKIE['sq_country']) == $key ? 'selected="selected"' : '') . '>' . $country . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="my-2 text-black-50 small text-center"><?php echo esc_html__("For local SEO you need to select the Country where you run your business", _SQ_PLUGIN_NAME_) ?></div>
                                </div>
                                <div class="row col-12 mt-5">

                                    <div class="col-6 text-left">
                                        <button type="button" class="btn btn-link btn-lg" onclick="location.reload();"><?php echo esc_html__("Start Over", _SQ_PLUGIN_NAME_) ?></button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="sqd-submit btn btn-success btn-lg px-5" onclick="jQuery('.sq_step3').sq_getSuggested();"><?php echo esc_html__("Next", _SQ_PLUGIN_NAME_) ?> >></button>
                                    </div>
                                </div>
                            </div>
                            <div class="sq_step sq_step3  my-2" style="display: none; min-height: 250px">
                                <h4 class="text-success text-center my-4"><?php echo esc_html__("Step 3/4: Select similar keywords from below", _SQ_PLUGIN_NAME_) ?></h4>
                                <div class="text-danger text-center my-4" style="display: none"><?php echo esc_html__("Select up to 3 similar keywords and start the research", _SQ_PLUGIN_NAME_) ?></div>
                                <div class="col-10 offset-1">
                                    <div class="custom-control custom-checkbox">
                                        <div class="row">
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                        </div>
                                        <div class="row">
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                        </div>
                                        <div class="row">
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                        </div>
                                        <div class="row">
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                        </div>
                                        <div class="row">
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                        </div>
                                        <div class="row">
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                        </div>
                                        <div class="row">
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                        </div>
                                        <div class="row">
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                            <div class="sq_suggested col-5 offset-1 mt-2"></div>
                                        </div>
                                    </div>
                                    <h4 class="sq_limit_exceeded text-warning text-center" style="display: none">
                                        <?php echo esc_html__("You've reached your Keyword Research Limit", _SQ_PLUGIN_NAME_) ?>
                                        <a href="<?php echo SQ_Classes_RemoteController::getMySquirrlyLink('account') ?>" target="_blank"><?php echo esc_html__("Check Your Account", _SQ_PLUGIN_NAME_) ?></a>
                                    </h4>
                                    <h4 class="sq_research_error text-warning text-center" style="display: none"><?php echo sprintf(esc_html__("We could not find similar keywords. %sClick on 'Do research'", _SQ_PLUGIN_NAME_), '<br />') ?></h4>
                                </div>
                                <div class="row col-12 mt-5">
                                    <div class="col-4 p-2 text-left">
                                        <button type="button" class="btn btn-link btn-lg" onclick="location.reload();"><?php echo esc_html__("Start Over", _SQ_PLUGIN_NAME_) ?></button>
                                    </div>
                                    <?php if ($view->checkin->subscription_research == 'deep') { ?>
                                        <div class="col-8 mx-0 my-2 p-0 text-right">
                                            <div class="dropdown ">
                                                <button class="btn btn-success btn-lg dropdown-toggle" style="min-width: 280px" type="button" id="add_new_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <?php echo esc_html__("Do research", _SQ_PLUGIN_NAME_); ?>
                                                </button>
                                                <div class="dropdown-menu mt-1" style="min-width: 200px" aria-labelledby="add_new_dropdown">
                                                    <a href="javascript:void(0);" onclick="jQuery('.sq_step4').sq_getResearch(20);" class="dropdown-item py-2" ><?php echo esc_html__("Do research (up to 20 results)", _SQ_PLUGIN_NAME_) ?></a>
                                                    <a href="javascript:void(0);" onclick="jQuery('.sq_step4').sq_getResearch(50);" class="dropdown-item py-2" ><?php echo esc_html__("Do a deep research (up to 50 results)", _SQ_PLUGIN_NAME_) ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-8  mx-0 my-2 p-0 text-right">
                                            <button type="button" class="sqd-submit btn btn-lg btn-success px-5" onclick="jQuery('.sq_step4').sq_getResearch(20);"><?php echo esc_html__("Do research", _SQ_PLUGIN_NAME_) ?> >></button>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                            <div class="sq_step sq_step4 col-12 my-2 px-0" style="display: none; min-height: 230px !important;">
                                <div class="sq_loading_steps" style="display: none; ">
                                    <div class="sq_loading_step1 sq_loading_step"><?php echo esc_html__("Keyword Research in progress. We're doing all of this in real-time. Data is fresh.", _SQ_PLUGIN_NAME_) ?></div>
                                    <div class="sq_loading_step2 sq_loading_step"><?php echo esc_html__("We're now finding 10 alternatives for each keyword you selected.", _SQ_PLUGIN_NAME_) ?></div>
                                    <div class="sq_loading_step3 sq_loading_step"><?php echo esc_html__("For each alternative, we are looking at the top 10 pages ranked on Google for that keyword.", _SQ_PLUGIN_NAME_) ?></div>
                                    <div class="sq_loading_step4 sq_loading_step"><?php echo esc_html__("We are now measuring the web authority of each competing page and comparing it to yours.", _SQ_PLUGIN_NAME_) ?></div>
                                    <div class="sq_loading_step5 sq_loading_step"><?php echo esc_html__("Looking at the monthly search volume for each keyword.", _SQ_PLUGIN_NAME_) ?></div>
                                    <div class="sq_loading_step6 sq_loading_step"><?php echo esc_html__("Analyzing the last 30 days of Google trends for each keyword.", _SQ_PLUGIN_NAME_) ?></div>
                                    <div class="sq_loading_step7 sq_loading_step"><?php echo esc_html__("Seeing how many discussions there are on forums and Twitter for each keyword.", _SQ_PLUGIN_NAME_) ?></div>
                                    <div class="sq_loading_step8 sq_loading_step"><?php echo esc_html__("Piecing all the keywords together now after analyzing each individual keyword.", _SQ_PLUGIN_NAME_) ?></div>
                                    <div class="sq_loading_step9 sq_loading_step"><?php echo esc_html__("Preparing the results.", _SQ_PLUGIN_NAME_) ?></div>

                                    <div class="center-block mx-auto my-4 text-center" style="max-width: 700px;">
                                        <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/kr_multiple.png' ?>" style="width: 100%">
                                    </div>
                                </div>
                                <h4 class="sq_research_success text-success text-center my-2" style="display: none"><?php echo esc_html__("Step 4/4: We found some relevant keywords for you", _SQ_PLUGIN_NAME_) ?></h4>
                                <h4 class="sq_research_timeout_error text-warning text-center" style="display: none"><?php echo sprintf(esc_html__("Still processing. give it a bit more time, then go to %sResearch History%s. Results will appear there.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'history') . '" >', '</a>') ?></h4>
                                <h4 class="sq_research_error text-warning text-center" style="display: none"><?php echo esc_html__("Step 4/4: We could not find relevant keywords for you", _SQ_PLUGIN_NAME_) ?></h4>

                                <div class="p-1">
                                    <table class="table table-striped table-hover" style="display: none">
                                    <thead>
                                    <tr>
                                        <th><?php echo esc_html__("Keyword", _SQ_PLUGIN_NAME_) ?></th>
                                        <th title="<?php echo esc_html__("Country", _SQ_PLUGIN_NAME_) ?>"><?php echo esc_html__("Co", _SQ_PLUGIN_NAME_) ?></th>
                                        <th>
                                            <i class="fa fa-users" title="<?php echo esc_html__("Competition", _SQ_PLUGIN_NAME_) ?>"></i>
                                            <?php echo esc_html__("Competition", _SQ_PLUGIN_NAME_) ?>
                                        </th>
                                        <th>
                                            <i class="fa fa-search" title="<?php echo esc_html__("SEO Search Volume", _SQ_PLUGIN_NAME_) ?>"></i>
                                            <?php echo esc_html__("Search", _SQ_PLUGIN_NAME_) ?>
                                        </th>
                                        <th>
                                            <i class="fa fa-comments-o" title="<?php echo esc_html__("Recent discussions", _SQ_PLUGIN_NAME_) ?>"></i>
                                            <?php echo esc_html__("Discussion", _SQ_PLUGIN_NAME_) ?>
                                        </th>
                                        <th>
                                            <i class="fa fa-bar-chart" title="<?php echo esc_html__("Trending", _SQ_PLUGIN_NAME_) ?>"></i>
                                            <?php echo esc_html__("Trend", _SQ_PLUGIN_NAME_) ?>
                                        </th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6 p-2 text-left">
                                        <button type="button" class="btn btn-link btn-lg" onclick="location.reload();"><?php echo esc_html__("Start Over", _SQ_PLUGIN_NAME_) ?></button>
                                    </div>
                                    <div class="col-6 text-right">

                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>

                <div class="col-12 text-center m-3">
                    <a href="https://howto.squirrly.co/wordpress-seo/journey-to-better-ranking-day-2/" target="_blank"><?php echo esc_html__("How to Find Amazing Keywords and get more search traffic?", _SQ_PLUGIN_NAME_) ?></a>
                </div>
            </div>
            <div class="sq_col_side sticky">
                <div class="card col-12 p-0">
                    <div class="card-body f-gray-dark p-0">
                        <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                        <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                    </div>


                </div>

                <div class="card col-12 border-0 p-2 text-center">
                    <h5 class="modal-title mb-3"><?php echo esc_html__("Already Have Keywords?", _SQ_PLUGIN_NAME_); ?></h5>

                    <div>
                        <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') ?>" class="btn rounded-0 btn-success px-2 mx-2"><?php echo esc_html__("Import Keywords From CSV", _SQ_PLUGIN_NAME_); ?></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>