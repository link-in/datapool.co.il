<?php 

$page_for_posts = get_option('page_for_posts');
$blog = get_post($page_for_posts);      

$blog_with_sidebar = "";
if ( (isset($tdl_options['tdl_blog_layout'])) && ($tdl_options['tdl_blog_layout'] == "0" ) ) $blog_with_sidebar = "no";
if ( (isset($tdl_options['tdl_blog_layout'])) && ($tdl_options['tdl_blog_layout'] == "1" ) ) $blog_with_sidebar = "yes";
if ( (isset($tdl_options['tdl_blog_layout'])) && ($tdl_options['tdl_blog_layout'] == "2" ) ) $blog_with_sidebar = "blog-masonry";
if (isset($_GET["blog_with_sidebar"])) $blog_with_sidebar = $_GET["blog_with_sidebar"];     

$no_parallax = "";
if ((isset($tdl_options['tdl_blog_header_parallax'])) && ($tdl_options['tdl_blog_header_parallax'] == 0)) {
    $no_parallax = ' without_parallax';
}
?>

<?php get_header(); ?>

<?php 
	$title_style = 'margin-bottom: 50px;';
	$blog_content_style = 'margin-bottom: 30px;'; 
?> 


<div id="primary" class="blog-content-area archive" style="<?php echo esc_attr($blog_content_style); ?>">

<?php 

$title_color = (!empty($tdl_options['tdl_blog_title_color_scheme'])) ? $tdl_options['tdl_blog_title_color_scheme'] : 'mta-light';


    $default_image_header = "";

    if ( (isset($tdl_options['tdl_blog_default_header_bg']['url'])) && (trim($tdl_options['tdl_blog_default_header_bg']['url']) != "" ) ) {
        $default_image_header = $tdl_options['tdl_blog_default_header_bg']['url'];
    }

    if ($default_image_header) {
		$header_content_type = 'image';
		$image_header = $default_image_header;
	} else {
		$header_content_type = '';
	}
 
    $title_align = $tdl_options['tdl_blog_title_align'];
?>


    <?php 

	if ($header_content_type == 'image')      
		echo '<div class="site_header with_featured_img' . $no_parallax . '" style="' . $title_style . 'background-image:url(' . $image_header . ')">';          
	else 
		echo '<div class="site_header  without_featured_img ' . $title_color . '" style="' . $title_style . '">';
    ?>

        <div class="site_header_overlay"></div>

        <div class="row">
            <div class="large-12 <?php echo esc_attr( $title_align );?> large-centered columns">
                    <?php 
                    if ((isset($tdl_options['tdl_shop_breadcrumb'])) && ($tdl_options['tdl_shop_breadcrumb'] == "1"))
                        {
                        // BREADCRUMBS
                        echo woodstock_breadcrumbs();
                        }
                    ?>


                        <h1 class="page-title on-shop">
							<?php
								if ( is_category() ) :
									single_cat_title();
		
								elseif ( is_tag() ) :
									single_tag_title();
		
								elseif ( is_author() ) :
									/* Queue the first post, that way we know
									 * what author we're dealing with (if that is the case).
									*/
									the_post();
									printf( esc_html__( 'Author: %s', 'woodstock' ), '<span class="vcard">' . get_the_author() . '</span>' );
									/* Since we called the_post() above, we need to
									 * rewind the loop back to the beginning that way
									 * we can run the loop properly, in full.
									 */
									rewind_posts();
		
								elseif ( is_day() ) :
									printf( esc_html__( 'Day: %s', 'woodstock' ), '<span>' . get_the_date() . '</span>' );
		
								elseif ( is_month() ) :
									printf( esc_html__( 'Month: %s', 'woodstock' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
		
								elseif ( is_year() ) :
									printf( esc_html__( 'Year: %s', 'woodstock' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
		
								elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
									esc_html_e( 'Asides', 'woodstock' );
		
								elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
									esc_html_e( 'Images', 'woodstock');
		
								elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
									esc_html_e( 'Videos', 'woodstock' );
		
								elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
									esc_html_e( 'Quotes', 'woodstock' );
		
								elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
									esc_html_e( 'Links', 'woodstock' );
		
								else :
									esc_html_e( 'Archives', 'woodstock' );
		
								endif;
							?>
                        </h1>

						<?php
							// Show an optional term description.
							$term_description = term_description();
							if ( ! empty( $term_description ) ) :
								printf( '<div class="term-description"><p>%s</p></div>', $term_description );
							endif;
						?>                        

                    
            </div><!-- .large-12 -->

        </div><!-- .row -->

    </div><!-- .site_header -->
		
		
        <?php if ( $blog_with_sidebar == "yes" ) : ?>
            <div class="row"><div class="large-8 columns with-sidebar">
        <?php endif; ?>
        
                <div id="content" class="site-content" role="main">
                
                   	<?php if ( have_posts() ) : ?>
									
						<!--masonry style-->
						<?php if ( $blog_with_sidebar == "blog-masonry" ) : ?>
							
							<div class="blog-isotop-master-wrapper">
							
								<div class="row">
								<div class="large-12 columns">
								
									<div class="blog-isotop-container">
							
										<div id="filters" class="button-group">
											<button class="filter-item is-checked" data-filter="*">show all</button>
										</div>
							
										<div class="blog-isotope">
											<div class="grid-sizer"></div>
								
											<?php /* Start the Loop */ ?>
											<?php while ( have_posts() ) : the_post(); ?>
									
												<div class="blog-post hidden <?php echo get_post_format(); ?>">
                                                    <div class="blog-post-inner">

                                                        <?php get_template_part( 'includes/content', get_post_format() ); ?>
                                    
                                                        <hr class="content_hr" />
                                                               
                                                    </div><!--blog-post-inner-->
												</div><!-- .blog-post-->
								
											<?php endwhile; ?>
								
										</div><!-- .blog-isotope -->
										
									</div><!-- .blog-isotop-container-->
									
								</div><!--.large-12-->
								</div><!--.row-->
								
								<?php woodstock_content_nav( 'nav-below' ); ?>
							
							</div><!--blog-isotop-master-wrapper-->
							
						<!--default style-->	
						<?php else : ?>
							
							<?php while ( have_posts() ) : the_post(); ?>
								
									<?php get_template_part( 'includes/content', get_post_format() ); ?>
									
									<hr class="content_hr" />
									
							<?php endwhile; ?>
				
							<?php woodstock_content_nav( 'nav-below' ); ?>
							
						<?php endif; ?>
					
					<!--no posts found-->
                    <?php else : ?>
            
                        <?php get_template_part( 'content', 'none' ); ?>
            
                    <?php endif; ?>
                    
                </div><!-- #content --> 
                         
            <?php if ( $blog_with_sidebar == "yes" ) : ?>
        		</div><!-- .columns -->
            <?php endif; ?>
            
            <?php if ( $blog_with_sidebar == "yes" ) : ?>
                <div class="large-4 columns">                           
                        <div class="row">
                            <div class="large-10 large-push-2 columns">                 
                                <?php get_sidebar(); ?>
                            </div>
                        </div>                
                </div><!-- .columns -->
            <?php endif; ?>
            
        <?php if ( $blog_with_sidebar == "yes" ) : ?>
        	</div><!-- .row -->
        <?php endif; ?>

    <?php if ( $blog_with_sidebar == "yes" ) : ?>
        <?php if (is_active_sidebar( 'sidebar')) : ?>
            	<div id="button_offcanvas_sidebar_left"><i class="sidebar-icon"></i></div>
        <?php endif; ?>
    <?php endif; ?>
                            
    </div><!-- #primary -->

<?php get_footer(); ?>
