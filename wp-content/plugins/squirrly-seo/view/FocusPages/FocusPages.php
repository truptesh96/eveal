<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php
if (!empty($view->focuspages)) { ?>
    <?php if (SQ_Classes_Helpers_Tools::getValue('slabel', false) || SQ_Classes_Helpers_Tools::getValue('sid', false)) { ?>
        <div class="form-group text-right col-12 p-0 m-0">
            <div class="sq_serp_settings_button mx-2 my-0 p-0" style="margin-top:-70px !important">
                <button type="button" class="btn btn-info p-v-xs" onclick="location.href = '<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'pagelist') ?>';" style="cursor: pointer"><?php echo esc_html__("Show All", _SQ_PLUGIN_NAME_) ?></button>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($view->labels) && !empty($view->labels)) {
        $keyword_labels = SQ_Classes_Helpers_Tools::getValue('slabel', array());

        ?>
        <div class="row p-3">
            <form method="get" class="form-inline col-12 ignore">
                <input type="hidden" name="page" value="<?php echo SQ_Classes_Helpers_Tools::getValue('page') ?>">
                <input type="hidden" name="tab" value="<?php echo SQ_Classes_Helpers_Tools::getValue('tab') ?>">
                <div class="col-12 p-0">
                    <h3 class="card-title text-dark p-2" style="line-height: 30px; font-size: 22px;"><?php echo esc_html__("Current Ranking Drawbacks", _SQ_PLUGIN_NAME_); ?></h3>
                </div>

                <div class="sq_filter_label p-2">
                    <?php
                    foreach ($view->labels as $category => $label) {
                        if ($label->show) {
                            ?>
                            <input type="checkbox" name="slabel[]" class="sq_circle_label_input" id="search_checkbox_<?php echo esc_attr($category) ?>" style="display: none;" value="<?php echo esc_attr($category) ?>" <?php echo(in_array((string)$category, (array)$keyword_labels) ? 'checked' : '') ?> />
                            <label for="search_checkbox_<?php echo esc_attr($category) ?>" class="sq_circle_label fa <?php echo(in_array((string)$category, (array)$keyword_labels) ? 'sq_active' : '') ?>" data-id="<?php echo esc_attr($category) ?>" style="background-color: <?php echo esc_attr($label->color) ?>" title="<?php echo esc_attr($label->name) ?>"><?php echo esc_html($label->name) ?></label>
                            <?php
                        }
                    }
                    ?>
                </div>
            </form>
        </div>
        <?php
    } ?>

    <div class="card-body p-0 position-relative">
        <?php if (!SQ_Classes_Helpers_Tools::getValue('sid', false)) { ?>
            <div class="btn btn-round position-absolute sq_overflow_arrow_left">
                <i class="fa fa-arrow-circle-left"></i>
            </div>
            <div class="btn btn-round position-absolute sq_overflow_arrow_right">
                <i class="fa fa-arrow-circle-right"></i>
            </div>
        <?php } ?>
        <div class="<?php echo(!SQ_Classes_Helpers_Tools::getValue('sid', false) ? 'sq_overflow' : '') ?> col-12 m-0 my-2 px-2 py-0 flexcroll" <?php echo(!SQ_Classes_Helpers_Tools::getValue('sid', false) ? 'style="max-height: 590px;"' : '') ?>>
            <div class="card col-12 my-0 p-0 border-0 " style="display: inline-block;">
                <table class="table table-striped table-hover <?php echo(SQ_Classes_Helpers_Tools::getValue('sid', false) ? 'detailed' : '') ?>">
                    <thead>
                    <tr>
                        <th><?php echo esc_html__("Permalink", _SQ_PLUGIN_NAME_) ?></th>
                        <th><?php echo esc_html__("Chance to Rank", _SQ_PLUGIN_NAME_) ?></th>
                        <?php
                        $categories = SQ_Classes_ObjController::getClass('SQ_Models_FocusPages')->getCategories();
                        $keyword_labels = SQ_Classes_Helpers_Tools::getValue('slabel', array());

                        foreach ($categories as $name => $title) {
                            $class = '';
                            if (!empty($keyword_labels) && !in_array($name, (array)$keyword_labels)) {
                                $class = 'hidden';
                            }
                            ?>
                            <th class="text-center <?php echo esc_attr($class) ?>"><?php echo esc_html($title) ?></th>
                        <?php } ?>
                        <th style="width: 10px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($view->focuspages)) {
                        foreach ($view->focuspages as $index => $focuspage) {
                            $view->focuspage = $focuspage;

                            if (isset($view->focuspage->id) && $view->focuspage->id <> '') {

                                $view->post = $view->focuspage->getWppost();
                                if (!current_user_can('sq_manage_focuspages')) continue;
                                if (!empty($keyword_labels) && $view->focuspage->audit_error) {
                                    continue;
                                }

                                $class = ($index % 2 ? 'even' : 'odd');

                                ?>
                                <tr id="sq_row_<?php echo esc_attr($focuspage->id) ?>" class="<?php echo esc_attr($class) ?>">
                                    <?php echo $view->getView('FocusPages/FocusPageRow'); ?>
                                </tr>
                                <?php
                            }
                        }
                    } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
<?php } elseif (SQ_Classes_Helpers_Tools::getValue('slabel', false) || SQ_Classes_Helpers_Tools::getValue('sid', false)) { ?>
    <div class="card-body">
        <h4 class="text-center"><?php echo sprintf(esc_html__("No data for this filter. %sShow All%s Focus Pages.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'pagelist') . '" >', '</a>') ?></h4>
    </div>
<?php } elseif (!SQ_Classes_Error::isError()) { ?>
    <div class="card-body">
        <h4 class="text-center"><?php echo esc_html__("Welcome to Focus Pages", _SQ_PLUGIN_NAME_); ?></h4>
        <div class="col-12 m-2 text-center">
            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_focuspages', 'addpage') ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-square-o"></i> <?php echo esc_html__("Add a new page as Focus Page to get started", _SQ_PLUGIN_NAME_); ?>
            </a>
        </div>
        <div class="col-12 mt-5 mx-2">
            <h5 class="text-left my-3 text-info"><?php echo esc_html__("Tips: Which Page Should I Choose?", _SQ_PLUGIN_NAME_); ?></h5>
            <ul>
                <li style="font-size: 15px;"><?php echo esc_html__("One of the most important pages in your website, you money-makers, the pages that bring you conversions.", _SQ_PLUGIN_NAME_); ?></li>
                <li style="font-size: 15px;"><?php echo esc_html__("Don't choose your Home Page, Contact Page or About Use page.", _SQ_PLUGIN_NAME_); ?></li>
            </ul>
        </div>
    </div>
<?php } else { ?>
    <div class="card-body">
        <div class="col-12 px-2 py-3 text-center">
            <img src="<?php echo _SQ_ASSETS_URL_ . 'img/settings/noconnection.jpg' ?>" style="width: 300px">
        </div>
        <div class="col-12 m-2 text-center">
            <div class="col-12 alert alert-success text-center m-0 p-3">
                <i class="fa fa-exclamation-triangle" style="font-size: 18px !important;"></i> <?php echo sprintf(esc_html__("There is a connection error with Squirrly Cloud. Please check the connection and %srefresh the page%s.", _SQ_PLUGIN_NAME_), '<a href="javascript:void(0);" onclick="location.reload();" >', '</a>') ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php
if (!empty($view->focuspages)) {
    foreach ($view->focuspages as $focuspage) {
        if (isset($focuspage->id)) { ?>
            <div id="sq_assistant_<?php echo esc_attr($focuspage->id) ?>" class="sq_assistant">
                <?php
                $categories = apply_filters('sq_assistant_categories_page', $focuspage->id);
                //SQ_Debug::dump($categories);
                if (!empty($categories)) {
                    foreach ($categories as $index => $category) {
                        if (isset($category->assistant)) {
                            echo (string)$category->assistant;
                        }
                    }
                }
                ?>
            </div>
        <?php
            //get the keywords modal based on the focus page
            echo SQ_Classes_ObjController::getClass('SQ_Models_Assistant')->getKeywordsModal($focuspage);
        } ?>
    <?php }
} ?>
