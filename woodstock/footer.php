<?php 
$tdl_options = woodstock_global_var();
$footer_logos = isset($tdl_options['tdl_footer_logos_off']);
$tdl_footer_color_scheme = (!empty($tdl_options['tdl_footer_color_scheme'])) ? $tdl_options['tdl_footer_color_scheme'] : 'fc-light';
$tdl_sidebarnav_color_scheme = (!empty($tdl_options['tdl_sidebarnav_color_scheme'])) ? $tdl_options['tdl_sidebarnav_color_scheme'] : 'snd-light';
$tdl_sidebarcart_color_scheme = (!empty($tdl_options['tdl_sidebarcart_color_scheme'])) ? $tdl_options['tdl_sidebarcart_color_scheme'] : 'scd-light';
$tdl_header_ajax_loader = (!empty($tdl_options['tdl_header_ajax_loader'])) ? $tdl_options['tdl_header_ajax_loader'] : 'spinner-circle';
$payment_logos = (!empty($tdl_options['tdl_footer_logos']['url'])) ? $tdl_options['tdl_footer_logos']['url'] : '';


$active_sidebar = "";

if ( is_active_sidebar('footer-sidebar-1') OR is_active_sidebar('footer-sidebar-2') OR is_active_sidebar('footer-sidebar-3') OR is_active_sidebar('footer-sidebar-4') ) :
	$active_sidebar = "active";
endif;


$number_of_widgets = (!empty($tdl_options['tdl_footer_layout'])) ? $tdl_options['tdl_footer_layout'] : '0';

		if ( $number_of_widgets == 4 ) {
			$grid_class = "large-3 medium-6 columns";
		} 
		else if ( $number_of_widgets == 3 ) {
			$grid_class = "large-4 medium-6 columns";
		}
		else if ( $number_of_widgets == 2 ) {
			$grid_class = "large-6 medium-6 columns";
		}		
		else if ( $number_of_widgets == 1 ) {
			$grid_class = "large-12 columns";
		}

$footer_text = (!empty($tdl_options['tdl_footer_text'])) ? $tdl_options['tdl_footer_text'] : '&copy; 2021 - Woodstock Woocommerce Theme. Created by <a href=\'https://temash.design\'>temash.design</a>';
?>

<footer id="site-footer" class="<?php echo esc_attr($tdl_footer_color_scheme) ?> <?php echo esc_attr($active_sidebar)?>">

	<?php if( $number_of_widgets !== '0' ) { ?>
	<div class="f-columns shop_sidebar">

		<div class="row">

		    <?php if ( $number_of_widgets <= 4 ): ?>
		        <?php for ( $i = 1; $i <= $number_of_widgets; $i++ ) { ?>
		            <section class="<?php echo esc_attr($grid_class);?> column-widget">
		            <?php if ( is_active_sidebar( 'footer-sidebar-' . $i ) ) { ?><?php dynamic_sidebar( 'footer-sidebar-' . $i ); ?><?php } ?>
		            </section>
		        <?php } // end foreach ?>
		    <?php endif; ?>
		    
		    <?php if ( $number_of_widgets == 5 ) : ?>
		    
		    <section class="large-3 medium-4 columns column-widget">
				<?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) { ?><?php dynamic_sidebar( 'footer-sidebar-1' ); ?><?php } ?>
		    </section>
		    <section class="large-3 medium-4 columns column-widget">
				<?php if ( is_active_sidebar( 'footer-sidebar-2' ) ) { ?><?php dynamic_sidebar( 'footer-sidebar-2' ); ?><?php } ?>
		    </section>
		    <section class="large-6 medium-4 columns column-widget">
				<?php if ( is_active_sidebar( 'footer-sidebar-3' ) ) { ?><?php dynamic_sidebar( 'footer-sidebar-3' ); ?><?php } ?>
		    </section>
		    
		    <?php endif; ?>
		    
		    <?php if ( $number_of_widgets == 6 ) : ?>
		    
		    <section class="large-3 medium-4 columns column-widget">
				<?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) { ?><?php dynamic_sidebar( 'footer-sidebar-1' ); ?><?php } ?>
		    </section>
		    <section class="large-6 medium-4 columns column-widget">
				<?php if ( is_active_sidebar( 'footer-sidebar-2' ) ) { ?><?php dynamic_sidebar( 'footer-sidebar-2' ); ?><?php } ?>
		    </section>
		    <section class="large-3 medium-4 columns column-widget">
				<?php if ( is_active_sidebar( 'footer-sidebar-3' ) ) { ?><?php dynamic_sidebar( 'footer-sidebar-3' ); ?><?php } ?>
		    </section>
		    
		    <?php endif; ?>
		    
		    <?php if ( $number_of_widgets == 7 ) : ?>
		    
		    <section class="large-6 medium-4 columns column-widget">
				<?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) { ?><?php dynamic_sidebar( 'footer-sidebar-1' ); ?><?php } ?>
		    </section>
		    <section class="large-3 medium-4 columns column-widget">
				<?php if ( is_active_sidebar( 'footer-sidebar-2' ) ) { ?><?php dynamic_sidebar( 'footer-sidebar-2' ); ?><?php } ?>
		    </section>
		    <section class="large-3 medium-4 columns column-widget">
				<?php if ( is_active_sidebar( 'footer-sidebar-3' ) ) { ?><?php dynamic_sidebar( 'footer-sidebar-3' ); ?><?php } ?>
		    </section>
		    
		    <?php endif; ?>
		</div>

	</div>
	<?php } ?> 

	<?php if ( has_nav_menu( 'footer-navigation' ) ) : ?> 
		<div id="footer-navigation">
			<div class="row">
				<div class="large-12 columns">
					<nav id="site-navigation-footer" class="footer-navigation">              
						<?php 
							wp_nav_menu(array(
								'theme_location'  => 'footer-navigation',
								'fallback_cb'     => false,
								'container'       => false,
								'depth' => 1,
								'items_wrap'      => '<ul id="%1$s">%3$s</ul>',
							));
						?> 
					</nav><!-- #site-navigation-footer --> 
				</div>
			</div>	
		</div>	
	<?php endif; ?> 				


	<div class="f-copyright">
		<div class="row">
			<?php if ( $footer_logos == '1' ) : ?>
				<div class="large-6 columns copytxt"><p><?php echo wp_kses( $tdl_options['tdl_footer_text'], 'default' ); ?></p></div>            
				<div class="large-6 columns cards">
				<img src="<?php echo esc_url($payment_logos); ?>" />
				</div>
				<?php else: ?>
				<div class="medium-12 columns copytxt"><p><?php echo wp_kses( $footer_text, 'default' ); ?></p></div>
			<?php endif; ?> 
		</div>		
	</div>

</footer>

<?php if ( (isset($tdl_options['tdl_sticky_menu'])) && (trim($tdl_options['tdl_sticky_menu']) == "1" ) ) : ?>
	<!-- ******************************************************************** -->
    <!-- * Sticky Header **************************************************** -->
    <!-- ******************************************************************** -->
	<header id="header-st">
		<div class="row <?php echo esc_attr($tdl_options['tdl_sticky_color_scheme']); ?> <?php echo esc_attr($tdl_options['tdl_stickydrop_color_scheme']); ?>">
			<div class="large-12 columns">



				<!-- Main Navigation -->

				<?php if( function_exists( 'ubermenu' ) ): ?>
					<div id="sticky-site-nav" class="ubermenu">
						<div class="nav-container row">
							<?php 
								wp_nav_menu(array(
									'theme_location'  => 'main_navigation',
									'fallback_cb'     => false,
									'container'       => false,
									'items_wrap'      => '%3$s',
								));
							?>	
						</div>	
					</div>
				<?php else: ; ?>	

				<div class="mobile-menu-button"><a><i class="mobile-menu-icon"></i><span class="mobile-menu-text"><?php esc_html_e( 'Menu', 'woodstock' )?></span></a></div>

					<div id="sticky-site-nav" class="l-nav h-nav">
						<div class="nav-container row">
			 				<nav id="nav" class="nav-holder">
								<ul class="navigation menu tdl-navbar-nav mega_menu">
									<?php echo woodstock_mega_menu();?>
								</ul>	
							</nav> 
						</div>
					</div>	<!-- End Main Navigation -->		
				<?php endif; ?>					


			<?php if (class_exists('WooCommerce')) : ?>
				<?php if ( (isset($tdl_options['tdl_catalog_mode'])) && ($tdl_options['tdl_catalog_mode'] == 0) ) : ?>
					<!-- Shop Section -->
					<div class="shop-bag">
							<?php if ( (isset($tdl_options['tdl_offcanvas_minicart'])) && ($tdl_options['tdl_offcanvas_minicart'] == 0) ) : ?>
								<a href="<?php echo wc_get_cart_url(); ?>">
							<?php else: ?>
								<a>
							<?php endif; ?>
							<div class="l-header-shop">	
								<span class="shopbag_items_number"><?php echo WC()->cart->cart_contents_count; ?></span>	    		
								<i class="icon-shop"></i>
								<div class="overview">
									<span class="bag-items-number"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count, 'woodstock' ), WC()->cart->cart_contents_count ); ?></span>
									<?php echo WC()->cart->get_cart_subtotal(); ?>	
								</div>
							</div>
						</a>				
					</div>
				<?php endif; ?>
			<?php endif; ?>				


			</div>

		</div>	
    </header>
<?php endif; ?>	

</div><!-- /boxed-layout -->
</div><!-- /page-wrap -->

</div><!-- /off-content -->
</div><!-- /off-drop -->

	<nav class="off-menu st-mobnav slide-from-left <?php echo esc_attr($tdl_sidebarnav_color_scheme); ?>">
		<div class="nano">
			<div class="nano-content">
				<div id="mobiles-menu-offcanvas" class="offcanvas-left-content">
					<!-- Close Icon -->
					<a href="#" class="close-icon"></a>
					<div class="clearfix"></div>

					<?php if ( (isset($tdl_options['tdl_header_search_bar'])) && ($tdl_options['tdl_header_search_bar'] == "1") ) : ?>
							<!-- Search Section -->
					        <div class="l-search">

							<?php 
								woodstock_search_form( array(
									'ajax' => $tdl_options['tdl_header_ajax_search'],
									'count' => $tdl_options['tdl_header_ajax_search_count'],
									'post_type' => $tdl_options['tdl_header_search_pt'],
									// 'show_categories' => $tdl_options['tdl_header_search_categories'],
									'type' => 'form',
								) );
							?>					        	

					        </div>
					        <?php endif; ?>

							<?php if ( (isset($tdl_options['tdl_header_customer_bar'])) && ($tdl_options['tdl_header_customer_bar'] == "1") ) : ?>
								<!-- Contact Section -->
								<div class="contact-info">
									<div class="inside-content">
										<?php if ( (isset($tdl_options['tdl_header_contactbox_icon'])) && ($tdl_options['tdl_header_contactbox_icon'] != "none") ) : ?>
											<span class="contact-info-icon"></span>
										<?php endif; ?>								
					 					<span class="contact-info-title">
											<?php if ( isset($tdl_options['tdl_header_customer_bar_subtitle']) ) : ?>                        
												<span class="contact-info-subtitle"><?php echo esc_attr($tdl_options['tdl_header_customer_bar_subtitle']); ?></span>					
											<?php endif; ?>	
											<?php echo esc_attr($tdl_options['tdl_header_customer_bar_title']); ?>		 								 										
					 					</span>

					 					<?php if ( (isset($tdl_options['tdl_header_customer_bar_text'])) && (trim($tdl_options['tdl_header_customer_bar_text']) != "" ) ) : ?>
										<span class="contact-info-arrow"></span> 

										<div class="inside-area">
											<div class="inside-area-content">
											<?php echo do_shortcode($tdl_options['tdl_header_customer_bar_text']); ?>
											<div class="after-clear"></div>		
											</div>
										</div>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>

							<nav id="mobile-main-navigation" class="mobile-navigation">
								<?php 
									wp_nav_menu(array(
										'theme_location'  => 'main_navigation',
										'fallback_cb'     => false,
										'container'       => false,
										'menu_id' => 'mob-main-menu',
										'items_wrap'      => '<ul id="%1$s">%3$s</ul>',
									));
								?>
		                    </nav>

							<?php						
								$theme_locations  = get_nav_menu_locations();
								if (isset($theme_locations['top-bar-navigation'])) {
									$menu_obj = get_term($theme_locations['top-bar-navigation'], 'nav_menu');
								}
								
								if ( (isset($menu_obj->count) && ($menu_obj->count > 0)) || (is_user_logged_in()) ) {
								?>
		                        
		                        <nav id="mobile-top-bar-navigation" class="mobile-navigation">
		                            <?php 
		                                wp_nav_menu(array(
		                                    'theme_location'  => 'top-bar-navigation',
		                                    'fallback_cb'     => false,
		                                    'container'       => false,
		                                    'items_wrap'      => '<ul id="%1$s">%3$s</ul>',
		                                ));
		                            ?>
		                        </nav>

		                    <?php } ?>

					            <nav id="mobile-right-top-bar-navigation" class="mobile-navigation"> 
					                <ul id="mob-my-account">
					                <?php
					                if ( is_user_logged_in() ) { ?>
						                <?php if ( (isset($tdl_options['tdl_catalog_mode'])) && ($tdl_options['tdl_catalog_mode'] == 0) ) : ?>
		                    				<?php if ( has_nav_menu( 'myaccount-navigation' ) ) : ?>
							                    <li class="menu-item-has-children"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="acc-link"><i class="acc-icon"></i><?php esc_html_e('My account', 'woocommerce'); ?></a>
							                    <ul class="sub-menu">
							                         <?php 
							                            wp_nav_menu(array(
							                                'theme_location'  => 'myaccount-navigation',
							                                'fallback_cb'     => false,
							                                'container'       => false,
							                                'items_wrap'      => '<li><ul id="%1$s">%3$s</ul></li>',
							                            ));
							                        ?>                       
							                    </ul>
							                    </li>
						                    <?php endif; ?>
					                    <?php endif; ?>
					                <?php } else { ?> 
						                <?php if ( (isset($tdl_options['tdl_catalog_mode'])) && ($tdl_options['tdl_catalog_mode'] == 0) ) : ?>
						                	<li class="login-link"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="acc-link"><i class="login-icon"></i><?php esc_html_e('Login / Register', 'woodstock'); ?></a></li>
						                <?php endif; ?>
					                <?php } ?>

					 				<?php echo woodstock_wishlist_topbar(); ?>                
					                </ul>
					            </nav><!-- .myacc-navigation --> 




				<?php echo woodstock_mob_language_and_currency(); ?>

		        <?php if ( (isset($tdl_options['tdl_topbar_social_icons'])) && (trim($tdl_options['tdl_topbar_social_icons']) == "1" ) ) : ?>
		            <div class="sidebar-social-icons-wrapper">
		                <ul class="social-icons">
		                    <?php if ( (isset($tdl_options['twitter_link'])) && (trim($tdl_options['twitter_link']) != "" ) ) { ?><li class="twitter"><a target="_blank" title="Twitter" href="<?php echo esc_url($tdl_options['twitter_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['facebook_link'])) && (trim($tdl_options['facebook_link']) != "" ) ) { ?><li class="facebook"><a target="_blank" title="Facebook" href="<?php echo esc_url($tdl_options['facebook_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['googleplus_link'])) && (trim($tdl_options['googleplus_link']) != "" ) ) { ?><li class="googleplus"><a target="_blank" title="Google Plus" href="<?php esc_url($tdl_options['googleplus_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['pinterest_link'])) && (trim($tdl_options['pinterest_link']) != "" ) ) { ?><li class="pinterest"><a target="_blank" title="Pinterest" href="<?php echo esc_url($tdl_options['pinterest_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['vimeo_link'])) && (trim($tdl_options['vimeo_link']) != "" ) ) { ?><li class="vimeo"><a target="_blank" title="Vimeo" href="<?php echo esc_url($tdl_options['vimeo_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['youtube_link'])) && (trim($tdl_options['youtube_link']) != "" ) ) { ?><li class="youtube"><a target="_blank" title="YouTube" href="<?php echo esc_url($tdl_options['youtube_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['flickr_link'])) && (trim($tdl_options['flickr_link']) != "" ) ) { ?><li class="flickr"><a target="_blank" title="Flickr" href="<?php echo esc_url($tdl_options['flickr_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['skype_link'])) && (trim($tdl_options['skype_link']) != "" ) ) { ?><li class="skype"><a target="_blank" title="Skype" href="<?php echo esc_url($tdl_options['skype_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['behance_link'])) && (trim($tdl_options['behance_link']) != "" ) ) { ?><li class="behance"><a target="_blank" title="Behance" href="<?php echo esc_url($tdl_options['behance_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['dribbble_link'])) && (trim($tdl_options['dribbble_link']) != "" ) ) { ?><li class="dribbble"><a target="_blank" title="Dribbble" href="<?php echo esc_url($tdl_options['dribbble_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['tumblr_link'])) && (trim($tdl_options['tumblr_link']) != "" ) ) { ?><li class="tumblr"><a target="_blank" title="Tumblr" href="<?php echo esc_url($tdl_options['tumblr_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['linkedin_link'])) && (trim($tdl_options['linkedin_link']) != "" ) ) { ?><li class="linkedin"><a target="_blank" title="Linkedin" href="<?php echo esc_url($tdl_options['linkedin_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['github_link'])) && (trim($tdl_options['github_link']) != "" ) ) { ?><li class="github"><a target="_blank" title="Github" href="<?php echo esc_url($tdl_options['github_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['vine_link'])) && (trim($tdl_options['vine_link']) != "" ) ) { ?><li class="vine"><a target="_blank" title="Vine" href="<?php echo esc_url($tdl_options['vine_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['instagram_link'])) && (trim($tdl_options['instagram_link']) != "" ) ) { ?><li class="instagram"><a target="_blank" title="Instagram" href="<?php echo esc_url($tdl_options['instagram_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['dropbox_link'])) && (trim($tdl_options['dropbox_link']) != "" ) ) { ?><li class="dropbox"><a target="_blank" title="Dropbox" href="<?php echo esc_url($tdl_options['dropbox_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['rss_link'])) && (trim($tdl_options['rss_link']) != "" ) ) { ?><li class="rss"><a target="_blank" title="RSS" href="<?php echo esc_url($tdl_options['rss_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['stumbleupon_link'])) && (trim($tdl_options['stumbleupon_link']) != "" ) ) { ?><li class="stumbleupon"><a target="_blank" title="Stumbleupon" href="<?php echo esc_url($tdl_options['stumbleupon_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['paypal_link'])) && (trim($tdl_options['paypal_link']) != "" ) ) { ?><li class="paypal"><a target="_blank" title="Paypal" href="<?php echo esc_url($tdl_options['paypal_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['foursquare_link'])) && (trim($tdl_options['foursquare_link']) != "" ) ) { ?><li class="foursquare"><a target="_blank" title="Foursquare" href="<?php echo esc_url($tdl_options['foursquare_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['soundcloud_link'])) && (trim($tdl_options['soundcloud_link']) != "" ) ) { ?><li class="soundcloud"><a target="_blank" title="Soundcloud" href="<?php echo esc_url($tdl_options['soundcloud_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['spotify_link'])) && (trim($tdl_options['spotify_link']) != "" ) ) { ?><li class="spotify"><a target="_blank" title="Spotify" href="<?php echo esc_url($tdl_options['spotify_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['vk_link'])) && (trim($tdl_options['vk_link']) != "" ) ) { ?><li class="vk"><a target="_blank" title="VKontakte" href="<?php echo esc_url($tdl_options['vk_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['android_link'])) && (trim($tdl_options['android_link']) != "" ) ) { ?><li class="android"><a target="_blank" title="Android" href="<?php echo esc_url($tdl_options['android_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['apple_link'])) && (trim($tdl_options['apple_link']) != "" ) ) { ?><li class="apple"><a target="_blank" title="Apple" href="<?php echo esc_url($tdl_options['apple_link']); ?>"></a></li><?php } ?>
		                    <?php if ( (isset($tdl_options['windows_link'])) && (trim($tdl_options['windows_link']) != "" ) ) { ?><li class="windows"><a target="_blank" title="Windows" href="<?php echo esc_url($tdl_options['windows_link']); ?>"></a></li><?php } ?>    
		                    <?php if ( (isset($tdl_options['yelp_link'])) && (trim($tdl_options['yelp_link']) != "" ) ) { ?><li class="yelp"><a target="_blank" title="Yelp" href="<?php echo esc_url($tdl_options['yelp_link']); ?>"></a></li><?php } ?> 
		                    <?php if ( (isset($tdl_options['bandcamp_link'])) && (trim($tdl_options['bandcamp_link']) != "" ) ) { ?><li class="bandcamp"><a target="_blank" title="Bandcamp" href="<?php echo esc_url($tdl_options['bandcamp_link']); ?>"></a></li><?php } ?> 
		                    <?php if ( (isset($tdl_options['whatsapp_link'])) && (trim($tdl_options['whatsapp_link']) != "" ) ) { ?><li class="whatsapp"><a target="_blank" title="WhatsApp" href="<?php echo esc_url($tdl_options['whatsapp_link']); ?>"></a></li><?php } ?>		                    		                                                 
		                </ul>
		            </div>  
		        <?php endif; ?>         

				</div>

				<!-- Shop Sidebar Offcanvas -->
                    <div id="filters-offcanvas" class="offcanvas-left-content wpb_widgetised_column">
	 					<!-- Close Icon -->
						<a href="#" class="close-icon"></a>
						<div class="clearfix"></div>

						<?php if (class_exists('WooCommerce')) : ?>
							<?php if (is_product()) : ?>
								<?php if ( is_active_sidebar( 'widgets-product-page-listing' ) ) : ?>
									<?php dynamic_sidebar( 'widgets-product-page-listing' ); ?>
								<?php endif; ?>	
							<?php elseif (is_woocommerce()) : ?>
								<?php if ( is_active_sidebar( 'widgets-product-listing' ) ) : ?>
									<?php dynamic_sidebar( 'widgets-product-listing' ); ?>
								<?php endif; ?>	
							<?php else: ?>	
								<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
									<?php dynamic_sidebar( 'sidebar' ); ?>
								<?php endif; ?>										
							<?php endif; ?>
						<?php else: ?>
								<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
									<?php dynamic_sidebar( 'sidebar' ); ?>
								<?php endif; ?>								
						<?php endif; ?>

                    </div>	

			</div>
		</div>
	</nav>

	<nav class="off-menu slide-from-right <?php echo esc_attr($tdl_sidebarcart_color_scheme); ?>">
		<div class="nano">
			<div class="nano-content">
					<div id="minicart-offcanvas" class="offcanvas-right-content" data-empty-bag-txt="<?php esc_html_e( 'Your cart is currently empty.', 'woocommerce' ); ?>" data-singular-item-txt="<?php esc_html_e( 'item', 'woodstock' ); ?>" data-multiple-item-txt="<?php esc_html_e( 'items', 'woodstock' ); ?>">
					<div class="loading-overlay"><div class="spinner <?php echo esc_attr($tdl_header_ajax_loader); ?>"></div></div>
					<?php if ( class_exists( 'WC_Widget_Cart' ) ) { the_widget( 'WC_Widget_Cart' ); } ?></div>
			</div>
		</div>
	</nav>

</div><!-- /off-container -->

		<!-- ******************************************************************** -->
		<!-- * Custom Footer JavaScript Code ************************************ -->
		<!-- ******************************************************************** -->
		    
		<?php if ( (isset($tdl_options['tdl_custom_js_footer'])) && ($tdl_options['tdl_custom_js_footer'] != "") ) : ?>
			<?php echo do_shortcode($tdl_options['tdl_custom_js_footer']); ?>
		<?php endif; ?>

		<?php wp_footer(); ?>
	</body>
</html>