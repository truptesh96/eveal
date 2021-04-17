<?php

namespace OTGS\Toolset\Types\Model\Wordpress;

/**
 * Wrapper for WordPress transient functions
 *
 * @since 3.3.6
 */
class Transient {

	/**
	 * Set a transient.
	 *
	 * @param $key
	 * @param $value
	 * @param $time_in_seconds Zero means no expiration
	 * @return bool
	 * @since 3.3.6
	 */
	public function set_transient( $key, $value, $time_in_seconds = 0 ) {
		return set_transient( $key, $value, $time_in_seconds );
	}

	/**
	 * Get a transient.
	 *
	 * @param $key
	 * @return mixed
	 * @since 3.3.6
	 */
	public function get_transient( $key ) {
		return get_transient( $key );
	}

	/**
	 * Delete a transient.
	 *
	 * @param $key
	 * @return bool
	 * @since 3.3.6
	 */
	public function delete_transient( $key ) {
		return delete_transient( $key );
	}
}
