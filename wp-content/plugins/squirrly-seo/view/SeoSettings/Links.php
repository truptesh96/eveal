<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_settings')) {
            echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_) . '</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_seosettings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">

                <?php do_action('sq_form_notices'); ?>
                <form method="POST">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_links', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_links"/>

                    <div class="card col-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top row">
                            <div class="col-7 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_links_icon m-2"></div>
                                </div>
                                <h3 class="card-title"><?php echo esc_html__("SEO Links", _SQ_PLUGIN_NAME_); ?>
                                    <div class="sq_help_question d-inline">
                                        <a href="https://howto.squirrly.co/kb/seo-links/" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                    </div>
                                </h3>
                                <div class="col-12 text-left m-0 p-0">
                                    <div class="card-title-description m-2"><?php echo esc_html__("Increase the website authority by not sending authority to all external links.", _SQ_PLUGIN_NAME_); ?></div>
                                </div>
                            </div>
                            <div class="col-5 text-right">
                                <div class="checker row my-4 py-2 mx-0 px-0 justify-content-end">
                                    <div class="sq-switch redgreen sq-switch-sm ">
                                        <label for="sq_auto_links" class="mr-2"><?php echo esc_html__("Activate SEO Metas", _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_links" value="0"/>
                                        <input type="checkbox" id="sq_auto_links" name="sq_auto_links" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_links') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_links"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="sq_seosettings" class="card col-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_links') ? '' : 'sq_deactivated') ?>">

                            <div class="card-body p-0">
                                <div class="col-12 m-0 p-0">
                                    <div class="card col-12 p-0 border-0">

                                        <div class="col-12 py-2 tab-panel">
                                            <div class="col-12 row my-3 ml-1 h-100">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_attachment_redirect" value="0"/>
                                                        <input type="checkbox" id="sq_attachment_redirect" name="sq_attachment_redirect" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_attachment_redirect') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_attachment_redirect" class="ml-2"><?php echo esc_html__("Redirect Attachments Page", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/seo-links/#redirect_attachments" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Redirect the attachment page to its image URL.", _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Recommended if your website is not a photography website.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row my-3 ml-1 h-100">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_external_nofollow" value="0"/>
                                                        <input type="checkbox" id="sq_external_nofollow" name="sq_external_nofollow" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_external_nofollow') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_external_nofollow" class="ml-2"><?php echo esc_html__("Add Nofollow to external links", _SQ_PLUGIN_NAME_); ?> (BETA)
                                                            <a href="https://howto.squirrly.co/kb/seo-links/#nofollow_external" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add the 'nofollow' attribute to all external links and stop losing authority.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row my-3 ml-1 h-100">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_external_blank" value="0"/>
                                                        <input type="checkbox" id="sq_external_blank" name="sq_external_blank" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_external_blank') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_external_blank" class="ml-2"><?php echo esc_html__("Open external links in New Tab", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/seo-links/#newtab_external" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add the '_blank' attribute to all external links to open them in a new tab.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row py-2 mx-0 mt-5 h-100">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Domain Exception", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/seo-links/#external_domain_exception" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo esc_html__("Add external links for who you don't want to apply the nofollow.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-6 p-0 form-group">
                                                    <textarea class="form-control" name="links_permission" rows="5"><?php echo implode(PHP_EOL, (array)SQ_Classes_Helpers_Tools::getOption('sq_external_exception')); ?></textarea>
                                                </div>
                                            </div>


                                        </div>



                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-12 p-0 py-3 bg-light">
                            <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php echo esc_html__("Save Settings", _SQ_PLUGIN_NAME_); ?></button>
                        </div>
                    </div>


                </form>

                <div class="card col-12 p-0 mt-4">
                    <div class="bg-title border-top p-2">
                        <h3 class="card-title"><?php echo esc_html__("Redirect Broken URLs", _SQ_PLUGIN_NAME_); ?></h3>
                    </div>
                    <div class="card-body">

                        <div class="col-12 m-4 text-center">
                            <a href="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') ?>" class="btn btn-lg btn-primary">
                                <i class="fa fa-link"></i> <?php echo esc_html__("Manage redirects for each Post Type", _SQ_PLUGIN_NAME_); ?>
                            </a>
                        </div>

                        <div class="col-12 mt-5 mx-2">
                            <h5 class="text-left my-4 text-info"><?php echo esc_html__("Tips: How to redirect broken URLs?", _SQ_PLUGIN_NAME_); ?></h5>
                            <ul class="mx-3">
                                <li style="font-size: 15px; list-style: initial;"><?php echo sprintf(esc_html__("Use the %s SEO Automation %s to setup the broken URLs redirect if you change a post/page slug.", _SQ_PLUGIN_NAME_),'<a href="'.SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation').'">','</a>'); ?></li>
                                <li style="font-size: 15px; list-style: initial;"><?php echo esc_html__("Squirrly SEO will add a 301 redirect to the new slug without losing any SEO authority.", _SQ_PLUGIN_NAME_); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sq_col_side sticky">
                <div class="card col-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
