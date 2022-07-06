<?php $tdl_options = woodstock_global_var(); ?>
<div id="header-top-bar" class="<?php echo esc_attr($tdl_options['tdl_topbar_color_scheme']); ?> <?php echo esc_attr($tdl_options['tdl_topbar_drop_color_scheme']); ?>">
                            
    <div class="row">
        
        <div class="large-6 columns topbar-menu">

            <nav id="left-site-navigation-top-bar" class="main-navigation"> 
                <?php if ( has_nav_menu( 'top-bar-navigation' ) ) : ?>                   
                    <?php 
                        wp_nav_menu(array(
                            'theme_location'  => 'top-bar-navigation',
                            'fallback_cb'     => false,
                            'container'       => false,
                            'items_wrap'      => '<ul id="%1$s">%3$s</ul>',
                        ));
                    ?> 
                <?php endif; ?>   
            </nav><!-- #site-navigation -->  

        </div><!-- .large-6 .columns -->
        
        <div class="large-6 columns topbar-right" > 

        <?php if ( (isset($tdl_options['tdl_topbar_social_icons'])) && (trim($tdl_options['tdl_topbar_social_icons']) == "1" ) ) : ?>
            <div class="topbar-social-icons-wrapper">
                <ul class="social-icons">
                    <?php if ( (isset($tdl_options['twitter_link'])) && (trim($tdl_options['twitter_link']) != "" ) ) { ?><li class="twitter"><a target="_blank" title="Twitter" href="<?php echo esc_url($tdl_options['twitter_link']); ?>"></a></li><?php } ?>
                    <?php if ( (isset($tdl_options['facebook_link'])) && (trim($tdl_options['facebook_link']) != "" ) ) { ?><li class="facebook"><a target="_blank" title="Facebook" href="<?php echo esc_url($tdl_options['facebook_link']); ?>"></a></li><?php } ?>
                    <?php if ( (isset($tdl_options['googleplus_link'])) && (trim($tdl_options['googleplus_link']) != "" ) ) { ?><li class="googleplus"><a target="_blank" title="Google Plus" href="<?php echo esc_url($tdl_options['googleplus_link']); ?>"></a></li><?php } ?>
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
                     <?php if ( (isset($tdl_options['etsy_link'])) && (trim($tdl_options['etsy_link']) != "" ) ) { ?><li class="etsy"><a target="_blank" title="Etsy" href="<?php echo esc_url($tdl_options['etsy_link']); ?>"></a></li><?php } ?>                                                                     
                </ul>
            </div>  
        <?php endif; ?>            

            <?php echo woodstock_language_and_currency(); ?>

             <nav id="site-navigation-top-bar" class="main-navigation myacc-navigation"> 
                <ul id="my-account">
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
                                'items_wrap'      => '<li id="%1$s">%3$s',
                            ));
                        ?>                       
                    </ul>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php echo woodstock_wishlist_topbar(); ?>                 

                <?php } else { ?> 
                <?php if ( (isset($tdl_options['tdl_catalog_mode'])) && ($tdl_options['tdl_catalog_mode'] == 0) ) : ?>
                <li class="login-link"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="acc-link"><i class="login-icon"></i><?php esc_html_e('Login / Register', 'woodstock'); ?></a></li>
                <?php endif; ?>
                <?php echo woodstock_wishlist_topbar(); ?>
                <?php } ?>  
                </ul>
            </nav><!-- .myacc-navigation -->         
             
        </div><!-- .large-6 .columns -->
                    
    </div><!-- .row -->
    
</div><!-- #site-top-bar -->