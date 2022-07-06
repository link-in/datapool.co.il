<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$tdl_options = woodstock_global_var();
?>

<style>
.site-content {
	margin-top: 80px;
	margin-bottom: 80px;
}
</style>


<div class="row">
	<div class="medium-10 medium-centered large-6 large-centered columns">
		
		<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

		<div class="login-register-container">
				
			<div class="row">
				
			
				<div class="large-12 columns">
					<div class="account-forms-container">
						<ul class="account-tab-list">
							
							<li class="account-tab-item"><a class="account-tab-link current" href="#login"><?php esc_html_e( 'Login', 'woocommerce' ); ?></a></li>
							
							<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
								<li class="account-tab-item last"><a class="account-tab-link" href="#register"><?php esc_html_e( 'Register', 'woocommerce' ); ?></a></li>
							<?php endif; ?>
						
						</ul>
						
						<div class="account-forms">
							<form id="login" method="post" class="login-form woocommerce-form woocommerce-form-login login">

								<?php do_action( 'woocommerce_login_form_start' ); ?>
					
								<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
									<label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
									<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
								</p>
								<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
									<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
									<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
								</p>		

								<?php do_action( 'woocommerce_login_form' ); ?>
					
								<p class="form-row">
									<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
									<input type="submit" class="woocommerce-Button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>" />

									<label for="rememberme" class="inline">
										<input class="woocommerce-Input woocommerce-Input--checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember me', 'woocommerce' ); ?>
									</label>
								</p>
								<p class="woocommerce-LostPassword lost_password">
									<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
								</p>

								<?php do_action( 'woocommerce_login_form_end' ); ?>
										
							</form>
							
			<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
							<div id="register" style="display:none">
							<h2>הרשמה</h2>
									<h4>*יש למלא את כל הפרטים על מנת להירשם , לאחר ההרשמה נציגנו יעבור על הפרטים ויאשר את התחברות לאתר</h4>
									<?php echo do_shortcode('[user_registration_form id="7624"]'); ?>
							</div>	
								
						<?php endif; ?>
                        	
						</div><!-- .account-forms-->
					</div><!-- .account-forms-container-->
				</div><!-- .medium-8-->
			</div><!-- .row-->
		</div><!-- .login-register-container-->
		
		<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

	</div><!-- .large-6-->
</div><!-- .rows-->
<script>
jQuery( document ).ready(function() {
	jQuery('.account-tab-item.last').click(function(){
		jQuery('.register').show();
	});
});
</script>