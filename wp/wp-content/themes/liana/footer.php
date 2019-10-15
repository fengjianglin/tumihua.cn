
<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="footer-top"><?php dynamic_sidebar('footer-widget'); ?></div>
		</div>
	</div>

    <div class="container">
     <div class="row">
	  <div class="col-md-12">
	  	<div class="footer-bottom">
		 <div class="col-md-6 copy-right-text text-left">
		<?php if(get_theme_mod('liana_footer_copyright')): ?>
			<p><?php
			$copyright = get_theme_mod('liana_footer_copyright');
			$allowed_tags = array(
				'strong' => array(),
				'a' => array(
					'href' => array(),
					'title' => array()
				)
			);
			echo wp_kses( $copyright, $allowed_tags ); ?></p>
		<?php endif; ?>

         </div>
         <div class="col-md-6 text-right liana-social">
		<?php if (!get_theme_mod('liana_footer_social_check' )) : ?>
                        <div class="footer-social-icons">
                            <?php if (get_theme_mod('liana_facebook')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_facebook')); ?>"><i class="fa fa-facebook"></i></a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('liana_twitter')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_twitter')); ?>"><i class="fa fa-twitter"></i></a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('liana_google')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_google')); ?>"><i class="fa fa-google-plus"></i></a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('liana_youtube')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_youtube')); ?>"><i class="fa fa-youtube"></i></a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('liana_skype')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_skype')); ?>"><i class="fa fa-skype"></i></a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('liana_pinterest')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_pinterest')); ?>"><i class="fa fa-pinterest"></i></a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('liana_flickr')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_flickr')); ?>"><i class="fa fa-flickr"></i></a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('liana_linkedin')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_linkedin')); ?>"><i class="fa fa-linkedin"></i></a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('liana_xing')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_xing')); ?>"><i class="fa fa-xing"></i></a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('liana_vimeo')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_vimeo')); ?>"><i class="fa fa-vimeo-square"></i></a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('liana_instagram')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_instagram')); ?>"><i class="fa fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('liana_dribbble')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_dribbble')); ?>"><i class="fa fa-dribbble"></i></a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('liana_tumblr')) : ?>
                                <a class="btn btn-social" href="<?php echo esc_url(get_theme_mod('liana_tumblr')); ?>"><i class="fa fa-tumblr"></i></a>
                            <?php endif; ?>
                           </div> 
                        </div>
                    <?php endif; ?>
                    </div>
				</div>
				</div>
          </div><!-- /footer-bottom contanier -->

</footer><!-- /#Footer -->

<?php if (!get_theme_mod('liana_back_to_top')): ?>
    <div class="scroll-up">
        <a href="#"><i class="fa fa-angle-up"></i></a>
    </div>
<?php endif; ?>
<!-- Scroll Up -->

<?php wp_footer(); ?>

</body>
</html>
