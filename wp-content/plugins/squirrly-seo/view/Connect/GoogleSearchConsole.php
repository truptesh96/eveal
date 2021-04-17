<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<?php $connect = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('connect'))); ?>
<div class="ga-connect-place">
    <?php if ($connect->google_search_console) { ?>
        <div class="card col-12 bg-googlesc px-0 py-0 mb-2 mx-0">
            <div class="card-heading my-2">
                <h3 class="card-title text-white">
                    <div class="google-icon fa fa-google mx-2"></div><?php echo esc_html__("Google Search Console", _SQ_PLUGIN_NAME_); ?>
                </h3>
            </div>
            <div class="card-body bg-light py-3">
                <div class="row">
                    <h6 class="col-7 py-3 m-0  text-black-50"><?php echo esc_html__("You are connected to Google Search Console", _SQ_PLUGIN_NAME_) ?></h6>
                    <div class="col-5">
                        <form method="post" class="p-0 m-0" onsubmit="if(!confirm('Are you sure?')){return false;}">
                            <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_gsc_revoke', 'sq_nonce'); ?>
                            <input type="hidden" name="action" value="sq_seosettings_gsc_revoke"/>
                            <button type="submit" class="btn btn-block btn-social btn-google text-info btn-lg">
                                <?php echo esc_html__("Disconnect", _SQ_PLUGIN_NAME_) ?>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    <?php } else { ?>
        <div class="col-12 bg-googlesc py-2 mb-2">
            <div class="col-12">
                <h4 class="text-white py-3"><?php echo esc_html__("Connect this site to Google Search Console", _SQ_PLUGIN_NAME_); ?></h4>
                <p><?php echo esc_html__("Connect Google Search Console and get traffic insights for your website on each Audit.", _SQ_PLUGIN_NAME_) ?></p>
                <p><?php echo sprintf(esc_html__("Need Help Connecting Google Search Console? %sClick Here%s", _SQ_PLUGIN_NAME_), '<a href="https://howto.squirrly.co/faq/need-help-connecting-google-search-console-both-tracking-code-and-api-connection/" target="_blank" style="color: lightyellow; text-decoration: underline">', '</a>') ?></p>
            </div>
            <div class="sq_step1 mt-1">
                <a href="<?php echo SQ_Classes_RemoteController::getApiLink('gscoauth'); ?>" onclick="jQuery('.sq_step1').hide();jQuery('.sq_step2').show();" target="_blank" type="button" class="btn btn-block btn-social btn-google text-info connect-button connect btn-lg">
                    <span class="fa fa-google"></span> <?php echo esc_html__("Sign in", _SQ_PLUGIN_NAME_); ?>
                </a>
            </div>
            <div class="sq_step2 mt-1" style="display: none">
                <form method="post" class="p-0 m-0">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_gsc_check', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_gsc_check"/>
                    <button type="submit" class="btn btn-block btn-social btn-warning btn-lg">
                        <span class="fa fa-google"></span> <?php echo esc_html__("Check connection", _SQ_PLUGIN_NAME_); ?>
                    </button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>