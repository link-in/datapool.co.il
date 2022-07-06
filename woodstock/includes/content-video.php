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

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                
                <div class="row">
                    <div class="large-12 columns">
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
                    </div>
                </div>
                
            </header><!-- .entry-header -->
        
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
                <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'woodstock' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
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
