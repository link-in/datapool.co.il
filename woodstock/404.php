<?php get_header(); 
$blog_content_style = 'margin: 50px 0 80px 0;'; 
?>

	<div id="primary" class="content-area" style="<?php echo esc_attr($blog_content_style); ?>">

        <div class="row">	
            <div class="large-9 large-centered columns">    
                <div id="content" class="site-content" role="main">
                
                    <section class="error-404 not-found">
                        <header class="page-header">
                            <h1 class="page-title">404</h1>
                            <h2 class="page-sub-title"><?php esc_html_e( 'Sorry but we couldn&rsquo;t find the page you are looking for.', 'woodstock' ); ?></h2>
                        </header><!-- .page-header -->

                        <div class="row">
                            <div class="large-9 large-centered columns"> 
                                 <div class="page-content">
                                    <p><?php esc_html_e( 'Please check to make sure you&rsquo;ve typed the URL correctly. Maybe try a search?', 'woodstock' ); ?></p>
                
                                    <?php get_search_form(); ?>
                
                                </div><!-- .page-content -->                           
                            </div>
                        </div>
        

                    </section><!-- .error-404 -->
                    
                </div><!-- #content -->
            </div><!-- .large-12 .columns -->                
        </div><!-- .row -->
             
    </div><!-- #primary -->

<?php get_footer(); ?>