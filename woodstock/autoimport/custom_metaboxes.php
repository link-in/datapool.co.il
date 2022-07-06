<?php
if(function_exists("register_field_group")) {

	/* Woo Categories / Tags Settings */

	register_field_group(array (
		'id' => 'acf_products-categories',
		'title' => 'Products categories',
		'fields' => array (

			array (
				'key' => 'field_prodcat_icon',
				'label' => esc_html__('Catalog Icon', 'woodstock'),
				'name' => 'tdl_catalog_icon',
				'type' => 'image',
				'instructions' => esc_html__('Specify the image you want to display at the category area.', 'woodstock'),
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),

			array (
				'key' => 'field_prodcat_img',
				'label' => esc_html__('Header Content Type', 'woodstock'),
				'name' => 'tdl_header_content_type',
				'type' => 'select',
				'instructions' => esc_html__('Select the type of header content area.', 'woodstock'),
				'choices' => array (
					'hide' => esc_html__('Hide Title Area', 'woodstock'),
					'none' => esc_html__('None', 'woodstock'),
					'image' => esc_html__('Image', 'woodstock'),
					'custom' => esc_html__('Custom', 'woodstock'),
				),
				'default_value' => 'none',
				'allow_null' => 0,
				'multiple' => 0,
			),

			array (
				'key' => 'field_prodcat_custom',
				'label' => esc_html__('Custom Header', 'woodstock'),
				'name' => 'tdl_custom_header',
				'type' => 'wysiwyg',
				'instructions' => esc_html__('Specify the content you want to display at the top of current category page.', 'woodstock'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_prodcat_img',
							'operator' => '==',
							'value' => 'custom',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),

			array (
				'key' => 'field_prodcat_img_header',
				'label' => esc_html__('Image Header', 'woodstock'),
				'name' => 'tdl_image_header',
				'type' => 'image',
				'instructions' => esc_html__('Specify the image you want to display at the top of current category page.', 'woodstock'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_prodcat_img',
							'operator' => '==',
							'value' => 'image',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),

			array (
				'key' => 'field_prodcat_align',
				'label' => esc_html__('Title Content Align', 'woodstock'),
				'name' => 'tdl_align_select',
				'type' => 'select',
				'instructions' => esc_html__('Select the Title Content Align.', 'woodstock'),
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_prodcat_img',
									'operator' => '==',
									'value' => 'image',
								),
								array (
									'field' => 'field_prodcat_img',
									'operator' => '==',
									'value' => 'none',
								),								
							),
							'allorany' => 'any',
						),				
				'choices' => array (
					'title-left' => esc_html__('Left', 'woodstock'),
					'title-center' => esc_html__('Center', 'woodstock'),
				),
				'default_value' => 'title-left',
				'allow_null' => 0,
				'multiple' => 0,
			),						


		),
		'location' => array (
			array (
				array (
					'param' => 'ef_taxonomy',
					'operator' => '==',
					'value' => 'product_cat',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));


	/* Page Settings */
	register_field_group(array (
		'id' => 'acf_page-settings',
		'title' => 'Page Settings',
		'fields' => array (

			array (
				'key' => 'field_page_header_title',
				'label' => esc_html__('Show Title Area', 'woodstock'),
				'name' => 'tdl_hide_title',
				'type' => 'true_false',
				'instructions' => esc_html__('Check this if you want to show/hide page title area.', 'woodstock'),
				'message' => esc_html__('Show Title Area', 'woodstock'),
				'default_value' => 1,
			),		

			array (
				'key' => 'field_page_title',
				'label' => esc_html__('Page SubTitle', 'woodstock'),
				'name' => 'tdl_subtitle',
				'type' => 'text',
				'instructions' => esc_html__('Enter page subtitle.', 'woodstock'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_page_header_title',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
			),

			array (
				'key' => 'field_page_padding',
				'label' => esc_html__('Top/Bottom padding', 'woodstock'),
				'name' => 'tdl_page_padding',
				'type' => 'true_false',
				'instructions' => esc_html__('Check this if you want to add top/bottom page padding.', 'woodstock'),
				'message' => esc_html__('Top/Bottom padding', 'woodstock'),
				'default_value' => 1,
			),	

			array (
				'key' => 'field_page_img',
				'label' => esc_html__('Header Content Type', 'woodstock'),
				'name' => 'tdl_page_header_content_type',
				'type' => 'select',
				'instructions' => esc_html__('Select the type of header content area.', 'woodstock'),
				'choices' => array (					
					'none' => esc_html__('None', 'woodstock'),
					'image' => esc_html__('Image', 'woodstock'),
					'custom' => esc_html__('Custom', 'woodstock'),
				),
				'default_value' => 'none',
				'allow_null' => 0,
				'multiple' => 0,
			),

			array (
				'key' => 'field_page_custom',
				'label' => esc_html__('Custom Header', 'woodstock'),
				'name' => 'tdl_page_custom_header',
				'type' => 'wysiwyg',
				'instructions' => esc_html__('Specify the content you want to display at the top of current category page.', 'woodstock'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_page_img',
							'operator' => '==',
							'value' => 'custom',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),

			array (
				'key' => 'field_page_img_header',
				'label' => esc_html__('Image Header', 'woodstock'),
				'name' => 'tdl_page_image_header',
				'type' => 'image',
				'instructions' => esc_html__('Specify the image you want to display at the top of current page.', 'woodstock'),
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_page_img',
							'operator' => '==',
							'value' => 'image',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),

			array (
				'key' => 'field_page_align',
				'label' => esc_html__('Title Content Align', 'woodstock'),
				'name' => 'tdl_page_align_select',
				'type' => 'select',
				'instructions' => esc_html__('Select the Title Content Align.', 'woodstock'),
						'conditional_logic' => array (
							'status' => 1,
							'rules' => array (
								array (
									'field' => 'field_page_img',
									'operator' => '==',
									'value' => 'image',
								),
								array (
									'field' => 'field_page_img',
									'operator' => '==',
									'value' => 'none',
								),								
							),
							'allorany' => 'any',
						),				
				'choices' => array (
					'title-left' => esc_html__('Left', 'woodstock'),
					'title-center' => esc_html__('Center', 'woodstock'),
				),
				'default_value' => 'title-left',
				'allow_null' => 0,
				'multiple' => 0,
			),	

		),

		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'default',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-right-sidebar.php',
					'order_no' => 0,
					'group_no' => 2,
				),
			),	
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-left-sidebar.php',
					'order_no' => 0,
					'group_no' => 3,
				),
			),	
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-full-width.php',
					'order_no' => 0,
					'group_no' => 4,
				),
			),	
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-narrow.php',
					'order_no' => 0,
					'group_no' => 5,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));



	/* Sidebar */
	register_field_group(array (
		'id' => 'acf_sidebar',
		'title' => esc_html__('Video', 'woodstock'),
		'fields' => array (
			array (
				'key' => 'field_product_video',
				'label' => esc_html__('Video Embed Code', 'woodstock'),
				'name' => 'tdl_video_review',
				'type' => 'text',
				'instructions' => esc_html__('Enter the direct URL to a YouTube or Vimeo video page.', 'woodstock'),
				'message' => 'Set Custom Position',
			),

		),
		'location' => array (

			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
					'order_no' => 0,
					'group_no' => 6,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Post Type: Link */
	register_field_group(array (
		'id' => 'acf_post-type-link',
		'title' => esc_html__('Post Type: Link', 'woodstock'),
		'fields' => array (
			array (
				'key' => 'field_52613356beee6',
				'label' => esc_html__('Link URL', 'woodstock'),
				'name' => 'tdl_link_url',
				'type' => 'text',
				'instructions' => esc_html__('Specify the URL to replace post title permalink.', 'woodstock'),
				'default_value' => '',
				'placeholder' => esc_html__('URL', 'woodstock'),
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'link',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

	/* Post Type: Quote */
	register_field_group(array (
		'id' => 'acf_post-type-quote',
		'title' => esc_html__('Post Type: Quote', 'woodstock'),
		'fields' => array (
			array (
				'key' => 'field_526135682f07d',
				'label' => esc_html__('Quote Text', 'woodstock'),
				'name' => 'tdl_quote_text',
				'type' => 'textarea',
				'instructions' => esc_html__('Specify the quote text.', 'woodstock'),
				'default_value' => '',
				'placeholder' => esc_html__('Quote text', 'woodstock'),
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_526135822f07e',
				'label' => esc_html__('Quote Author', 'woodstock'),
				'name' => 'tdl_quote_author',
				'type' => 'text',
				'instructions' => esc_html__('Specify the quote author.', 'woodstock'),
				'default_value' => '',
				'placeholder' => esc_html__('Quote author', 'woodstock'),
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'post_format',
					'operator' => '==',
					'value' => 'quote',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));

}
