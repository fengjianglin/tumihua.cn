<?php
/**
 * The template for displaying full image posts in Magazine Post widgets
 *
 * @package Maxwell
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php maxwell_post_image( 'maxwell-thumbnail-single' ); ?>

	<header class="entry-header">

		<?php maxwell_entry_meta(); ?>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content clearfix">

		<?php the_excerpt(); ?>
		<?php maxwell_more_link(); ?>

	</div><!-- .entry-content -->

</article>
