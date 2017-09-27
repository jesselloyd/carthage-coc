<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Coc-sky-blue
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
            <!-- <a href="<?php /* echo esc_url( __( 'https://wordpress.org/', 'coc-sky-blue' ) ); */ ?>"><?php
				/* translators: %s: CMS name, i.e. WordPress. */
                /** printf( esc_html__( 'Proudly powered by %s', 'coc-sky-blue' ), 'WordPress' ); **/
			?></a>
			<span class="sep"> | </span>
			<?php
				/* translators: 1: Theme name, 2: Theme author. */
                /* printf( esc_html__( 'Theme: %1$s by %2$s.', 'coc-sky-blue' ), 'coc-sky-blue', '<a href="http://underscores.me/">Me</a>' ); */
			?> -->
            <?php do_action('coc_sky_blue_footer_content'); ?>
        </div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
