<?php

/**
 * Class Types_Field_Type_Single_Line
 *
 * @since 2.3
 */
class Types_Field_Type_Single_Line extends Types_Field_Abstract {
	/**
	 * @var string
	 */
	protected $placeholder;

	/**
	 * @var string
	 */
	protected $default_value;

	/**
	 * @var Types_Field_Setting_Bool_Interface
	 */
	protected $repeatable;

	/**
	 * Types_Field_Type_Single_Line constructor.
	 *
	 * @param array $data (see getDefaultProperties() for used keys)
	 */
	public function __construct( $data ) {
		// merge user data with default data
		$data = array_merge( $this->get_default_properties(), $data );

		// slug / title / description / value
		parent::__construct( $data );

		$this->set_placeholder( $data['placeholder'] );
		$this->set_default_value( $data['default_value'] );
		$this->set_repeatable( $data['repeatable'] );
	}

	/**
	 * @return array
	 */
	private function get_default_properties() {
		return array(
			'slug'          => null,
			'title'         => null,
			'description'   => null,
			'value'         => null,
			'placeholder'   => null,
			'default_value' => null,
			'repeatable'    => false
		);
	}

	/**
	 * @param mixed $data
	 */
	private function set_placeholder( $data ) {
		if ( ! is_string( $data ) ) {
			return;
		}

		$this->placeholder = $data;
	}

	/**
	 * @param array $data
	 */
	private function set_default_value( $data ) {
		if ( ! is_string( $data ) ) {
			return;
		}

		$this->default_value = $data;
	}

	/**
	 * @param Types_Field_Setting_Bool_Interface $data
	 */
	private function set_repeatable( Types_Field_Setting_Bool_Interface $data ) {
		$this->repeatable = $data;
	}

	/**
	 * @return string
	 */
	public function get_type() {
		return 'single-line';
	}

	/**
	 * @return string
	 */
	public function get_placeholder() {
		return $this->placeholder;
	}

	/**
	 * @return string
	 */
	public function get_default_value() {
		return $this->default_value;
	}

	/**
	 * @return boolean
	 */
	public function is_repeatable() {
		return $this->repeatable->is_true();
	}
}