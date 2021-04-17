<?php

/**
 * Class Types_Field_Type_Audio
 *
 * @since 2.3
 */
class Types_Field_Type_Audio extends Types_Field_Abstract {
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
	 * @return string
	 */
	public function get_type() {
		return 'audio';
	}

	/**
	 * Types_Field_Type_Audio constructor.
	 *
	 * @param array $data
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
			'slug' => null,
			'title' => null,
			'description' => null,
			'value' => null,
			'placeholder' => null,
			'default_value' => null,
			'repeatable' => null
		);
	}

	/**
	 * @param string|array $data
	 */
	protected function set_value( $data ) {
		if( ! is_array( $data ) && ! is_string( $data ) ) {
			return;
		}

		$valid_data = array();

		foreach( (array) $data as $value ) {
			if ( preg_match('/\.(mp3|m4a|ogg|wav|wma)$/i', $value ) ) {
				$valid_data[] = $value;
			}
		}

		$this->value = ! empty( $valid_data )
			? $valid_data
			: null;
	}

	/**
	 * @return string
	 */
	public function get_placeholder() {
		return $this->placeholder;
	}

	/**
	 * @param array $data
	 */
	private function set_placeholder( $data ) {
		if( ! is_string( $data ) ) {
			return;
		}

		$this->placeholder = $data;
	}

	/**
	 * @return string
	 */
	public function get_default_value() {
		return $this->default_value;
	}

	/**
	 * @param array $data
	 */
	private function set_default_value( $data ) {
		if( ! is_string( $data ) ) {
			return;
		}

		$this->default_value = $data;
	}

	/**
	 * @return boolean
	 */
	public function is_repeatable() {
		return $this->repeatable->is_true();
	}

	/**
	 * @param Types_Field_Setting_Bool_Interface $data
	 */
	private function set_repeatable( Types_Field_Setting_Bool_Interface $data ) {
		$this->repeatable = $data;
	}
}