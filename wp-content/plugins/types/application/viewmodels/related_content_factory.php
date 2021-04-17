<?php

/**
 * Factory for viewmodels of related content, for the purposes of the Edit pages.
 *
 * @since m2m
 */
class Types_Viewmodel_Related_Content_Factory {

	/** @var \OTGS\Toolset\Common\Relationships\API\Factory */
	private $relationships_factory;

	/** @var \OTGS\Toolset\Common\WPML\WpmlService */
	private $wpml_service;


	/**
	 * Types_Viewmodel_Related_Content_Factory constructor.
	 *
	 * @param \OTGS\Toolset\Common\Relationships\API\Factory $relationships_factory
	 * @param \OTGS\Toolset\Common\WPML\WpmlService $wpml_service
	 */
	public function __construct(
		\OTGS\Toolset\Common\Relationships\API\Factory $relationships_factory,
		\OTGS\Toolset\Common\WPML\WpmlService $wpml_service
	) {
		$this->relationships_factory = $relationships_factory;
		$this->wpml_service = $wpml_service;
	}


	/**
	 * For a given field domain, return the appropriate related content factory instance.
	 *
	 * @param string                          $role Relationship element role.
	 * @param Toolset_Relationship_Definition $relationship The relationship.
	 *
	 * @return Types_Viewmodel_Related_Content_Post
	 * @throws RuntimeException When the domains is incorrect.
	 * @since m2m
	 */
	public function get_model_by_relationship( $role, $relationship ) {
		switch ( $relationship->get_domain( $role ) ) {
			case Toolset_Element_Domain::POSTS:
				return new Types_Viewmodel_Related_Content_Post(
					$role, $relationship, $this->relationships_factory, $this->wpml_service
				);
			default:
				throw new RuntimeException( 'Not implemented.' );
		}
	}
}
