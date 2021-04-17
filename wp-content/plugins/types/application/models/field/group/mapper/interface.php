<?php

/**
 * Interface Types_Post_Field_Group_Mapper_Interface
 *
 * @since m2m
 */
interface Types_Field_Group_Mapper_Interface {
	/**
	 * Returns ALL field groups assigned to given $post
	 *
	 * @param WP_Post $post
	 *
	 * @return Types_Field_Group[]
	 */
	function find_by_post( WP_Post $post );
}