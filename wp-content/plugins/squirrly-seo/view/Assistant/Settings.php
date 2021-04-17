<?php defined('ABSPATH') || die('Cheatin\' uh?'); ?>
<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" >
        <?php
        if (!current_user_can('sq_manage_settings')) {
            echo '<div class="col-12 alert alert-success text-center m-0 p-3">'. esc_html__("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_).'</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_assistant'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white px-1 m-0">
            <div class="flex-grow-1 px-1 sq_flex">
                <?php do_action('sq_form_notices'); ?>
                <form method="POST">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_settings_assistant', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_settings_assistant"/>

                    <div class="card col-12 p-0">
                        <div class="card-body p-0 m-0 bg-title rounded-top  row">
                            <div class="card-body p-2 bg-title rounded-top">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_settings_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php echo esc_html__("Live Assistant Settings", _SQ_PLUGIN_NAME_); ?>
                                    <div class="sq_help_question d-inline">
                                        <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#settings" target="_blank"><i class="fa fa-question-circle"></i></a>
                                    </div>
                                </h3>
                                <div class="card-title-description m-2"></div>
                            </div>
                        </div>
                        <div id="sq_seosettings" class="card col-12 p-0 m-0 border-0 tab-panel border-0">
                            <div class="card-body p-0">
                                <div class="col-12 m-0 p-0">
                                    <div class="card col-12 p-0 border-0 ">

                                        <div class="col-12 pt-0 pb-4 border-bottom tab-panel">
                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_keyword_help" value="0"/>
                                                        <input type="checkbox" id="sq_keyword_help" name="sq_keyword_help" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_keyword_help') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_keyword_help" class="ml-2"><?php echo esc_html__("Squirrly Tooltips", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#tooltip" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo sprintf(esc_html__("Show %sSquirrly Tooltips%s when posting a new article (e.g. 'Enter a keyword').", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_sla_social_fetch" value="0"/>
                                                        <input type="checkbox" id="sq_sla_social_fetch" name="sq_sla_social_fetch" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_sla_social_fetch') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_sla_social_fetch" class="ml-2"><?php echo esc_html__("Fetch Snippet on Social Media", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#fetch_snippet" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo sprintf(esc_html__("Automatically fetch the Squirrly Snippet on %sFacebook Sharing Debugger%s every time you update the content on a page.", _SQ_PLUGIN_NAME_), '<a href="https://developers.facebook.com/tools/debug/" target="_blank">', '</a>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row mb-1 ml-1 sq_advanced">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_local_images" value="0"/>
                                                        <input type="checkbox" id="sq_local_images" name="sq_local_images" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_local_images') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_local_images" class="ml-2"><?php echo esc_html__("Download Remote Images", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#download_images" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo sprintf(esc_html__("Download %sremote images%s in your %sMedia Library%s for the new posts.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>', '<strong>', '</strong>'); ?></div>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Prevent from losing the images you use in your articles in case the remote images are deleted.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_img_licence" value="0"/>
                                                        <input type="checkbox" id="sq_img_licence" name="sq_img_licence" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_img_licence') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_img_licence" class="ml-2"><?php echo esc_html__("Show Copyright Free Images", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#copyright_free_images" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo sprintf(esc_html__("Search %sCopyright Free Images%s in Squirrly Live Assistant.", _SQ_PLUGIN_NAME_), '<strong>', '</strong>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0">
                                                        <div class="col-12 row py-2 mx-0 my-3">
                                                            <div class="col-4 p-1 pr-3">
                                                                <div class="font-weight-bold"><?php echo esc_html__("Live Assistant Type", _SQ_PLUGIN_NAME_); ?>
                                                                    <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#assistant_type" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                                </div>
                                                                <div class="small text-black-50"><?php echo esc_html__("Select how you want Squirrly Live Assistant to load in editor.", _SQ_PLUGIN_NAME_); ?></div>
                                                            </div>
                                                            <div class="col-8 p-0 input-group">
                                                                <select name="sq_sla_type" class="form-control bg-input mb-1">
                                                                    <option value="auto" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sla_type') == 'auto') ? 'selected="selected"' : '') ?>><?php echo esc_html__("Auto", _SQ_PLUGIN_NAME_); ?></option>
                                                                    <option value="integrated" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sla_type') == 'integrated') ? 'selected="selected"' : '') ?>><?php echo esc_html__("Integrated Box", _SQ_PLUGIN_NAME_); ?></option>
                                                                    <option value="floating" <?php echo((SQ_Classes_Helpers_Tools::getOption('sq_sla_type') == 'floating') ? 'selected="selected"' : '') ?>><?php echo esc_html__("Floating Box", _SQ_PLUGIN_NAME_); ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_sla_frontend" value="0"/>
                                                        <input type="checkbox" id="sq_sla_frontend" name="sq_sla_frontend" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_sla_frontend') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_sla_frontend" class="ml-2"><?php echo esc_html__("Activate Live Assistant in Frontend", _SQ_PLUGIN_NAME_); ?><span class="text-danger"></span>
                                                            <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#Add-Live-Assistant-in-Frontend" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Load Squirrly Live Assistant in Frontend to customize the posts and pages with Builders.", _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="offset-1 small text-warning"><?php echo esc_html__("Currently supports the Elementor Builder plugin.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bg-title p-2 sq_advanced">
                                            <h3 class="card-title"><?php echo esc_html__("Places where you do NOT want Squirrly Live Assistant to load", _SQ_PLUGIN_NAME_); ?>
                                                <div class="sq_help_question d-inline">
                                                    <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#disable_live_assistant" target="_blank"><i class="fa fa-question-circle"></i></a>
                                                </div>
                                            </h3>
                                            <div class="col-12 text-left m-0 p-0">
                                                <div class="card-title-description mb-0 text-danger"><?php echo esc_html__("Don't select anything if you wish Squirrly Live Assistant to load for all post types.", _SQ_PLUGIN_NAME_); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 py-4 border-bottom tab-panel sq_advanced">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Exclusions", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/squirrly-live-assistant/#disable_live_assistant" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php echo esc_html__("Select places where you do NOT want Squirrly Live Assistant to load.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group">
                                                    <input type="hidden" name="sq_sla_exclude_post_types[]" value="0"/>
                                                    <select multiple name="sq_sla_exclude_post_types[]" class="selectpicker form-control bg-input mb-1" data-live-search="true">
                                                        <?php
                                                        $types = get_post_types(array('public' => true));
                                                        foreach ($types as $type) {
                                                            $type_data = get_post_type_object($type);
                                                            echo '<option value="' . $type . '" ' . (in_array($type, (array)SQ_Classes_Helpers_Tools::getOption('sq_sla_exclude_post_types')) ? 'selected="selected"' : '') . '>' . $type_data->labels->name . '</option>';
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-12 my-3 p-0">
                        <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) { ?>
                            <div class="py-0 float-right text-right m-2">
                                <button type="button" class="show_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0"><?php echo esc_html__("Show Advanced Options", _SQ_PLUGIN_NAME_); ?></button>
                                <button type="button" class="hide_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0" style="display: none"><?php echo esc_html__("Hide Advanced Options", _SQ_PLUGIN_NAME_); ?></button>
                            </div>
                        <?php } ?>
                        <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php echo esc_html__("Save Settings", _SQ_PLUGIN_NAME_); ?></button>
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
</div>
