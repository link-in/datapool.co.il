<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

if ( $order ) : ?>

    <div class="thank_you_header text-center">
    
        <?php if ( $order->has_status( 'failed' ) ) : ?>
    
            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>    
            <p><?php
                if ( is_user_logged_in() )
                    esc_html_e( 'Please attempt your purchase again or go to your account page.', 'woocommerce' );
                else
                    esc_html_e( 'Please attempt your purchase again.', 'woocommerce' );
            ?></p>
    
            <p>
                <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ) ?></a>
                <?php if ( is_user_logged_in() ) : ?>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
                <?php endif; ?>
            </p>
    
        <?php else : ?>
            
            <div class="thank_you_header_text">         
                <div class="row">
                    <div class="large-9 large-centered columns">
                    <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>                    
                    </div><!-- .xlarge-6-->
                </div><!--  .row    -->                
            </div>
    
            <div class="order_details_container">
                    
                <div class="row">
                    <div class="large-9 large-centered columns">
                        <div class="order_inside">
                            <ul class="order_details">
                                <li class="order">
                                    <span class="title"><?php esc_html_e( 'Order number:', 'woocommerce' ); ?></span>
                                    <strong><?php echo wp_kses_post($order->get_order_number()); ?></strong>
                                </li>
                                <li class="date">
                                    <span class="title"><?php esc_html_e( 'Date:', 'woocommerce' ); ?></span>
                                    <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
                                </li>
                                <li class="total">
                                    <span class="title"><?php esc_html_e( 'Total:', 'woocommerce' ); ?></span>
                                    <strong><?php echo wp_kses_post($order->get_formatted_order_total()); ?></strong>
                                </li>
                                <?php if ( $order->get_payment_method_title() ) : ?>
                                <li class="method">
                                    <span class="title"><?php esc_html_e( 'Payment method:', 'woocommerce' ); ?></span>
                                    <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                
                    </div><!-- .xlarge-6-->
                </div><!--  .row    -->
                
            </div><!--.order_details_container-->
            <div class="clear"></div>
    
        <?php endif; ?>
    
    </div><!-- .thank_you_header-->
    
    <div class="row">
        <div class="large-9 large-centered columns">
            
            <div class="thank_you_bank_details">
        <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>           
            <div class="order_detail_box bordered">
        <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>            
        </div><!-- .medium-10-->
    </div><!--  .row    -->

<?php else : ?>
    <div class="row">
        <div class="large-9 large-centered text-center columns">
            <div class="thank_you_header">
        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
    </div>
    </div>
<?php endif; ?>