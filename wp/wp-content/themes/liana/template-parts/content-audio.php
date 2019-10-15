<?php
/**
 * Template part for displaying Audio posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package liana
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if(has_post_thumbnail()) : ?>
    <div class="thumbnails">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('liana-post-thumbnails', array('class' => 'post-thumbnail img-responsive')); ?></a>
    </div>
    <?php endif; ?>

    <div class="padding-content liana-blog">
        <header class="entry-header">
            <?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
        </header> <!--/.entry-header -->

            <div class="entry-meta">
                <?php liana_posted_on(); ?>
            </div><!-- .entry-meta -->
    

        <?php
            if(is_single()) {
            the_content( sprintf(
                /* translators: %s: Name of current post. */
                wp_kses( esc_html__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'liana' ), array( 'span' => array( 'class' => array() ) ) ),
                the_title( '<span class="screen-reader-text">"', '"</span>', false )
            ) );
            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'liana' ),
                'after'  => '</div>',
            ) );
            } else {
                
                the_excerpt();
                echo '<div style="clear:both"></div><a href="' . esc_url( get_permalink() ) . '" class="liana-blog-btn">'.esc_html__('Read more', 'liana').'</a>';
            }
        ?>

       
    </div>



    <?php if(is_single()) : 

             if (!get_theme_mod('liana_post_tags')): ?>
            <br>
            <div class="entry-tags text-left"><?php liana_post_tag_list(); ?></div>
            <?php endif;

    endif; 
    ?> 

</article><!-- #post-## -->

