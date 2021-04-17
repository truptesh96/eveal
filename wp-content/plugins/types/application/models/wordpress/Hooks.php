<?php

namespace OTGS\Toolset\Types\Wordpress;

use function add_filter;
use function remove_filter;

/**
 * Gateway to WordPress action and filter functions.
 *
 * Extend at will, but keep it very simple.
 *
 * @codeCoverageIgnore
 * @since 3.4.2
 */
class Hooks {

	/**
	 * @see \add_filter()
	 * @param $tag
	 * @param $function_to_add
	 * @param int $priority
	 * @param int $accepted_args
	 *
	 * @return bool|mixed|true|void
	 */
	public function add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		return add_filter( $tag, $function_to_add, $priority, $accepted_args );
	}


	/**
	 * @see \remove_filter()
	 * @param $tag
	 * @param $function_to_remove
	 * @param int $priority
	 *
	 * @return bool|mixed
	 */
	public function remove_filter( $tag, $function_to_remove, $priority = 10 ) {
		return remove_filter( $tag, $function_to_remove, $priority );
	}

}
