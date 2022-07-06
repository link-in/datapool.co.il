<?php 
 if( $post->post_type == 'refunds'){
     echo '<meta name="robots" content="noindex" />';
    exit;
 }


$tdl_options = woodstock_global_var();
$page_for_posts = get_option('page_for_posts');
$blog = get_post($page_for_posts);      
$page_title_option = $tdl_options['tdl_blog_post_title'];

$blog_with_sidebar = "";
if ( (isset($tdl_options['tdl_single_blog_layout'])) && ($tdl_options['tdl_single_blog_layout'] == "1" ) ) $blog_with_sidebar = "yes";
if (isset($_GET["blog_with_sidebar"])) $blog_with_sidebar = $_GET["blog_with_sidebar"];    
?>

<?php get_header(); ?>

<?php 
    if ($page_title_option == 1) {
        $title_style = 'margin-bottom: 50px;';
        $blog_content_style = 'margin-bottom: 50px;'; 
    } else {
        $title_style = '';
        $blog_content_style = 'margin-top: 50px; margin-bottom: 30px;'; 
    }
 ?>

	<div id="primary" class="blog-content-area" style="<?php echo esc_attr($blog_content_style); ?>">

<?php if ( $page_title_option == 1 ): ?>
<?php 
    $no_parallax = "";
    if ((isset($tdl_options['tdl_blog_header_parallax'])) && ($tdl_options['tdl_blog_header_parallax'] == 0)) {
        $no_parallax = ' without_parallax';
    }

    $title_color = $tdl_options['tdl_blog_title_color_scheme'];

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
        
    $subtitle = get_field('tdl_subtitle', $page_for_posts);
    $title_align = $tdl_options['tdl_blog_title_align'];       
?>


    <?php 

    if ($header_content_type == 'image')                
        echo '<div class="site_header with_featured_img ' . $no_parallax . '" style="' . $title_style . 'background-image:url(' . $image_header . ')">';               
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

                    <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                        <h1 class="page-title on-shop"><?php echo esc_attr($blog->post_title); ?></h1>


                            <?php if ( esc_attr( $subtitle ) ) : ?>
                                <div class="term-description"><p><?php echo esc_attr( $subtitle ); ?></p></div>
                            <?php endif; ?>


                    <?php endif; ?>
                    
            </div><!-- .large-12 -->

        </div><!-- .row -->

    </div><!-- .site_header -->

<?php endif; ?>
        
        <?php if ( $blog_with_sidebar == "yes" ) : ?>
            <div class="row"><div class="large-8 columns with-sidebar">
        <?php endif; ?>
        
                <div id="content" class="site-content" role="main">
    
                    <?php while ( have_posts() ) : the_post(); ?>
            
                        <?php get_template_part( 'includes/content', get_post_format() ); ?>
                        
                        <hr />
            
                        <?php woodstock_content_nav( 'nav-below' ); ?>
            
                        <?php
                            // If comments are open or we have at least one comment, load up the comment template
                            if ( comments_open() || '0' != get_comments_number() )
                                comments_template();
                        ?>
            
                    <?php endwhile; // end of the loop. ?>
    
                </div><!-- #content -->
            
            <?php if ( $blog_with_sidebar == "yes" ) : ?>
        		</div><!-- .columns -->
            <?php endif; ?>
    
            <?php if ( $blog_with_sidebar == "yes" ) : ?>
                <div class="large-4 columns">                           
                        <div class="row">
                            <div class="large-11 large-push-1 columns">                 
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