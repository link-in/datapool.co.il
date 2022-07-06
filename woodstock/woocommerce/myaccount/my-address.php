<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        array(
            'billing'  => __( 'Billing address', 'woocommerce' ),
            'shipping' => __( 'Shipping address', 'woocommerce' ),
        ),
        $customer_id
    );
} else {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        array(
            'billing' => __( 'Billing address', 'woocommerce' ),
        ),
        $customer_id
    );
}

$oldcol = 1;
$col    = 1;
?>

<style>
.site_header.with_featured_img,
.site_header.without_featured_img {
    margin-bottom: 50px;
}
</style>


<div class="my_address_wrapper">

    <p class="my_address_description">
    <?php echo apply_filters( 'woocommerce_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); ?>
    </p>
    
    <div class="shipping_billing_wrapper">
    
<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) echo '<div class="u-columns woocommerce-Addresses col2-set addresses">'; ?>        
        <?php foreach ( $get_addresses as $name => $address_title ) : ?>
        <?php
            $address = wc_get_account_formatted_address( $name );
            $col     = $col * -1;
            $oldcol  = $oldcol * -1;
        ?>            
        
        <div class="medium-6 columns">
            <header class="woocommerce-Address-title title">
                <h3><?php echo esc_html( $address_title ); ?></h3>
            </header>
            <address>
                <?php
                    echo wp_kses_post($address) ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );
                ?>
            </address>
                
            <span class="edit-link">
                <a href="<?php echo wc_get_endpoint_url( 'edit-address', $name ); ?>" class="post-edit-link"><i class="fa fa-pencil"></i><?php esc_html_e( 'Edit', 'woocommerce' ); ?></a>
            </span>
                
        </div>
        
        <?php endforeach; ?>
        
<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) echo '</div>'; ?>
    
    </div><!--.shipping_billing_wrapper-->

</div><!--.my_address_wrapper-->
