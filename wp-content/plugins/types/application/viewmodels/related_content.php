<?php

use OTGS\Toolset\Types\Page\Extension\RelatedContent\DirectEditStatusFactory;

/**
 * Related Content. Elements related to a specific element.
 *
 * @since m2m
 */
abstract class Types_Viewmodel_Related_Content {


	/**
	 * Relationship
	 *
	 * @var Toolset_Relationship_Definition
	 * @since m2m
	 */
	protected $relationship;

	/**
	 * Role
	 *
	 * @var Toolset_Relationship_Role
	 * @since m2m
	 */
	protected $role;

	/**
	 * Role of the related element
	 *
	 * @var string
	 * @since m2m
	 */
	protected $related_element_role;

	/** @var Toolset_Constants */
	protected $constants;

	/** @var \OTGS\Toolset\Common\Relationships\API\Factory */
	protected $relationships_factory;

	/** @var DirectEditStatusFactory */
	protected $direct_edit_status_factory;

	/** @var \OTGS\Toolset\Common\WPML\WpmlService */
	protected $wpml_service;


	/**
	 * Constructor
	 *
	 * @param string|Toolset_Relationship_Role $role Relationship role.
	 * @param Toolset_Relationship_Definition $relationship Relationship type.
	 * @param \OTGS\Toolset\Common\Relationships\API\Factory $relationships_factory
	 * @param \OTGS\Toolset\Common\WPML\WpmlService $wpml_service
	 * @param Toolset_Constants|null $constants Constants handler.
	 * @param DirectEditStatusFactory|null $direct_edit_status_factory
	 */
	public function __construct(
		$role,
		$relationship,
		\OTGS\Toolset\Common\Relationships\API\Factory $relationships_factory,
		\OTGS\Toolset\Common\WPML\WpmlService $wpml_service,
		Toolset_Constants $constants = null,
		DirectEditStatusFactory $direct_edit_status_factory = null
	) {
		$this->role = Toolset_Relationship_Role::PARENT === $role
			? new Toolset_Relationship_Role_Parent()
			: new Toolset_Relationship_Role_Child();
		$this->relationship = $relationship;
		$this->constants = ( null === $constants ? new Toolset_Constants() : $constants );

		$this->related_element_role = Toolset_Relationship_Role::other( $this->role );
		$this->direct_edit_status_factory = $direct_edit_status_factory ? : new DirectEditStatusFactory();
		$this->relationships_factory = $relationships_factory;
		$this->wpml_service = $wpml_service;
	}


	/**
	 * Returns the related content
	 *
	 * @return array Related content.
	 * @since m2m
	 */
	abstract public function get_related_content();


	/**
	 * Gets the related content as an array for using in the admin frontend for exporting to JSON format.
	 *
	 * @param null $post_id
	 * @param string $post_type
	 * @param int $page_number
	 * @param int $items_per_page
	 * @param null $role
	 * @param string $sort
	 * @param string $sort_by
	 * @param string $sort_origin
	 *
	 * @since m2m
	 */
	abstract public function get_related_content_array( $post_id = null, $post_type = '', $page_number = 1, $items_per_page = 0, $role = null, $sort = 'ASC', $sort_by = 'displayName', $sort_origin = 'post_title' );

}
