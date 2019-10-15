<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Buildx
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header id="post-header" class="row">

		<div class="post-title">
			<?php the_title( '<h1>', '</h1>' ); ?>
			<div class="post-meta"><?php echo esc_html( get_the_date() ); ?></div>
		</div>
	</header>

	<div id="post-content" class="container">
		<div class="row">
			<div class="col-12">

				<?php

                the_content();
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'buildx' ),
					'after'  => '</div>',
				) );

				?>

                <div class="clearfix"></div><!--to clear floats at the bottom of content-->

                <div class="post-meta">
                    <?php echo get_the_tag_list('<span class="fas fa-tags"></span>&nbsp;', ', ', '', $post->ID); ?>
                </div>

			</div>
		</div>
	</div>

</article>
