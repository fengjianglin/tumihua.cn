<?php get_header(); ?>

<div class="st-content">
    <div class="container">
        <div class="row">

                <div class="
                <?php if (get_theme_mod( 'liana_home_layout' ) == 'full') { ?>
                    col-md-12
                <?php } else { ?>
                    col-md-8
                <?php }
                 ?>
                ">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main" role="main">

                        <?php if (have_posts()) :
                            while (have_posts()) :
                                the_post();
                                ?>

                                <?php get_template_part( 'template-parts/content', get_post_format() ); ?>

                                <?php if (!get_theme_mod('liana_post_author')) : ?>
                                    <div class="padding-content white-color author-name">
                                        <?php get_template_part( 'user-profile' ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!get_theme_mod('liana_post_nav')): ?>
                                    <div class="white-color liana-nav post-nav-area">
                                        <?php liana_post_navigation(); ?>
                                        
                                    </div>
                                <?php endif; ?>


                                    <?php
                                        // If comments are open or we have at least one comment, load up the comment template
                                        if ( comments_open() || get_comments_number() ) : ?>
                                            <div class="padding-content white-color margin-top-40">
                                                <?php comments_template(); ?>
                                            </div>
                                        <?php endif;
                                    ?>


                            <?php endwhile; // end of the loop. ?>

                        <?php else : ?>

                            <?php get_template_part('template-parts/content', 'none'); ?>

                        <?php endif; ?>
                    </main> <!-- /.site-main -->
                </div>  <!-- /.content-area -->
            </div> <!-- /col -->

            <!-- Blogsidebar -->
            <?php get_sidebar(); ?>

        </div> <!-- /.row -->
    </div> <!-- /.container -->
</div>
<?php get_footer(); ?>