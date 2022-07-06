<?php
    $tdl_options = woodstock_global_var();
    $link = get_field('tdl_link_url');
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
                <h2 class="entry-title">
                    <a href="<?php echo esc_url( $link ); ?>"><?php the_title(); ?><i class="fa fa-share-square-o post-link-icon"></i></a><br/>
                    <a href="<?php echo esc_url( $link ); ?>" class="post-link-url"><?php echo esc_url( $link ); ?></a>
                </h2>
                <div class="clearfix"></div>
                <div class="post_header_date"><?php woodstock_post_header_entry(); ?></div>
                
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
                <?php if ( (isset($tdl_options['tdl_blog_sharing_options'])) && ($tdl_options['tdl_blog_sharing_options'] == "1" ) ) : ?>
                    <?php woodstock_share(); ?>
                <?php endif; ?>
                <footer class="entry-meta">
                    
                    <?php woodstock_entry_meta(); echo "."; ?>
                    <?php edit_post_link( esc_html__( 'Edit', 'woodstock' ), '<div class="edit-link">', '</div>' ); ?>
                    
                </footer><!-- .entry-meta -->
                    
            <?php endif; ?>
            
        </article><!-- #post -->

    </div><!-- .columns -->
</div><!-- .row -->
