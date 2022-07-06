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

<section class="no-results not-found">
	
	<div class="row">
	
	<?php if ( $blog_with_sidebar != "yes" ) :  ?>
		<div class="large-8 large-centered text-center columns without-sidebar">
	<?php endif; ?>	
	
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'woodstock' ); ?></h1>
		</header><!-- .page-header -->
	
		<div class="page-content">
			<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
	
				<p><?php printf( esc_html__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'woodstock' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
	
			<?php elseif ( is_search() ) : ?>
	
				<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'woodstock' ); ?></p>
				<?php get_search_form(); ?>
	
			<?php else : ?>
	
				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'woodstock' ); ?></p>
				<?php get_search_form(); ?>
	
			<?php endif; ?>
		</div><!-- .page-content -->
		
	</div><!--.large-8-->
	
	<?php if ( $blog_with_sidebar != "yes" ) : ?>
		</div>
	<?php endif; ?>	
		
</section><!-- .no-results -->
