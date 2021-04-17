<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_toolbarblog" class="col-12 m-0 p-0">
    <nav class="navbar navbar-expand-sm" color-on-scroll="500">
        <div class="container-fluid px-0">
            <div class="justify-content-start" id="navigation">
                <ul class="nav navbar-nav mr-auto">
                    <?php
                    $visitedmenu = false;
                    $mainmenu = SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getMainMenu();
                    if (SQ_Classes_Helpers_Tools::getOption('sq_api') <> '' && SQ_Classes_Helpers_Tools::getOption('sq_onboarding') == SQ_VERSION) {
                        $visitedmenu = SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getVisitedMenu();
                    }
                    $errors = apply_filters('sq_seo_errors', 0);

                    if (!empty($mainmenu)) {
                        foreach ($mainmenu as $menuid => $item) {

                            //Check if the menu item is visible on the top
                            if (isset($item['topmenu']) && !$item['topmenu']) {
                                continue;
                            }

                            //make sure the user has the capabilities
                            if (current_user_can($item['capability'])) {
                                if ($menuid <> 'sq_dashboard') {
                                    ?>
                                    <li class="nav-item">
                                        <svg class="separator mx-2" height="40" width="2" xmlns="http://www.w3.org/2000/svg">
                                            <line stroke="#92b7cc" stroke-width="2" x1="0" x2="0" y1="0" y2="40"></line>
                                        </svg>
                                    </li>
                                <?php } ?>
                                <?php $page = apply_filters('sq_page', SQ_Classes_Helpers_Tools::getValue('page', false)); ?>
                                <li class="nav-item <?php echo(($page == $menuid) ? 'active' : '') ?>">
                                    <a class="nav-link" href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl($menuid) ?>">
                                        <?php echo($menuid == 'sq_dashboard' ? esc_html__("Overview", _SQ_PLUGIN_NAME_) : $item['title']) ?>
                                        <?php echo(($menuid == 'sq_dashboard' && $page <> $menuid && $errors) ? '<span class="sq_errorcount">' . (int)$errors . '</span>' : '') ?>
                                    </a>

                                </li>
                            <?php }
                        }
                    } ?>
                    <li class="sq_help_toolbar">
                        <i class="fa fa-search" onclick="jQuery('.header-search').toggle();"></i>
                    </li>
                </ul>
            </div>
        </div>
        <div id="sq_btn_toolbar_close" class="m-0 p-0">
            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_dashboard') ?>" class="btn btn-lg bg-white text-black m-0 mx-2 p-2 px-3 font-weight-bold">X</a>
        </div>
    </nav>
</div>
<noscript>
    <div class="alert-danger text-center py-3"><?php echo esc_html__("Javascript is disabled on your browser! You need to activate the javascript in order to use Squirrly SEO.", _SQ_PLUGIN_NAME_); ?></div>
    <style>
        #sq_wrap #sq_focuspages .sq_overflow {
            display: block !important;
            max-width: 960px;
        }

        .sq_alert {
            top: 0;
            max-height: 50px;
            line-height: 20px;
        }</style>
</noscript>
<?php SQ_Classes_ObjController::getClass('SQ_Core_BlockSearch')->init(); ?>
