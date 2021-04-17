<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php
$whole = $decimal = 0;
if (isset($view->checkin->subscription_devkit) && $view->checkin->subscription_devkit) {
    ?>
    <div class="card-text col-12 p-0 m-0 border-0">
        <div class="author">
            <i class="avatar sq_icons sq_icon_package"></i>
        </div>
        <div class="title mt-4 mb-0 text-center">
            <h6><?php echo esc_html__("Account Info Unavailable", _SQ_PLUGIN_NAME_) ?></h6>
        </div>
    </div>
    <?php
    return;
}
if (isset($view->checkin->product_price) && (int)$view->checkin->product_price > 0) {
    list($whole, $decimal) = explode('.', number_format($view->checkin->product_price, 2, '.', ','));
}
if (isset($view->checkin->subscription_status) && isset($view->checkin->product_name)) {
    if ($view->checkin->subscription_status == 'active' && $view->checkin->product_name == 'Free') {
        $view->checkin->product_name = 'Free + Bonus';
    }
}
?>
<?php if (SQ_Classes_Helpers_Tools::getMenuVisible('show_panel') && current_user_can('manage_options')) { ?>
    <div class="card-text col-12 p-0 m-0 border-0">
        <div class="author">
            <i class="avatar sq_icons sq_icon_package"></i>
        </div>
        <div class="block block-pricing text-center">
            <h1 class="block-caption mt-2">
                <small class="power">$</small>
                <?php echo (int)$whole ?>
                <small class="power"><?php echo((int)$decimal > 0 ? (int)$decimal : '00') ?></small>
                <small><?php echo((int)$view->checkin->subscription_months == 1 ? '/mo' : ((int)$view->checkin->subscription_months == 12 ? '/year' : '')) ?></small>

            </h1>
        </div>
        <div class="title mt-4 mb-0 text-center">
            <ul class="p-0 m-0">
                <?php if (isset($view->checkin->product_name)) { ?>
                    <li>
                        <?php echo esc_html__("Your Plan", _SQ_PLUGIN_NAME_) . ': ' ?>
                        <a href="<?php echo SQ_Classes_RemoteController::getMySquirrlyLink('account') ?>" title="<?php echo esc_html__("Check Account Info", _SQ_PLUGIN_NAME_) ?>" target="_blank"><strong style="font-size: 17px; color: #f7681b;"><?php echo (string)$view->checkin->product_name ?></strong></a>
                    </li>
                <?php } ?>
                <?php if (isset($view->checkin->subscription_email)) { ?>
                    <li>
                        <?php echo esc_html__("Email", _SQ_PLUGIN_NAME_) . ": "?>
                        <strong><?php echo sanitize_email($view->checkin->subscription_email) ?></strong>
                    </li>
                <?php } ?>
                <?php if (isset($view->checkin->subscription_paid) && isset($view->checkin->subscription_expires) && $view->checkin->subscription_paid && $view->checkin->subscription_expires) { ?>
                    <li>
                        <?php echo sprintf(esc_html__("Due Date: %s", _SQ_PLUGIN_NAME_), '<strong ' . ((time() - strtotime($view->checkin->subscription_expires) > 0) ? 'style="color:red"' : '') . '>' . date('d M Y', strtotime($view->checkin->subscription_expires)) . ' </strong>'); ?>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="bg-light border-top py-2 mt-2 text-center">
            <h6><?php echo esc_html__("Want to see the rest of the sites under your account?", _SQ_PLUGIN_NAME_) ?></h6>
            <a href="<?php echo SQ_Classes_RemoteController::getMySquirrlyLink('dashboard') ?>" target="_blank"><?php echo esc_html__("Click Here", _SQ_PLUGIN_NAME_) ?> >></a>
        </div>
    </div>
<?php }