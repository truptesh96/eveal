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
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_advanced', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_advanced"/>

                    <div class="card col-12 p-0">
                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-12 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_settings_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php echo esc_html__("Advanced Settings", _SQ_PLUGIN_NAME_); ?>
                                    <div class="sq_help_question d-inline">
                                        <a href="https://howto.squirrly.co/kb/advanced-seo-settings/" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                    </div>
                                </h3>
                            </div>

                        </div>

                        <div id="sq_seosettings" class="card col-12 p-0 m-0 border-0 tab-panel border-0">
                            <div class="card-body p-0 ">
                                <div class="col-12 m-0 p-0">
                                    <div class="card col-12 p-0 border-0 ">
                                        <div class="col-12 row mb-1 ml-1">
                                            <div class="checker col-12 row my-2 py-1">
                                                <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_load_css" value="0"/>
                                                    <input type="checkbox" id="sq_load_css" name="sq_load_css" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_load_css') ? 'checked="checked"' : '') ?> value="1"/>
                                                    <label for="sq_load_css" class="ml-2"><?php echo esc_html__("Load Squirrly Frontend CSS", _SQ_PLUGIN_NAME_); ?>
                                                        <a href="https://howto.squirrly.co/kb/website-favicon-settings/#frontend_css" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="offset-1 small text-black-50"><?php echo esc_html__("Load Squirrly SEO CSS for Twitter and Article inserted from Squirrly Blogging Assistant.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 row mb-1 ml-1">
                                            <div class="checker col-12 row my-2 py-1">
                                                <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_minify" value="0"/>
                                                    <input type="checkbox" id="sq_minify" name="sq_minify" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_minify') ? 'checked="checked"' : '') ?> value="1"/>
                                                    <label for="sq_minify" class="ml-2"><?php echo esc_html__("Minify Squirrly SEO Metas", _SQ_PLUGIN_NAME_); ?>
                                                        <a href="https://howto.squirrly.co/kb/website-favicon-settings/#minify_metas" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="offset-1 small text-black-50"><?php echo esc_html__("Minify the metas in source code to optimize the page loading.", _SQ_PLUGIN_NAME_); ?></div>
                                                    <div class="offset-1 small text-black-50"><?php echo esc_html__("Remove comments and newlines from Squirrly SEO Metas.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12 row mb-1 ml-1">
                                            <div class="checker col-12 row my-2 py-1">
                                                <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_laterload" value="0"/>
                                                    <input type="checkbox" id="sq_laterload" name="sq_laterload" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_laterload') ? 'checked="checked"' : '') ?> value="1"/>
                                                    <label for="sq_laterload" class="ml-2"><?php echo esc_html__("Squirrly SEO Late Buffer", _SQ_PLUGIN_NAME_); ?>
                                                        <a href="https://howto.squirrly.co/kb/website-favicon-settings/#late_loading_buffer" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="offset-1 small text-black-50"><?php echo esc_html__("Wait all plugins to load before loading Squirrly SEO frontend buffer.", _SQ_PLUGIN_NAME_); ?></div>
                                                    <div class="offset-1 small text-black-50"><?php echo esc_html__("For compatibility with some Cache and CDN plugins.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sq_separator my-3"></div>

                                        <div class="col-12 row mb-1 ml-1">
                                            <div class="checker col-12 row my-2 py-1">
                                                <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_complete_uninstall" value="0"/>
                                                    <input type="checkbox" id="sq_complete_uninstall" name="sq_complete_uninstall" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_complete_uninstall') ? 'checked="checked"' : '') ?> value="1"/>
                                                    <label for="sq_complete_uninstall" class="ml-2"><?php echo esc_html__("Delete Squirrly SEO Table on Uninstall", _SQ_PLUGIN_NAME_); ?>
                                                        <a href="https://howto.squirrly.co/kb/website-favicon-settings/#delete_uninstall" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="offset-1 small text-black-50"><?php echo esc_html__("Delete Squirrly SEO table and options on uninstall.", _SQ_PLUGIN_NAME_); ?></div>
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
