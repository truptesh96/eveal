<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php $tab = SQ_Classes_Helpers_Tools::getValue('tab', 'register'); ?>
<div class="card col-12 p-0 border-0">
    <div class="card-body">
        <?php if ($tab == 'login') { ?>
            <form method="post" >
                <?php SQ_Classes_Helpers_Tools::setNonce('sq_login', 'sq_nonce'); ?>
                <input type="hidden" name="action" value="sq_login"/>
                <div class="form-group">
                    <label for="email"><?php echo esc_html__("Email", _SQ_PLUGIN_NAME_) . ': '; ?></label>
                    <input type="email" class="form-control" autofocus name="email">
                </div>
                <div class="form-group">
                    <label for="pwd"><?php echo esc_html__("Password", _SQ_PLUGIN_NAME_) . ': '; ?></label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl(SQ_Classes_Helpers_Tools::getValue('page','sq_dashboard'), 'register') ?>"><?php echo esc_html__("Register to Squirrly.co", _SQ_PLUGIN_NAME_); ?></a> |
                    <a href="<?php echo _SQ_DASH_URL_ . '/login?action=lostpassword' ?>" target="_blank" title="<?php echo esc_html__("Lost password?", _SQ_PLUGIN_NAME_); ?>"><?php echo esc_html__("Lost password", _SQ_PLUGIN_NAME_); ?></a>
                </div>
                <button type="submit" class="btn btn-lg btn-primary"><?php echo esc_html__("Login", _SQ_PLUGIN_NAME_); ?></button>
            </form>
        <?php } else { ?>
            <form id="sq_register" method="post">
                <?php SQ_Classes_Helpers_Tools::setNonce('sq_register', 'sq_nonce'); ?>
                <input type="hidden" name="action" value="sq_register"/>
                <div class="form-group">
                    <label for="email"><?php echo esc_html__("Email", _SQ_PLUGIN_NAME_) . ': '; ?></label>
                    <input type="email" class="form-control" name="email" autofocus value="<?php
                    $current_user = wp_get_current_user();
                    echo sanitize_email($current_user->user_email);
                    ?>">
                </div>
                <div class="form-group">
                    <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl(SQ_Classes_Helpers_Tools::getValue('page','sq_dashboard'), 'login') ?>"><?php echo esc_html__("I already have an account", _SQ_PLUGIN_NAME_); ?></a>
                </div>
                <div class="form-group">
                    <input type="checkbox" required id="sq_terms" style="height: 18px;width: 18px; margin: 0 10px;"/><?php echo sprintf(esc_html__("I Agree with the Squirrly %sTerms of Use%s and %sPrivacy Policy%s", _SQ_PLUGIN_NAME_), '<a href="https://www.squirrly.co/terms-of-use" target="_blank" >', '</a>', '<a href="https://www.squirrly.co/privacy-policy" target="_blank" >', '</a>'); ?>
                </div>
                <button type="submit" class="btn btn-lg btn-primary noloading"><?php echo esc_html__("Sign Up", _SQ_PLUGIN_NAME_); ?></button>
            </form>
        <?php } ?>

    </div>

</div>