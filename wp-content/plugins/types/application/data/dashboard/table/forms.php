<?php
return array(
	/* CRED missing */
	'cred-missing' => array(
		'type' => 'forms',

		'conditions'=> array(
			'Types_Helper_Condition_Cred_Missing'
		),

		'description' => array(
			array(
				'type'   => 'dialog',
				'class'  => 'button',
				'label'  => __( 'Create Form', 'wpcf' ),
				'dialog' => array(
					'id' => 'create-form',
					'description' => array(
						array(
							'type' => 'paragraph',
							'content' => __( 'To create forms, you need to activate Toolset Forms plugin.', 'wpcf' )
						),
						array(
							'type'   => 'link',
							'class'  => 'button-primary types-button',
							'external' => true,
							'label'  => __('Download Toolset Forms from your Toolset account', 'wpcf' ),
							'target' => Types_Helper_Url::get_url( 'toolset-account-downloads', 'popup', false, 'gui' ),
						),
					)
				)
			)
		),
	),

	/* CRED, forms missing */
	'cred-forms-missing' => array(
		'type' => 'forms',

		'conditions'=> array(
			'Types_Helper_Condition_Layouts_Missing',
			'Types_Helper_Condition_Cred_Forms_Missing'
		),

		'description' => array(
			array(
				'type'   => 'link',
				'class'  => 'button',
				'target' => '%POST-CREATE-FORM%',
				'label'  => __( 'Create form', 'wpcf' )
			)
		)
	),

	/* CRED, forms */
	'cred-forms' => array(
		'type' => 'forms',

		'conditions'=> array(
			'Types_Helper_Condition_Cred_Active',
			'Types_Helper_Condition_Layouts_Missing',
			'Types_Helper_Condition_Cred_Forms_Exist'
		),

		'description' => array(
			array(
				'type' => 'paragraph',
				'content' => '%POST-FORMS-LIST%',
			),
			array(
				'type'   => 'link',
				'class'  => 'button',
				'target' => '%POST-CREATE-FORM%',
				'label'  => __( 'Create form', 'wpcf' )
			)
		)
	),

	/* CRED & Layouts, forms missing */
	'cred-layouts-forms-missing' => array(
		'type' => 'forms',

		'conditions'=> array(
			'Types_Helper_Condition_Layouts_Active',
			'Types_Helper_Condition_Cred_Forms_Missing'
		),

		'description' => array(
			array(
				'type' => 'paragraph',
				'content' => __(
					'You can create forms for front-end submission and editing of %POST-LABEL-PLURAL%.', 'wpcf'
				)
			),
			array(
				'type'   => 'link',
				'external' => true,
				'target' => Types_Helper_Url::get_url( 'adding-forms-to-layouts', 'table', false, 'gui' ),
				'label'  => __( 'Learn how', 'wpcf' )
			),
		)
	),

	/* CRED & Layouts, forms exists */
	'cred-layouts-forms' => array(
		'type' => 'forms',

		'conditions'=> array(
			'Types_Helper_Condition_Layouts_Active',
			'Types_Helper_Condition_Cred_Forms_Exist'
		),

		'description' => array(
			array(
				'type' => 'paragraph',
				'content' => '%POST-FORMS-LIST%'
			),
			array(
				'type'   => 'link',
				'external' => true,
				'target' => Types_Helper_Url::get_url( 'adding-forms-to-layouts', 'table', false, 'gui' ),
				'label'  => __( 'How to add forms to layouts', 'wpcf' )
			),
		)
	),
);
