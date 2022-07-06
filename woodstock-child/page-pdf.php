<?php
/* Template Name: pdf page */

get_header();

?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<div id="content" class="site-content" role="main" style="padding: 50px 0;">
				<div class="row">
					<div class="large-12 columns">
							<div class="entry-content">
							<header class="entry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							</header>
							<?php
							//the_content();
							$pdf=get_field('pdf', get_the_id());
							if(!empty($pdf)){
								?>
								<div class="container-iframe">
									<a href="<?=$pdf?>">לצפיה בקובץ והורדה</a>
									<iframe style="border: 0px #ffffff none;" class="responsive-iframe" src="<?=$pdf?>" name="myiFrame" width="1300px" height="900px" frameborder="1" marginwidth="0px" marginheight="0px" scrolling="no" allowfullscreen="allowfullscreen"></iframe>
								</div>
								<?php
							}
							?>
							</div>
					</div>
				</div>
			</div>
		<?php

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
