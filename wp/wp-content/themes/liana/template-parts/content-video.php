<?php
/**
 * Template part for displaying Video posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package liana
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="thumbnails">
            <div class="entry-video">
            <?php $st_video = get_post_meta( $post->ID, '_format_video_embed', true ); ?>
            <?php if(wp_oembed_get( $st_video )) : ?>
                <?php echo wp_oembed_get($st_video); ?>
            <?php else : ?>
                <?php echo esc_attr($st_video); ?>
            <?php endif; ?>
            </div>
        </div>

    <div class="padding-content liana-blog entry-video video-frame">
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

