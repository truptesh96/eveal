<?php

namespace Barn2\Plugin\WC_Product_Tabs_Free\Dependencies\Lib\Rest;

use WP_REST_Controller;
/**
 * Abstract class for REST routes.
 *
 * @package   Barn2\barn2-lib
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 * @internal
 */
abstract class Base_Route extends WP_REST_Controller implements Route
{
    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }
    public function get_base()
    {
        return $this->rest_base;
    }
    public function get_endpoint()
    {
        return $this->namespace . '/' . $this->rest_base;
    }
    public function register()
    {
        $this->register_routes();
    }
}
