<?php
	$tdl_options = woodstock_global_var();
    $blog_with_sidebar = "";
    if ($tdl_options['tdl_blog_layout'] == '') $blog_with_sidebar = "yes";

    if ( is_singular( 'post' ) ) {
        if ( (isset($tdl_options['tdl_single_blog_layout'])) && ($tdl_options['tdl_single_blog_layout'] == "1" ) ) $blog_with_sidebar = "yes";
    } else {
        if ( (isset($tdl_options['tdl_blog_layout'])) && ($tdl_options['tdl_blog_layout'] == "1" ) ) $blog_with_sidebar = "yes";
    }
    if (isset($_GET["blog_with_sidebar"])) $blog_with_sidebar = $_GET["blog_with_sidebar"];   
?>

<div class="row">

<?php if ( $blog_with_sidebar == "yes" ) : ?>
    <div class="large-12 columns">
<?php else : ?>
    <div class="large-8 large-centered columns without-sidebar">
<?php endif; ?>

        <header class="entry-header">
            <?php if ( is_single() ) : ?>
				<?php if ( (isset($tdl_options['tdl_blog_sharing_options'])) && ($tdl_options['tdl_blog_sharing_options'] == "1" ) ) : ?>
					<?php woodstock_share(); ?>
				<?php endif; ?>            	
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php else : ?>
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            </h2>
            <?php endif; // is_single() ?>
            
            <div class="post_header_date"><?php woodstock_post_header_entry(); ?></div>
            
        </header><!-- .entry-header -->
        
    </div><!-- .columns -->
</div><!-- .row -->


<div class="gallery-slider-wrapper">
    <div class="gallery-slider">
        <div class="swiper-container post-id-<?php echo esc_attr($post->ID); ?> format-gallery-swiper">
            <div class="swiper-wrapper">
    
                <?php
    
                    $galleryImages = woodstock_grab_ids_from_gallery(); 
                    $imagesCount = count(woodstock_grab_ids_from_gallery());
    
                    if ($imagesCount > 0) {
                        for ($i = 0; $i < $imagesCount; $i++) {
                            if (!empty($galleryImages[$i])) {
    
                                //$imageMarkup = wp_get_attachment_image( $galleryImages[$i], array(1200,900) );
                                $imageSrc = wp_get_attachment_image_src( $galleryImages[$i], array(1200,900) );
    
                            ?>
    
                                <div class="swiper-slide"><img src="<?php echo esc_url($imageSrc[0]); ?>"></div>
    
                            <?php
                            }
                        }
                    }
                ?>
    
            </div>
    
            <div class="swiper-prev swiper-prev_<?php echo esc_attr($post->ID); ?> show-for-medium-up"></div>
            <div class="swiper-next swiper-next_<?php echo esc_attr($post->ID); ?> show-for-medium-up"></div>
            
            <div class="pagination"></div>
    
        </div>
    </div>
</div>

<script>
	jQuery(document).ready(function($) {
	
	"use strict";
		
		if ($(window).innerWidth() > 1024) {
			var slides = 2;
			var pag = '';
			var pagination_click = false;
		} else {
			var slides = 1;
			var pag = '.pagination';
			var pagination_click = true;
		}
		
		var gallerySwiper_<?php echo esc_attr($post->ID); ?> = new Swiper('.swiper-container.post-id-<?php echo esc_attr($post->ID); ?>', { 
			
			speed:300,
			centeredSlides: true,
			mode: 'horizontal',
            loop: true,
			resizeReInit: true,
			calculateHeight: true,
			
			<?php if ( $blog_with_sidebar == "yes" ) : ?>
				pagination: '.pagination',
                paginationClickable: true,
			<?php else : ?>
				pagination: pag,
				paginationClickable: pagination_click,
			<?php endif; ?>
			
			<?php if ( $blog_with_sidebar == "yes" ) : ?>
				slidesPerView: 1,
			<?php else : ?>
				slidesPerView: slides,
			<?php endif; ?>
			onSwiperCreated: after_swiper()
			
		});
		
		$('.swiper-prev_<?php echo esc_attr($post->ID); ?>').click(function(){
			gallerySwiper_<?php echo esc_attr($post->ID); ?>.swipePrev();
		});

		$('.swiper-next_<?php echo esc_attr($post->ID); ?>').click(function(){
			gallerySwiper_<?php echo esc_attr($post->ID); ?>.swipeNext();
		});

		function after_swiper() {
			setTimeout(function() {	
			   $('.gallery-slider-wrapper').css('visibility','visible');
			   $('.gallery-slider-wrapper').css('opacity','1');
			}, 300);
		}
        
        $(window).on('load', function(){
			
			gallerySwiper_<?php echo esc_attr($post->ID); ?>.reInit();
			
		});
        $(window).on('resize', function(){

			gallerySwiper_<?php echo esc_attr($post->ID); ?>.reInit();

        });
        
		
	});
</script>
  

<div class="row">
            
	<?php if ( $blog_with_sidebar == "yes" ) : ?>
        <div class="large-12 columns">
    <?php else : ?>
        <div class="large-8 large-centered columns without-sidebar">
    <?php endif; ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div class="entry-content">
                <?php
                if( ($post->post_excerpt) && (!is_single()) ) {
                    the_excerpt();
                    ?>
                    <a href="<?php the_permalink(); ?>" class="more-link"><?php esc_html_e('Continue reading &rarr;', 'woodstock'); ?></a>
                <?php
                } else {
                    the_content( esc_html__( 'Continue reading &rarr;', 'woodstock' ) );
                }
                ?>
				<?php if ( is_single() || ! get_post_gallery() ) : ?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'woodstock' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                <?php else : ?>
                    <?php //echo get_post_gallery(); ?>
                <?php endif; // is_single() ?>
            </div><!-- .entry-content -->
        
            <?php if ( is_single() ) : ?>
           
				<footer class="entry-meta">
					
                    <?php woodstock_entry_meta(); echo "."; ?>
                    <?php edit_post_link( esc_html__( 'Edit', 'woodstock' ), '<div class="edit-link">', '</div>' ); ?>
					
				</footer><!-- .entry-meta -->
            
            <?php endif; ?>

        </article><!-- #post -->

    </div><!-- .columns -->
</div><!-- .row -->
