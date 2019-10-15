<?php get_header(); ?>

	<div class="st-content">
		<div class="container">
			<div class="row">

				<div class="
				<?php if (get_theme_mod( 'liana_home_layout' ) == 'full') { ?>
					call-md-12
				<?php } else { ?>
					col-md-8
				<?php }
				 ?>
				">
					
					<div id="primary" class="content-area">
						<main id="main" class="site-main" role="main">

						<?php if ( have_posts() ) : ?>

							<?php /* Start the Loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>

								<?php
									get_template_part( 'template-parts/content', get_post_format() );
								?>

							<?php endwhile; ?>


							

							
							<div class="liana-pagination">

						   <?php		

							 // Posts Pagination
							if (get_theme_mod('liana_blog_pagination') == 'navigation') {
								liana_posts_navigation();
							} else {

								the_posts_pagination(array(
									'mid_size' 	=> 2,
                                    'prev_text' => '<i class="fa fa-angle-left"></i>',
                                    'next_text' => '<i class="fa fa-angle-right"></i>',
                                    
								));
							} ?>

							</div>

						<?php else : ?>

							<?php get_template_part( 'template-parts/content', 'none' ); ?>

						<?php endif; ?>

						</main><!-- #main -->
					</div><!-- #primary -->
				</div> <!-- /col -->
				<!-- Blogsidebar -->			
				<?php get_sidebar(); ?>
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</div> <!-- /.st-content -->

<?php get_footer(); ?>
