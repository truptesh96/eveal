<?php

class SQ_Models_RoleManager {

    public $roles;

    public function __construct() {
        add_action('admin_init', array($this, 'addSQRoles'), 99);
    }

    /**
     * Get all the Squirrly Caps
     * @param $role
     * @return array
     */
    public function getSQCaps($role = '') {
        $caps = array();

        $caps['sq_seo_author'] = array(
            'sq_manage_snippet' => true,
            'sq_manage_snippets' => false,
            'sq_manage_settings' => false,
            'sq_manage_focuspages' => false,
        );

        $caps['sq_seo_editor'] = array(
            'sq_manage_snippet' => true,
            'sq_manage_snippets' => true,
            'sq_manage_settings' => false,
            'sq_manage_focuspages' => true,
        );

        $caps['sq_seo_admin'] = array(
            'sq_manage_snippet' => true,
            'sq_manage_snippets' => true,
            'sq_manage_settings' => true,
            'sq_manage_focuspages' => true,
        );

        $caps = array_filter($caps);

        if (isset($caps[$role])) {
            return $caps[$role];
        }

        return $caps;
    }

    /**
     * Register Squirrly Roles and Caps
     * in case they don't exists
     */
    public function addSQRoles() {
        /** @var $wp_roles WP_Roles */
        global $wp_roles;

        //$this->removeSQCaps();
        if (function_exists('wp_roles')) {
            $allroles = wp_roles()->get_names();
            if (!empty($allroles)) {
                $allroles = array_keys($allroles);
            }

            if (!empty($allroles)) {
                foreach ($allroles as $role) {
                    if ($role == 'administrator' || $role == 'sq_seo_admin') {
                        $this->updateSQCap('sq_seo_admin', $role);
                        continue;
                    }

                    switch ($role) {
                        case 'editor':
                        case 'sq_seo_editor':
                            $this->updateSQCap('sq_seo_editor', $role);
                            break;
                        case 'author':
                        case 'sq_seo_author':
                        case 'contributor':
                        default:
                            $role_object = get_role($role);
                            if ($role_object->has_cap( 'edit_posts' )) {
                                $this->updateSQCap('sq_seo_author', $role);
                            }
                            break;

                    }
                }
            }

            if (!$wp_roles || !isset($wp_roles->roles) || !method_exists($wp_roles, 'is_role')) {
                return;
            }

            if (!$wp_roles->is_role('sq_seo_editor') || !$wp_roles->is_role('sq_seo_admin')) {
                //get all Squirrly roles and caps
                $this->addSQRole('sq_seo_editor', esc_html__("Squirrly SEO Editor", _SQ_PLUGIN_NAME_), 'editor');
                $this->addSQRole('sq_seo_admin', esc_html__("Squirrly SEO Admin", _SQ_PLUGIN_NAME_), 'editor');

            }

        }
    }

    /**
     * Remove Squirrly Roles and Caps
     */
    public function removeSQRoles() {
        global $wp_roles;

        //get all Squirrly roles and caps
        $sqcaps = $this->getSQCaps();

        if (!empty($sqcaps)) {
            foreach (array_keys($sqcaps) as $role) {
                if ($wp_roles->is_role($role)) {
                    $this->removeRole($role);
                }

            }
        }

    }

    public function removeSQCaps() {
        if (function_exists('wp_roles')) {
            $allroles = wp_roles()->get_names();
            if (!empty($allroles)) {
                $allroles = array_keys($allroles);
            }

            if (!empty($allroles)) {
                foreach ($allroles as $role) {
                    $this->removeCap($role, $this->getSQCaps('sq_seo_admin'));
                    $this->removeCap($role, $this->getSQCaps('sq_seo_editor'));
                    $this->removeCap($role, $this->getSQCaps('sq_seo_author'));
                }
            }
        }

    }

    /**
     * Add Squirrly Role and Caps
     * @param $sqrole
     * @param $title
     * @param $wprole
     */
    public function addSQRole($sqrole, $title, $wprole) {
        $wpcaps = $this->getWpCaps($wprole);
        $sqcaps = $this->getSQCaps($sqrole);

        $this->addRole($sqrole, $title, array_merge($wpcaps, $sqcaps));
    }

    /**
     * Update the Squirlly Caps into WP Roles
     * @param $sqrole
     * @param $wprole
     */
    public function updateSQCap($sqrole, $wprole) {
        $sqcaps = $this->getSQCaps($sqrole);

        $this->addCap($wprole, $sqcaps);
    }

    /**
     * Add a role into WP
     * @param $name
     * @param $title
     * @param $capabilities
     */
    public function addRole($name, $title, $capabilities) {
        add_role($name, $title, $capabilities);
    }

    /**
     * Add a cap into WP for a role
     * @param $name
     * @param $capabilities
     */
    public function addCap($name, $capabilities) {
        $role = get_role($name);

        if (!$role || !method_exists($role, 'add_cap')) {
            return;
        }

        foreach ($capabilities as $capability => $grant) {
            if (!$role->has_cap($capability)) {
                $role->add_cap($capability, $grant);
            }
        }
    }

    /**
     * Remove the caps for a role
     * @param $name
     * @param $capabilities
     */
    public function removeCap($name, $capabilities) {
        $role = get_role($name);

        if (!$role || !method_exists($role, 'remove_cap')) {
            return;
        }

        if ($role) {
            foreach ($capabilities as $capability => $grant) {
                $role->remove_cap($capability);
            }
        }
    }

    /**
     * Remove the role
     * @param $name
     */
    public function removeRole($name) {
        remove_role($name);
    }

    public function getWpCaps($role) {

        if ($wprole = get_role($role)) {
            return $wprole->capabilities;
        }

        return array();
    }

}