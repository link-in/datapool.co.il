<?php
/**
 * Functions and Hooks for product meta box data
 *
 * @package Woodstock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Woodstock_Meta_Box_Product_Data class.
 */
class Woodstock_Meta_Box_Product_Data {

	/**
	 * Constructor.
	 */
	public function __construct() {

		if ( ! function_exists( 'is_woocommerce' ) ) {
			return false;
		}
		// Add form
		add_action( 'woocommerce_product_data_panels', array( $this, 'product_meta_fields' ) );
		add_action( 'woocommerce_product_data_tabs', array( $this, 'product_meta_tab' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'product_meta_fields_save' ) );

		add_action( 'wp_ajax_product_meta_fields', array( $this, 'instance_product_meta_fields' ) );
		add_action( 'wp_ajax_nopriv_product_meta_fields', array( $this, 'instance_product_meta_fields' ) );
	}

	/**
	 * Get product data fields
	 *
	 */
	public function instance_product_meta_fields() {
		$post_id = $_POST['post_id'];
		ob_start();
		$this->create_product_extra_fields( $post_id );
		$response = ob_get_clean();
		wp_send_json_success( $response );
		die();
	}

	/**
	 * Product data tab
	 */
	public function product_meta_tab( $product_data_tabs ) {

		$product_data_tabs['woodstock_attributes_extra'] = array(
			'label'  => esc_html__( 'Product Attribute', 'woodstock' ),
			'target' => 'product_attributes_extra',
			'class'  => 'product-attributes-extra'
		);

		return $product_data_tabs;
	}

	/**
	 * Add product data fields
	 *
	 */
	public function product_meta_fields() {
		global $post;

		echo '<div id="product_attributes_extra" class="panel woocommerce_options_panel">';
		$this->create_product_extra_fields( $post->ID );
		echo '</div>';
	}

	/**
	 * product_meta_fields_save function.
	 *
	 * @param mixed $post_id
	 */
	public function product_meta_fields_save( $post_id ) {

		if ( isset( $_POST['attributes_extra'] ) ) {
			$woo_data = $_POST['attributes_extra'];
			update_post_meta( $post_id, 'attributes_extra', $woo_data );
		}
	}


	/**
	 * Create product meta fields
	 *
	 * @param $post_id
	 */
	public function create_product_extra_fields( $post_id ) {
		$attributes = maybe_unserialize( get_post_meta( $post_id, '_product_attributes', true ) );

		if ( ! $attributes ) : ?>
			<div id="message" class="inline notice woocommerce-message">
				<p><?php esc_html_e( 'You need to add attributes on the Attributes tab.', 'woodstock' ); ?></p>
			</div>

		<?php else :
			$options         = array();
			$options['']     = esc_html__( 'Default', 'woodstock' );
			$options['none'] = esc_html__( 'None', 'woodstock' );
			foreach ( $attributes as $attribute ) {
				$options[sanitize_title( $attribute['name'] )] = wc_attribute_label( $attribute['name'] );
			}
			woocommerce_wp_select(
				array(
					'id'       => 'attributes_extra',
					'label'    => esc_html__( 'Product Attribute', 'woodstock' ),
					'desc_tip' => esc_html__( 'Show product attribute for each item listed under the item name.', 'woodstock' ),
					'options'  => $options
				)
			);

		endif;

	}
}