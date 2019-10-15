<?php

    //----------------------------------------------------------------------
    //  Posts navigation link. <- Older post  |   Newer Post ->
    //----------------------------------------------------------------------

    if (!function_exists('liana_posts_navigation')) {

        function liana_posts_navigation()
        {
            ?>
            <div class="row next-previous-posts clearfix">

                <?php if (get_previous_posts_link()) { ?>
                    <div class="col-xs-6 pull-left">
                        <div class="next-posts">
                            <div class="post-headingn text-left">
                                <h2><?php previous_posts_link(__('<i class="fa fa-angle-left"></i> Newer posts', 'liana')); ?></h2></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (get_next_posts_link()) { ?>
                    <div class="col-xs-6 pull-right">
                        <div class="previous-posts">
                            <div class="post-heading text-right">
                                <h2><?php next_posts_link(__('Older posts <i class="fa fa-angle-right"></i>', 'liana')); ?></h2></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        <?php
        }
    }




    //----------------------------------------------------------------------
    //  Posted on
    //----------------------------------------------------------------------

    if (!function_exists('liana_post_tag_list')) {
        function liana_post_tag_list()
        {
        $tags_list = get_the_tag_list();
        
        if ( $tags_list ) {
            printf( '<span class="tags-links">' . __( 'Tagged %1$s', 'liana' ) . '</span>', $tags_list );
        }

        }}


    if (!function_exists('liana_posted_on')) {
        function liana_posted_on()
        {
            ?>
            <ul class="list-inline">
            <?php if (!get_theme_mod('liana_post_cat')): ?>
                <?php if (get_the_category_list()): ?>
                    <li>
                        <span class="posted-in">
                            <?php _e('In', 'liana');echo get_the_category_list(_x(', ', 'Used between list items, there is a space after the comma.', 'liana'));
                            ?>
                        </span>
                    </li>
                <?php endif; ?>

            <?php if (!get_theme_mod('liana_post_author_name')): ?>
                <li>
                    <span class="author vcard">
                        <?php _e('By ', 'liana');
                            printf('<a class="url fn n" href="%1$s">%2$s</a>',
                                esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                                esc_html(get_the_author())
                            ) ?>
                    </span>
                </li>

                <li></li>
            <?php endif; ?>

			<?php if (!get_theme_mod('liana_post_date')): ?>
                <li>
                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                </li>

                <li></li>
            <?php endif; ?>

           
            <?php endif; ?>
            


            </ul>
           

        <?php
        }
    }



    //----------------------------------------------------------------------
    //  Single Post navigation link. <- Previous post  |   Next Post ->
    //----------------------------------------------------------------------

   if (!function_exists('liana_post_navigation')) {

        function liana_post_navigation()
        {
            // Don't print empty markup if there's nowhere to navigate.
            $previous = (is_attachment()) ? get_post(get_post()->post_parent) : get_adjacent_post(FALSE, '', TRUE);
            $next     = get_adjacent_post(FALSE, '', FALSE);

            if (!$next && !$previous) {
                return;
            }
            ?>
            
            <nav class="next-previous-post clearfix media" role="navigation">
                <div class="row">
                    <!-- Previous Post -->
                    <div class="previous-post col-sm-6 pull-left">
                        <?php previous_post_link('<div class="nav-previous"><i class="fa fa-angle-double-left"></i> %link</div>', '%title'); ?>
                    </div>

                    <!-- Next Post -->
                    <div class="next-post col-sm-6 pull-right text-right">
                        <?php next_post_link('<div class="nav-next">%link <i class="fa fa-angle-double-right"></i></div>','%title'); ?>
                    </div>
                </div>
            </nav><!-- .navigation -->
            
        <?php
        }
    }


    //----------------------------------------------------------------------
    // Archive title
    //----------------------------------------------------------------------

    if ( ! function_exists( 'liana_archive_title' ) ) :

    function liana_archive_title( $before = '', $after = '' ) {
    	if ( is_category() ) {
    		$title = sprintf( __( 'Browse Category <h1>%s</h1>', 'liana' ), single_cat_title( '', false ) );
    	} elseif ( is_tag() ) {
    		$title = sprintf( __( 'Browse Tag <h1>%s</h1>', 'liana' ), single_tag_title( '', false ) );
    	} elseif ( is_author() ) {
    		$title = sprintf( __( 'Browse Author <h1>%s</h1>', 'liana' ), '<span class="vcard">' . get_the_author() . '</span>' );
    	} elseif ( is_year() ) {
    		$title = sprintf( __( 'Browse Year <h1>%s</h1>', 'liana' ), get_the_date( _x( 'Y', 'yearly archives date format', 'liana' ) ) );
    	} elseif ( is_month() ) {
    		$title = sprintf( __( 'Browse Month <h1>%s</h1>', 'liana' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'liana' ) ) );
    	} elseif ( is_day() ) {
    		$title = sprintf( __( 'Browse Day <h1>%s</h1>', 'liana' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'liana' ) ) );
    	} elseif ( is_tax( 'post_format' ) ) {
    		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
    			$title = _x( 'Asides', 'post format archive title', 'liana' );
    		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
    			$title = _x( 'Galleries', 'post format archive title', 'liana' );
    		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
    			$title = _x( 'Images', 'post format archive title', 'liana' );
    		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
    			$title = _x( 'Videos', 'post format archive title', 'liana' );
    		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
    			$title = _x( 'Quotes', 'post format archive title', 'liana' );
    		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
    			$title = _x( 'Links', 'post format archive title', 'liana' );
    		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
    			$title = _x( 'Statuses', 'post format archive title', 'liana' );
    		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
    			$title = _x( 'Audio', 'post format archive title', 'liana' );
    		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
    			$title = _x( 'Chats', 'post format archive title', 'liana' );
    		}
    	} elseif ( is_post_type_archive() ) {
    		$title = sprintf( __( 'Browse Archives <h1>%s</h1>', 'liana' ), post_type_archive_title( '', false ) );
    	} elseif ( is_tax() ) {
    		$tax = get_taxonomy( get_queried_object()->taxonomy );
    		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
    		$title = sprintf( __( '%1$s: %2$s', 'liana' ), $tax->labels->singular_name, single_term_title( '', false
            ) );
    	} else {
    		$title = __( 'Archives', 'liana' );
    	}

    	/**
    	 * Filter the archive title.
    	 *
    	 * @param string $title Archive title to be displayed.
    	 */
    	$title = apply_filters( 'get_the_archive_title', $title );

        $allowed_html_array = array(
            'div'=>array(
                'class'=>array(),
                'id'=>array(),
                'style'=>array(),
            ),
            
            'a'=>array(
                 'href'=>array(),
                 'class'=>array(),
                 'id'=>array(),
            ),
             'img'=>array(
                 'src'=>array(),
                 'class'=>array(),
                 'id'=>array(),
              )


        );

    	if ( ! empty( $title ) ) {
            $var = $before . $title . $after;
    		echo wp_kses( $var, $allowed_html_array);
    	}
    }
    endif;





/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function liana_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'liana_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'liana_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so liana_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so liana_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in liana_categorized_blog.
 */
function liana_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'liana_categories' );
}
add_action( 'edit_category', 'liana_category_transient_flusher' );
add_action( 'save_post',     'liana_category_transient_flusher' );
