<?php
/*
Template Name: Blank
*/
?>

<?php get_header(); ?>
    
    <div class="blank-page">
		
        <div id="primary" class="content-area">
           
            <div id="content" class="site-content" role="main">

                <div class="row">
                    <div class="large-12 columns">            
                    
                        <?php while ( have_posts() ) : the_post(); ?>
            
                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div><!-- .entry-content -->

                            <?php
                                // If comments are open or we have at least one comment, load up the comment template.
                                if ( comments_open() || get_comments_number() ) {
                                    comments_template();
                                }
                            ?>                            
            
                        <?php endwhile; // end of the loop. ?>

                    </div>
                </div>
    
            </div><!-- #content -->           
            
        </div><!-- #primary -->
		
	</div><!-- .boxed-page -->
    
<?php get_footer(); ?>