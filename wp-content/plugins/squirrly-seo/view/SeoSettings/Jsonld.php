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
            <div class="flex-grow-1 px-2 sq_flex">
                <?php do_action('sq_form_notices'); ?>
                <form method="POST">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_jsonld', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_jsonld"/>

                    <div class="card col-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-7 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_jsonld_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php echo esc_html__("JSON-LD Structured Data", _SQ_PLUGIN_NAME_); ?>
                                    <div class="sq_help_question d-inline">
                                        <a href="https://howto.squirrly.co/kb/json-ld-structured-data/" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                    </div>
                                </h3>
                            </div>
                            <div class="col-5 text-right">
                                <div class="checker row my-4 py-2 mx-0 px-0 justify-content-end">
                                    <div class="sq-switch redgreen sq-switch-sm ">
                                        <label for="sq_auto_jsonld" class="mr-2"><?php echo esc_html__("Activate JSON-LD", _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_jsonld" value="0"/>
                                        <input type="checkbox" id="sq_auto_jsonld" name="sq_auto_jsonld" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_jsonld"></label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="sq_seosettings" class="card col-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld') ? '' : 'sq_deactivated') ?>">
                            <div class="card-body p-0">
                                <div class="col-12 m-0 p-0">
                                    <div class="card col-12 p-0 border-0 ">
                                        <?php
                                        $jsonld = SQ_Classes_Helpers_Tools::getOption('sq_jsonld');
                                        $jsonldtype = SQ_Classes_Helpers_Tools::getOption('sq_jsonld_type');
                                        ?>

                                        <div class="col-12 pt-0 pb-4 border-bottom tab-panel">
                                            <div class="col-12 row mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <div class="font-weight-bold"><?php echo esc_html__("JSON-LD Type", _SQ_PLUGIN_NAME_); ?>:
                                                        <a href="https://howto.squirrly.co/kb/json-ld-structured-data/" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </div>
                                                    <div class="small text-black-50 my-1"><?php echo esc_html__("Select between a Personal or a Business website type.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0 input-group">

                                                    <select name="sq_jsonld_type" class="form-control bg-input mb-1">
                                                        <option value="Organization" <?php echo(($jsonldtype == 'Organization') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Organization", _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="Person" <?php echo(($jsonldtype == 'Person') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Person", _SQ_PLUGIN_NAME_); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 py-4 border-bottom tab-panel tab-panel-Organization" style="<?php echo(($jsonldtype == 'Person') ? 'display:none' : ''); ?>">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Your Organization Name", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#Add-JSON-LD-Company" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1">e.g. COMPANY LTD"</div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][name]" value="<?php echo(($jsonld['Organization']['name'] <> '') ? $jsonld['Organization']['name'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Logo URL", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input id="sq_jsonld_logo_organization" type="text" class="form-control bg-input" name="sq_jsonld[Organization][logo][url]" value="<?php echo(($jsonld['Organization']['logo']['url'] <> '') ? $jsonld['Organization']['logo']['url'] : '') ?>"/>
                                                    <input type="button" class="sq_imageselect btn btn-primary rounded-right" data-destination="sq_jsonld_logo_organization" value="<?php echo esc_html__("Select Image", _SQ_PLUGIN_NAME_) ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Short Description", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo esc_html__("A short description about the company. 20-50 words.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0">
                                                    <textarea class="form-control" name="sq_jsonld[Organization][description]" rows="3"><?php echo(($jsonld['Organization']['description'] <> '') ? $jsonld['Organization']['description'] : '') ?></textarea>
                                                </div>
                                            </div>
                                            <hr/>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Address", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1">e.g. 38 avenue de l'Opera</div>
                                                </div>
                                                <div class="col-5 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][streetAddress]" value="<?php echo(($jsonld['Organization']['address']['streetAddress']) ? $jsonld['Organization']['address']['streetAddress'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("City", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1">e.g. Paris</div>
                                                </div>
                                                <div class="col-5 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][addressLocality]" value="<?php echo(($jsonld['Organization']['address']['addressLocality']) ? $jsonld['Organization']['address']['addressLocality'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Country", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1">e.g. US</div>
                                                </div>
                                                <div class="col-5 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][addressCountry]" value="<?php echo(($jsonld['Organization']['address']['addressCountry']) ? $jsonld['Organization']['address']['addressCountry'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Postal Code", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1">e.g. F-75002</div>
                                                </div>
                                                <div class="col-5 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][address][postalCode]" value="<?php echo(($jsonld['Organization']['address']['postalCode']) ? $jsonld['Organization']['address']['postalCode'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Contact Phone", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1">e.g. +1-541-754-3010</div>
                                                </div>
                                                <div class="col-5 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][contactPoint][telephone]" value="<?php echo(($jsonld['Organization']['contactPoint']['telephone']) ? $jsonld['Organization']['contactPoint']['telephone'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row mx-0 my-3">
                                                <div class="col-4 p-1">
                                                    <div class="font-weight-bold"><?php echo esc_html__("Contact Type", _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50 my-1"></div>
                                                </div>
                                                <div class="col-5 p-0 input-group">
                                                    <select name="sq_jsonld[Organization][contactPoint][contactType]" class="form-control bg-input mb-1">
                                                        <option value=""></option>
                                                        <option value="customer service" <?php echo(($jsonld['Organization']['contactPoint']['contactType'] == 'customer service') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Customer Service", _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="technical support" <?php echo(($jsonld['Organization']['contactPoint']['contactType'] == 'technical support') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Technical Support", _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="billing support" <?php echo(($jsonld['Organization']['contactPoint']['contactType'] == 'billing support') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Billing Support", _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="bill payment" <?php echo(($jsonld['Organization']['contactPoint']['contactType'] == 'bill payment') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Bill Payment", _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="sales" <?php echo(($jsonld['Organization']['contactPoint']['contactType'] == 'sales') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Sales", _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="reservations" <?php echo(($jsonld['Organization']['contactPoint']['contactType'] == 'reservations') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Reservations", _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="credit card support" <?php echo(($jsonld['Organization']['contactPoint']['contactType'] == 'credit card support') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Credit Card Support", _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="emergency" <?php echo(($jsonld['Organization']['contactPoint']['contactType'] == 'emergency') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Emergency", _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="baggage tracking" <?php echo(($jsonld['Organization']['contactPoint']['contactType'] == 'baggage tracking') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Baggage Tracking", _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="roadside assistance" <?php echo(($jsonld['Organization']['contactPoint']['contactType'] == 'roadside assistance') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Roadside Assistance", _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="package tracking" <?php echo(($jsonld['Organization']['contactPoint']['contactType'] == 'package tracking') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Package Tracking", _SQ_PLUGIN_NAME_); ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <a name="localseo"></a>
                                            <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld_local')) { ?>
                                                <button type="button" class="col-12 btn btn-light py-3 my-3 font-weight-bold border" style="font-size: 20px" onclick="jQuery('.sq_locaseo').toggle()"><?php echo esc_html__("Setup JSON-LD Schema for Local SEO", _SQ_PLUGIN_NAME_); ?></button>
                                            <?php } ?>


                                            <div class="sq_locaseo" <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld_local')) { ?>style="display: none;" <?php }?>>
                                                <div class="bg-title p-2 mt-4">
                                                    <h3 class="col-12 card-title"><?php echo esc_html__("GEO Location", _SQ_PLUGIN_NAME_); ?>
                                                        <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#local_seo" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                                    </h3>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-0 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("GEO Settings", _SQ_PLUGIN_NAME_); ?>:
                                                        <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#local_seo" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        <div class="small text-black-50 my-1"><?php echo esc_html__("Latitude & Longitude of your store/business.", _SQ_PLUGIN_NAME_); ?></div>
                                                        <div class="small text-black-50 my-1">
                                                            <a href="https://www.latlong.net/convert-address-to-lat-long.html" target="_blank"><?php echo esc_html__("Get GEO Coordonates based on address.", _SQ_PLUGIN_NAME_); ?></a>
                                                        </div>
                                                    </div>
                                                    <div class="col-8 p-0">
                                                        <div class="row px-3">
                                                            <div class="col-5 py-0 pl-0 pr-2">
                                                                <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][place][geo][latitude]" value="<?php echo(($jsonld['Organization']['place']['geo']['latitude']) ? $jsonld['Organization']['place']['geo']['latitude'] : '') ?>" placeholder="<?php echo esc_html__("latitude", _SQ_PLUGIN_NAME_); ?>"/>
                                                            </div>
                                                            <div class="col-5 py-0 pl-2 pr-0">
                                                                <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][place][geo][longitude]" value="<?php echo(($jsonld['Organization']['place']['geo']['longitude']) ? $jsonld['Organization']['place']['geo']['longitude'] : '') ?>" placeholder="<?php echo esc_html__("longitude", _SQ_PLUGIN_NAME_); ?>"/>
                                                            </div>
                                                        </div>
                                                        <div class="row px-3 pt-2">
                                                            <div class="col-10 text-black-50 p-0"><?php echo sprintf(esc_html__("Download the file %s for GEO Coordonates to import into %s Google Earth %s.", _SQ_PLUGIN_NAME_), '<strong><a href="' . SQ_Classes_ObjController::getClass('SQ_Controllers_Sitemaps')->getKmlUrl('locations') . '">' . SQ_Classes_ObjController::getClass('SQ_Controllers_Sitemaps')->getKmlUrl('locations') . '</a></strong>', '<a href="https://support.google.com/earth/answer/7365595?co=GENIE.Platform%3DDesktop&hl=en" target="_blank" >', '</a>'); ?></div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="bg-title p-2 mt-5">
                                                    <h3 class="col-12 card-title"><?php echo esc_html__("Opening Hours", _SQ_PLUGIN_NAME_); ?>
                                                        <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#local_seo_hours" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                                    </h3>
                                                </div>
                                                <?php
                                                $jsonldLocal = SQ_Classes_Helpers_Tools::getOption('sq_jsonld_local');
                                                $dayOfWeek = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

                                                foreach ($dayOfWeek as $index => $value) { ?>
                                                    <div class="col-12 row py-0 mx-0 my-3">
                                                        <div class="col-4 py-1 text-right">
                                                            <h5><?php echo $value; ?></h5>
                                                        </div>
                                                        <div class="col-4 py-0 pl-0 pr-2">
                                                            <div class="row">
                                                                <div class="col-4 py-2 text-right"><?php echo esc_html__("Opens", _SQ_PLUGIN_NAME_); ?>:</div>
                                                                <div class="col">
                                                                    <input type="text" class="form-control bg-input" name="sq_jsonld_local[openingHoursSpecification][<?php echo $index ?>][opens]" value="<?php echo(($jsonldLocal['openingHoursSpecification'][$index]['opens']) ? $jsonldLocal['openingHoursSpecification'][$index]['opens'] : '') ?>" placeholder="<?php echo esc_html__("08:00", _SQ_PLUGIN_NAME_); ?>"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 py-0 pl-2 pr-0">
                                                            <div class="row">
                                                                <div class="col-4 py-2 text-right"><?php echo esc_html__("Closes", _SQ_PLUGIN_NAME_); ?>:</div>
                                                                <div class="col">
                                                                    <input type="text" class="form-control bg-input" name="sq_jsonld_local[openingHoursSpecification][<?php echo $index ?>][closes]" value="<?php echo(($jsonldLocal['openingHoursSpecification'][$index]['closes']) ? $jsonldLocal['openingHoursSpecification'][$index]['closes'] : '') ?>" placeholder="<?php echo esc_html__("23:00", _SQ_PLUGIN_NAME_); ?>"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="bg-title p-2 mt-5">
                                                    <h3 class="col-12 card-title"><?php echo esc_html__("Local Restaurant", _SQ_PLUGIN_NAME_); ?>
                                                        <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#local_restaurant" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                                    </h3>
                                                    <div class="col-12 text-danger"><?php echo esc_html__("ONLY use this if you have a restaurant, pizza place, bar, pub, etc. Otherwise, leave blank.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-0 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Price Range", _SQ_PLUGIN_NAME_); ?>:
                                                    </div>
                                                    <div class="col-5 p-0 input-group input-group-lg">
                                                        <select name="sq_jsonld_local[priceRange]" class="form-control bg-input mb-1">
                                                            <option value=""></option>
                                                            <option value="$" <?php echo(($jsonldLocal['priceRange'] == '$') ? 'selected="selected"' : ''); ?>>$</option>
                                                            <option value="$$" <?php echo(($jsonldLocal['priceRange'] == '$$') ? 'selected="selected"' : ''); ?>>$$</option>
                                                            <option value="$$$" <?php echo(($jsonldLocal['priceRange'] == '$$$') ? 'selected="selected"' : ''); ?>>$$</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-0 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Serves Cuisine", _SQ_PLUGIN_NAME_); ?>:
                                                        <div class="small text-black-50 my-1">e.g. American, Italiano</div>
                                                    </div>
                                                    <div class="col-5 p-0 input-group input-group-lg">
                                                        <input type="text" class="form-control bg-input" name="sq_jsonld_local[servesCuisine]" value="<?php echo(($jsonldLocal['servesCuisine']) ? $jsonldLocal['servesCuisine'] : '') ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-0 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Menu Link", _SQ_PLUGIN_NAME_); ?>:
                                                        <div class="small text-black-50 my-1">Restaurant Menu URL</div>
                                                    </div>
                                                    <div class="col-5 p-0 input-group input-group-lg">
                                                        <input type="text" class="form-control bg-input" name="sq_jsonld_local[menu]" value="<?php echo(($jsonldLocal['menu']) ? $jsonldLocal['menu'] : '') ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 row py-2 mx-0 my-3">
                                                    <div class="col-4 p-0 pr-3 font-weight-bold">
                                                        <?php echo esc_html__("Accept Reservations", _SQ_PLUGIN_NAME_); ?>:
                                                    </div>
                                                    <div class="col-5 p-0 input-group input-group-lg">
                                                        <select name="sq_jsonld_local[acceptsReservations]" class="form-control bg-input mb-1">
                                                            <option value=""></option>
                                                            <option value="False" <?php echo(($jsonldLocal['acceptsReservations'] == 'False') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("No"); ?></option>
                                                            <option value="True" <?php echo(($jsonldLocal['acceptsReservations'] == 'True') ? 'selected="selected"' : ''); ?>><?php echo esc_html__("Yes"); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 py-4 border-bottom tab-panel tab-panel-Person" style="<?php echo(($jsonldtype == 'Organization') ? 'display:none' : ''); ?>">

                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Your Name", _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#Add-JSON-LD-Profile" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1">e.g. John Smith</div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Person][name]" value="<?php echo(($jsonld['Person']['name'] <> '') ? $jsonld['Person']['name'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Job Title", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1">e.g. Sales Manager</div>
                                                </div>
                                                <div class="col-5 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Person][jobTitle]" value="<?php echo(($jsonld['Person']['jobTitle'] <> '') ? $jsonld['Person']['jobTitle'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Logo URL", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"></div>
                                                </div>
                                                <div class="col-8 p-0 input-group input-group-lg">
                                                    <input id="sq_jsonld_logo_person" type="text" class="form-control bg-input" name="sq_jsonld[Person][image][url]" value="<?php echo(($jsonld['Person']['image']['url'] <> '') ? $jsonld['Person']['image']['url'] : '') ?>"/>
                                                    <input type="button" class="sq_imageselect form-control btn btn-primary rounded-right col-3" data-destination="sq_jsonld_logo_person" value="<?php echo esc_html__("Select Image", _SQ_PLUGIN_NAME_) ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Contact Phone", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1">e.g. +1-541-754-3010</div>
                                                </div>
                                                <div class="col-5 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Person][telephone]" value="<?php echo(($jsonld['Person']['telephone'] <> '') ? $jsonld['Person']['telephone'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-0 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("Short Description", _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php echo esc_html__("A short description about your job title.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-8 p-0">
                                                    <textarea class="form-control" name="sq_jsonld[Person][description]" rows="3"><?php echo(($jsonld['Person']['description'] <> '') ? $jsonld['Person']['description'] : '') ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-12 row my-4 ml-0 sq_advanced">
                                                <div class="col-12 p-0 input-group input-group-lg">
                                                    <div class="checker col-12 row my-2 py-1">
                                                        <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                            <input type="hidden" name="sq_jsonld_global_person" value="0"/>
                                                            <input type="checkbox" id="sq_jsonld_global_person" name="sq_jsonld_global_person" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_jsonld_global_person') ? 'checked="checked"' : '') ?> value="1"/>
                                                            <label for="sq_jsonld_global_person" class="ml-2"><?php echo esc_html__("Set this person as a global author", _SQ_PLUGIN_NAME_); ?>
                                                                <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#global_author" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                            </label>
                                                            <div class="offset-1 small text-black-50"><?php echo esc_html__("Overwrite the posts/pages author(s) with this author in Json-LD.", _SQ_PLUGIN_NAME_); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="bg-title p-2 ">
                                        <h3 class="card-title"><?php echo esc_html__("More Json-LD Settings", _SQ_PLUGIN_NAME_); ?></h3>
                                    </div>
                                    <div class="col-12 py-4 border-bottom tab-panel">
                                        <?php if (SQ_Classes_Helpers_Tools::isPluginInstalled('woocommerce/woocommerce.php')) { ?>
                                            <div class="col-12 row mb-1 ml-1">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_jsonld_woocommerce" value="0"/>
                                                        <input type="checkbox" id="sq_jsonld_woocommerce" name="sq_jsonld_woocommerce" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_jsonld_woocommerce') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_jsonld_woocommerce" class="ml-2"><?php echo esc_html__("Add Support For Woocommerce", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#woocommerce" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Improve the WooCommerce  Product and Orders Schema by enabling Squirrly to add the required data.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row mb-1 ml-1 sq_advanced">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_jsonld_product_custom" value="0"/>
                                                        <input type="checkbox" id="sq_jsonld_product_custom" name="sq_jsonld_product_custom" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_jsonld_product_custom') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_jsonld_product_custom" class="ml-2"><?php echo esc_html__("Add Custom Data for WooCommerce Products", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#woocommerce" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Enable Squirrly to include additional metadata fields for WooCommerce Products: MPN, ISBN, EAN, UPC, GTIN, Brand, Review.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 row mb-1 ml-1 sq_advanced">
                                                <div class="checker col-12 row my-2 py-1">
                                                    <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_jsonld_product_defaults" value="0"/>
                                                        <input type="checkbox" id="sq_jsonld_product_defaults" name="sq_jsonld_product_defaults" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_jsonld_product_defaults') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_jsonld_product_defaults" class="ml-2"><?php echo esc_html__("Add Default Data for Woocommerce Products", _SQ_PLUGIN_NAME_); ?>
                                                            <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#woocommerce" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                        </label>
                                                        <div class="offset-1 small text-black-50"><?php echo esc_html__("Add default data for JSON-LD AggregateRating, Offers, Sku, MPN when they are missing from the product to avoid GSC errors.", _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>


                                        <?php } ?>


                                        <div class="col-12 row mb-1 ml-1">
                                            <div class="checker col-12 row my-2 py-1">
                                                <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_jsonld_breadcrumbs" value="0"/>
                                                    <input type="checkbox" id="sq_jsonld_breadcrumbs" name="sq_jsonld_breadcrumbs" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_jsonld_breadcrumbs') ? 'checked="checked"' : '') ?> value="1"/>
                                                    <label for="sq_jsonld_breadcrumbs" class="ml-2"><?php echo esc_html__("Add Breadcrumbs in Json-LD", _SQ_PLUGIN_NAME_); ?>
                                                        <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#breadcrumbs_schema" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="offset-1 small text-black-50"><?php echo esc_html__("Add the BreadcrumbsList Schema into Json-LD including all parent categories.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 row mb-1 ml-1 sq_advanced">
                                            <div class="checker col-12 row my-2 py-1">
                                                <div class="col-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_jsonld_clearcode" value="0"/>
                                                    <input type="checkbox" id="sq_jsonld_clearcode" name="sq_jsonld_clearcode" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_jsonld_clearcode') ? 'checked="checked"' : '') ?> value="1"/>
                                                    <label for="sq_jsonld_clearcode" class="ml-2"><?php echo esc_html__("Remove other Json-LD from page", _SQ_PLUGIN_NAME_); ?>
                                                        <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#remove_duplicates" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    </label>
                                                    <div class="offset-1 small text-black-50"><?php echo esc_html__("Clear the Json-LD from other plugins and theme to avoid duplicate schemas.", _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <?php $metas = json_decode(wp_json_encode(SQ_Classes_Helpers_Tools::getOption('sq_metas'))); ?>
                                    <div class="sq_advanced">
                                        <div class="bg-title p-2">
                                            <h3 class="card-title">
                                                <?php echo esc_html__("Title & Description Lengths", _SQ_PLUGIN_NAME_); ?>:
                                                <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#lengths" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                            </h3>
                                        </div>
                                        <div class="col-12 py-4 border-bottom tab-panel ">
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-1 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("JSON-LD Title Length", _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[jsonld_title_maxlength]" value="<?php echo (int)$metas->jsonld_title_maxlength ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 row py-2 mx-0 my-3">
                                                <div class="col-4 p-1 pr-3 font-weight-bold">
                                                    <?php echo esc_html__("JSON-LD Description Length", _SQ_PLUGIN_NAME_); ?>:
                                                </div>
                                                <div class="col-1 p-0 input-group input-group-sm">
                                                    <input type="text" class="form-control bg-input" name="sq_metas[jsonld_description_maxlength]" value="<?php echo (int)$metas->jsonld_description_maxlength ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-12 p-0 py-3 bg-light">
                            <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) { ?>
                                <div class="py-0 float-right text-right m-2">
                                    <button type="button" class="show_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0"><?php echo esc_html__("Show Advanced Options", _SQ_PLUGIN_NAME_); ?></button>
                                    <button type="button" class="hide_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0" style="display: none"><?php echo esc_html__("Hide Advanced Options", _SQ_PLUGIN_NAME_); ?></button>
                                </div>
                            <?php } ?>
                            <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php echo esc_html__("Save Settings", _SQ_PLUGIN_NAME_); ?></button>
                        </div>


                    </div>
                </form>

                <div class="card col-12 p-0 my-5">
                    <div class="card-body p-0">
                        <div class="bg-title p-2 ">
                            <h3 class="card-title"><?php echo esc_html__("Next Step", _SQ_PLUGIN_NAME_); ?></h3>
                        </div>

                        <div class="col-12 my-5 mx-2">
                            <h5 class="text-left my-4 text-info"><?php echo esc_html__("Tips: How to optimize Json-LD Schema on all pages?", _SQ_PLUGIN_NAME_); ?></h5>
                            <ul class="mx-3">
                                <li class="sq_advanced" style="font-size: 15px; list-style: initial;"><?php echo sprintf(esc_html__("Use the %s SEO Automation %s to setup the Json-LD type based on Post Types.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_seosettings', 'automation') . '">', '</a>'); ?></li>
                                <li style="font-size: 15px; list-style: initial;"><?php echo sprintf(esc_html__("Use %s Bulk SEO %s to optimize the JSON-LD in the SEO Snippet for each page on your website.", _SQ_PLUGIN_NAME_), '<a href="' . SQ_Classes_Helpers_Tools::getAdminUrl('sq_bulkseo', 'bulkseo') . '">', '</a>'); ?></li>
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
