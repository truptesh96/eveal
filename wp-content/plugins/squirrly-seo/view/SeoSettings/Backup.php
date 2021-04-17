<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_settings')) {
            echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__("You do not have permission to access this page. You need Squirrly SEO Admin role", _SQ_PLUGIN_NAME_) . '</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_seosettings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">
                <?php do_action('sq_form_notices'); ?>


                <div class="card col-12 p-0">
                    <div class="card-body p-2 bg-title rounded-top  row">
                        <div class="col-12 text-left m-0 p-0">
                            <div class="sq_icons_content p-3 py-4" style="min-height: 150px">
                                <div class="sq_icons sq_settings_icon m-2"></div>
                            </div>
                            <h3 class="card-title"><?php echo esc_html__("Import Settings & SEO", _SQ_PLUGIN_NAME_); ?>
                                <div class="sq_help_question d-inline">
                                    <a href="https://howto.squirrly.co/kb/import-export-seo-settings/#import_seo" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                </div>
                            </h3>
                            <div class="col-12 text-left m-0 p-0">
                                <div class="card-title-description m-2"><?php echo esc_html__("Import the settings and SEO from other plugins so you can use only Squirrly SEO for on-page SEO.", _SQ_PLUGIN_NAME_); ?></div>
                                <div class="card-title-description m-2"><?php echo esc_html__("Note! If you import the SEO settings from other plugins or themes, you will lose all the settings that you had in Squirrly SEO. Make sure you backup your settings from the panel below before you do this.", _SQ_PLUGIN_NAME_); ?></div>
                            </div>
                        </div>


                    </div>

                    <?php $platforms = apply_filters('sq_importList', false); ?>
                    <div id="sq_seosettings" class="card col-12 p-0 m-0 border-0 tab-panel border-0">
                        <div class="card-body p-0">
                            <div class="col-12 m-0 p-0">
                                <div class="card col-12 p-0 border-0 ">

                                    <div class="col-12 pt-0 pb-4 border-bottom tab-panel">
                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php echo esc_html__("Import Settings From", _SQ_PLUGIN_NAME_); ?>:
                                                    </div>
                                                    <div class="small text-black-50"><?php echo esc_html__("Select the plugin or theme you want to import the Settings from.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group">
                                                    <?php
                                                    if ($platforms && count((array)$platforms) > 0) {
                                                        ?>
                                                        <select name="sq_import_platform" class="form-control bg-input mb-1">
                                                            <?php
                                                            foreach ($platforms as $path => $settings) {
                                                                ?>
                                                                <option value="<?php echo esc_attr($path) ?>"><?php echo ucfirst(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($path)); ?></option>
                                                            <?php } ?>
                                                        </select>

                                                        <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_importsettings', 'sq_nonce'); ?>
                                                        <input type="hidden" name="action" value="sq_seosettings_importsettings"/>
                                                        <button type="submit" class="btn rounded-0 btn-success px-2 mx-2" style="min-width: 140px"><?php echo esc_html__("Import Settings", _SQ_PLUGIN_NAME_); ?></button>
                                                        <div class="col-12 p-0 m-0">
                                                            <div class="small text-danger"><?php echo esc_html__("Note! It will overwrite the settings you set in Squirrly SEO.", _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12 my-2"><?php echo esc_html__("We couldn't find any SEO plugin or theme to import from.", _SQ_PLUGIN_NAME_); ?></div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php echo esc_html__("Import SEO From", _SQ_PLUGIN_NAME_); ?>:
                                                    </div>
                                                    <div class="small text-black-50"><?php echo esc_html__("Select the plugin or theme you want to import the SEO & Patterns from.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group">
                                                    <?php
                                                    if ($platforms && count((array)$platforms) > 0) {
                                                        ?>
                                                        <select name="sq_import_platform" class="form-control bg-input mb-1">
                                                            <?php
                                                            foreach ($platforms as $path => $settings) {
                                                                ?>
                                                                <option value="<?php echo esc_attr($path) ?>"><?php echo ucfirst(SQ_Classes_ObjController::getClass('SQ_Models_ImportExport')->getName($path)); ?></option>
                                                            <?php } ?>
                                                        </select>

                                                        <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_importseo', 'sq_nonce'); ?>
                                                        <input type="hidden" name="action" value="sq_seosettings_importseo"/>
                                                        <button type="submit" class="btn rounded-0 btn-success px-2 mx-2" style="min-width: 140px"><?php echo esc_html__("Import SEO", _SQ_PLUGIN_NAME_); ?></button>

                                                        <div class="col-12 p-0 m-0">
                                                            <div class="checker m-0 py-2 px-0">
                                                                <div class="sq-switch sq-switch-sm ">
                                                                    <label for="sq_import_overwrite" class="mr-2" style="font-size: 14px;"><?php echo esc_html__("Overwrite all existing SEO Snippets optimizations", _SQ_PLUGIN_NAME_); ?></label for="sq_import_overwrite" >
                                                                    <input type="checkbox" id="sq_import_overwrite" name="sq_import_overwrite" class="sq-switch" value="1"/>
                                                                    <label for="sq_import_overwrite"></label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php } else { ?>
                                                        <div class="col-12 my-2"><?php echo esc_html__("We couldn't find any SEO plugin or theme to import from.", _SQ_PLUGIN_NAME_); ?></div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                    <div class="bg-title p-2">
                                        <h3 class="card-title"><?php echo esc_html__("Backup Settings & SEO", _SQ_PLUGIN_NAME_); ?>
                                            <a href="https://howto.squirrly.co/kb/import-export-seo-settings/#backup_seo" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                        <div class="col-12 text-left m-0 p-0">
                                            <div class="card-title-description mb-0"><?php echo esc_html__("You can now download your Squirrly settings in an sql file before you go ahead and import the SEO settings from another plugin. That way, you can always go back to your Squirrly settings.", _SQ_PLUGIN_NAME_); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 pt-0 pb-4 border-bottom tab-panel">
                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-6 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php echo esc_html__("Backup Settings", _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo esc_html__("Download all the settings from Squirrly SEO.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-6 p-0 input-group">
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_backupsettings', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_backupsettings"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-2 noloading" style="min-width: 175px"><?php echo esc_html__("Download  Backup", _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-6 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php echo esc_html__("Backup SEO", _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo esc_html__("Download all the Squirrly SEO Snippet optimizations.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-6  p-0 input-group">
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_backupseo', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_backupseo"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-2 noloading" style="min-width: 175px"><?php echo esc_html__("Download Backup", _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                            </div>
                                        </form>

                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-6 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php echo esc_html__("Backup Briefcase", _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo esc_html__("Download all Briefcase Keywords.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-6  p-0 input-group">
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_briefcase_backup', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_briefcase_backup"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-2 noloading" style="min-width: 175px"><?php echo esc_html__("Download Backup", _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>

                                    <div class="bg-title p-2">
                                        <h3 class="card-title"><?php echo esc_html__("Restore Settings & SEO", _SQ_PLUGIN_NAME_); ?>
                                            <a href="https://howto.squirrly.co/kb/import-export-seo-settings/#restore_seo" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                        <div class="col-12 text-left m-0 p-0">
                                            <div class="card-title-description mb-0"><?php echo esc_html__("Restore the settings and all the pages optimized with Squirrly SEO.", _SQ_PLUGIN_NAME_); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 pt-0 pb-4 border-bottom tab-panel">
                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row py-2 pr-0 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php echo esc_html__("Restore Settings", _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo esc_html__("Upload the file with the saved Squirrly Settings.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group">
                                                    <div class="form-group my-2">
                                                        <input type="file" class="form-control-file" name="sq_options">
                                                    </div>
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_restoresettings', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_restoresettings"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-1" style="min-width: 140px"><?php echo esc_html__("Restore Settings", _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row py-2 pr-0 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php echo esc_html__("Restore SEO", _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo esc_html__("Upload the file with the saved Squirrly SEO SQL file.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group">
                                                    <div class="form-group my-2">
                                                        <input type="file" class="form-control-file" name="sq_sql">
                                                    </div>
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_restoreseo', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_seosettings_restoreseo"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-1" style="min-width: 140px"><?php echo esc_html__("Restore SEO", _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="sq_inport_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row py-2 pr-0 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php echo esc_html__("Restore Keywords", _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo esc_html__("Upload the file with the saved Squirrly Briefcase Keywords.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group">
                                                    <div class="form-group my-2">
                                                        <input type="file" class="form-control-file" name="sq_upload_file">
                                                    </div>
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_briefcase_restore', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_briefcase_restore"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-1" style="min-width: 140px"><?php echo esc_html__("Restore", _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="bg-title p-2">
                                        <h3 class="card-title"><?php echo esc_html__("Rollback Plugin", _SQ_PLUGIN_NAME_); ?>
                                            <a href="https://howto.squirrly.co/kb/import-export-seo-settings/#rollback_squirrly_seo" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                        </h3>
                                        <div class="col-12 text-left m-0 p-0">
                                            <div class="card-title-description mb-0"><?php echo esc_html__("You can rollback Squirrly SEO plugin to the last stable version.", _SQ_PLUGIN_NAME_); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 pt-0 pb-4 border-bottom tab-panel">
                                        <form id="sq_rollback_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-5 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php echo esc_html__("Rollback to version", _SQ_PLUGIN_NAME_) . ' ' . SQ_STABLE_VERSION; ?>:</div>
                                                    <div class="small text-black-50"><?php echo esc_html__("Install the last stable version of the plugin.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-7 p-0 input-group">
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_rollback', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_rollback"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-2" style="min-width: 250px"><?php echo esc_html__("Install Squirrly SEO", _SQ_PLUGIN_NAME_) . ' ' . SQ_STABLE_VERSION; ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 pt-0 pb-4 border-bottom tab-panel">
                                        <form id="sq_reinstall_form" name="import" action="" method="post" enctype="multipart/form-data">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-5 p-0 pr-3">
                                                    <div class="font-weight-bold"><?php echo esc_html__("Reinstall version", _SQ_PLUGIN_NAME_) . ' ' . SQ_VERSION; ?>:</div>
                                                    <div class="small text-black-50"><?php echo esc_html__("Reinstall the current version of the plugin.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-7 p-0 input-group">
                                                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_reinstall', 'sq_nonce'); ?>
                                                    <input type="hidden" name="action" value="sq_reinstall"/>
                                                    <button type="submit" class="btn rounded-0 btn-success px-2 mx-2" style="min-width: 250px"><?php echo esc_html__("Reinstall Current Version", _SQ_PLUGIN_NAME_); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
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
