<?php

/**
 * Class Types_Field_Group_Repeatable_Wpml_Translation_Job_Data
 *
 * @since m2m
 * @refactoring Get rid of the hard dependency on WPML_Translation_Job_Helper.
 */
class Types_Field_Group_Repeatable_Wpml_Translation_Job_Data {

	const HASH_PART_POSTID = '__postid__';

	const HASH_PART_FIELDSLUG = '__fieldslug__';

	/** @var string Separator used in the field label in the translation editor. */
	const FIELD_PATH_SEPARATOR = ' → ';

	/** @var Types_Field_Abstract[] */
	private $fields = array();

	/** @var Toolset_Field_Definition_Factory_Interface */
	private $field_definitions;

	/** @var Types_Field_Group_Repeatable_Mapper_Legacy  */
	private $repeatable_mapper_legacy;

	/** @var \OTGS\Toolset\Common\WPML\WpmlService */
	private $wpml_service;


	/**
	 * Types_Field_Group_Repeatable_Wpml_Translation_Job_Data constructor.
	 *
	 * @param \OTGS\Toolset\Common\WPML\WpmlService $wpml_service
	 * @param Toolset_Field_Definition_Factory_Interface $field_definitions
	 * @param Types_Field_Group_Repeatable_Mapper_Legacy|null $repeatable_mapper_legacy
	 */
	public function __construct(
		\OTGS\Toolset\Common\WPML\WpmlService $wpml_service,
		Toolset_Field_Definition_Factory_Interface $field_definitions = null,
		Types_Field_Group_Repeatable_Mapper_Legacy $repeatable_mapper_legacy = null
	) {
		$this->wpml_service = $wpml_service;
		$this->field_definitions = $field_definitions ?: Toolset_Field_Definition_Factory_Post::get_instance();
		$this->repeatable_mapper_legacy = $repeatable_mapper_legacy ?: new Types_Field_Group_Repeatable_Mapper_Legacy();
	}

	/**
	 * Add repeatable field group items to parent post translation job
	 *
	 * @action wpml_tm_adjust_translation_fields
	 *
	 * @param $package
	 * @param WP_Post|WPML_Package $post
	 *
	 * @param Types_Post_Builder $types_post_builder
	 * @param WPML_Translation_Job_Helper $translation_job_helper
	 *
	 * @return array
	 */
	public function wpml_tm_translation_job_data(
		$package,
		$post,
		Types_Post_Builder $types_post_builder,
		WPML_Translation_Job_Helper $translation_job_helper
	) {
		if( ! $post instanceof WP_Post ) {
			// Something else than a normal post is being translated. We do nothing because these things
			// can't have RFGs.
			//
			// This can happen when a Layout is sent to translation, for example.
			return $package;
		}

		// We need to load the current language's items to translate.
		$this->wpml_service->switch_language( $this->wpml_service->get_post_language( $post->ID ) );

		$types_post_builder->set_wp_post( $post );
		$types_post_builder->load_assigned_field_groups( 9999 );
		foreach ( $types_post_builder->get_types_post()->get_field_groups() as $field_group ) {
			if( ! $rfgs = $field_group->get_repeatable_groups() ) {
				// no repeatable field groups
				continue;
			}

			foreach ( $rfgs as $rfg ) {
				$package = $this->add_rfg_items( $package, $rfg, $translation_job_helper );
			}
		}

		$this->wpml_service->switch_language_back();

		return $package;
	}


	/**
	 * Adjust the titles our previously added fields
	 *
	 * @action wpml_tm_adjust_translation_fields
	 *
	 * @param $fields
	 * @param \OTGS\Toolset\Types\Field\Group\Repeatable\ItemPathBuilder $item_path_builder
	 *
	 * @return array
	 */
	public function wpml_tm_adjust_translation_fields(
		$fields, \OTGS\Toolset\Types\Field\Group\Repeatable\ItemPathBuilder $item_path_builder
	) {
		foreach ( $fields as $key => $field ) {
			$resolved_hash = $this->resolve_translation_hash( $field['field_type'] );
			if( ! $resolved_hash ) {
				// no rfg item field
				continue;
			}

			$field_slug = $resolved_hash['fieldslug'];
			$item_id = (int) $resolved_hash['id'];

			$field_definition = $this->field_definitions->load_field_definition( $field_slug );
			if( ! $field_definition ) {
				continue;
			}

			$this->wpml_service->switch_language( $this->wpml_service->get_post_language( $item_id ) );

			$item_path = $this->get_formatted_item_path( $item_path_builder, $item_id );
			$fields[ $key ]['title'] = $item_path . self::FIELD_PATH_SEPARATOR . $field_definition->get_display_name();

			$this->wpml_service->switch_language_back();
		}

		return $fields;
	}


	/**
	 * For a given RFG item ID, return its path from the parent post.
	 *
	 * The parent post itself is not included.
	 *
	 * @param \OTGS\Toolset\Types\Field\Group\Repeatable\ItemPathBuilder $item_path_builder
	 * @param int $item_id
	 *
	 * @return string
	 */
	private function get_formatted_item_path( \OTGS\Toolset\Types\Field\Group\Repeatable\ItemPathBuilder $item_path_builder, $item_id ) {
		$path_array = $item_path_builder->get_item_path( $item_id );
		foreach ( $path_array as $parent_id => $parent_title ) {
			if ( empty( $parent_title ) ) {
				$path_array[ $parent_id ] = '#' . $parent_id;
			}
		}

		return implode( self::FIELD_PATH_SEPARATOR, $path_array );
	}


	/**
	 * Update fields when the job is done
	 *
	 * @action wpml_pro_translation_completed
	 *
	 * @param $new_post_id
	 * @param $fields
	 * @param $job
	 *
	 * @noinspection PhpUnusedParameterInspection
	 */
	public function wpml_pro_translation_completed( $new_post_id, $fields, $job ) {
		foreach ( $fields as $field_hash => $field_data ) {
			if ( ! $field_details = $this->resolve_translation_hash( $field_hash ) ) {
				// no rfg item field
				continue;
			}

			$id_target_lang = $this->repeatable_mapper_legacy->get_rfg_item_translation_or_create_it(
				$field_details['id'], $job->language_code
			);

			$field_definition = $this->field_definitions->load_field_definition( $field_details['fieldslug'] );

			if ( $id_target_lang ) {
				$field_slug = $field_definition->get_meta_key();
				update_post_meta( $id_target_lang, $field_slug, $field_data['data'] );
			}
		}
	}


	/**
	 * @param array $package
	 * @param Types_Field_Group_Repeatable $rfg
	 * @param WPML_Translation_Job_Helper $translation_job_helper
	 *
	 * @return mixed
	 */
	private function add_rfg_items(
		array $package,
		Types_Field_Group_Repeatable $rfg,
		WPML_Translation_Job_Helper $translation_job_helper
	) {
		if( ! $posts = $rfg->get_posts() ) {
			return $package;
		}

		foreach ( $posts as $rfg_item ) {
			foreach ( $rfg_item->get_fields() as $field ) {
				if ( ! $field->is_translatable() ) {
					continue;
				}

				$field_unique_translation_id = $this->get_translation_hash( $rfg_item->get_wp_post(), $field->get_slug() );

				// save field by $field_unique_translation_id
				$this->fields[ $field_unique_translation_id ] = $field;

				$field_value = $field->get_value();
				$field_value = ! empty( $field_value )
					? reset( $field_value )
					: '';

				$package['contents'][ $field_unique_translation_id ] = array(
					'translate' => 1,
					'data'      => $translation_job_helper->encode_field_data( $field_value ),
					'format'    => 'base64'
				);
			}

			foreach ( $rfg_item->get_field_groups() as $nested_rfg ) {
				$package = $this->add_rfg_items( $package, $nested_rfg, $translation_job_helper );
			}
		}

		return $package;
	}

	/**
	 * @param WP_Post $post
	 * @param $field_slug
	 *
	 * @return string
	 */
	private function get_translation_hash( WP_Post $post, $field_slug ) {
		return self::HASH_PART_POSTID . $post->ID . self::HASH_PART_FIELDSLUG . $field_slug;
	}

	/**
	 * @param $hash
	 *
	 * @return array|bool
	 */
	private function resolve_translation_hash( $hash ) {
		if ( strpos( $hash, self::HASH_PART_FIELDSLUG ) === false ) {
			// no valid hash (less expensive check, before doing heavy process)
			return false;
		}

		$pattern = '#' . self::HASH_PART_POSTID . '(.*)' . self::HASH_PART_FIELDSLUG . '(.*)#u';
		if ( preg_match( $pattern, $hash, $matches ) ) {
			return array( 'id' => $matches[1], 'fieldslug' => $matches[2] );
		}

		return false;
	}
}
