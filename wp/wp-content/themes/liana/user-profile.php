<div class="user-profile media">
    <div class="pull-left author-avater">
        <?php echo get_avatar( get_the_author_meta( 'ID' ), 110 ); ?>
    </div>
    <div class="media-body">
        <div class="profile-heading">
            <h3><?php the_author_posts_link(); ?></h3>
        </div>
        <div class="website-link"><?php echo esc_url(the_author_meta('user_url')); ?></div>
        <div class="author-description">
            <?php echo esc_attr(the_author_meta('description')); ?>
        </div>

            
    </div>
</div><!-- .user-profile -->