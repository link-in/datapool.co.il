<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

?>

<style>
.site_header.with_featured_img,
.site_header.without_featured_img {
	margin-bottom: 80px;
}

.site-content {
	margin-bottom: 80px;
}
</style>


<div class="row">
	<div class="medium-10 medium-centered large-6 large-centered columns">

		<div class="login-register-container">
				
			<div class="account-forms-container">

				<form method="post" class="woocommerce-ResetPassword lost_reset_password">

					<p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

					<p class="woocommerce-form-row form-row">
						<label for="user_login"><?php _e( 'Username or email', 'woocommerce' ); ?></label>
						<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" />
					</p>

					<div class="clear"></div>

					<?php do_action( 'woocommerce_lostpassword_form' ); ?>

					<p class="woocommerce-form-row form-row">
						<input type="hidden" name="wc_reset_password" value="true" />
						<button type="submit" class="woocommerce-Button button" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
					</p>

					<?php wp_nonce_field( 'lost_password' ); ?>

				</form>

			</div><!-- .account-forms-container	-->
		
		</div><!-- .login-register-container-->
	</div><!-- .medium-8 .large-6-->
</div><!-- .row-->
