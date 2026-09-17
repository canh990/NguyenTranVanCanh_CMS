<?php
/**
 * The main template file
 * Module 2: Content (FIT-TDC Style Post Listing)
 * Reference: http://fit.tdc.edu.vn
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header(); ?>

<?php if ( is_home() && ! is_front_page() && ! empty( single_post_title( '', false ) ) ) : ?>
	<header class="page-header alignwide">
		<h1 class="page-title"><?php single_post_title(); ?></h1>
	</header><!-- .page-header -->
<?php endif; ?>

<div class="fit-tdc-posts-container" style="max-width:680px; margin:25px auto; padding:0 15px;">
<?php
if ( have_posts() ) {

	// Load posts loop.
	while ( have_posts() ) {
		the_post();
		?>
		<!-- ═══ MODULE 2: FIT-TDC POST CARD ═══ -->
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'fit-tdc-post-card' ); ?>>
			<!-- Date Box (Left) -->
			<div class="fit-tdc-date-box">
				<span class="fit-tdc-day"><?php echo esc_html( get_the_date( 'd' ) ); ?></span>
				<span class="fit-tdc-month"><?php echo esc_html( 'THÁNG ' . get_the_date( 'm' ) ); ?></span>
			</div>

			<!-- Content Box (Right) -->
			<div class="fit-tdc-content-box">
				<h2 class="fit-tdc-post-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<div class="fit-tdc-post-excerpt">
					<?php echo esc_html( function_exists( 'fit_tdc_get_post_excerpt' ) ? fit_tdc_get_post_excerpt( get_the_ID() ) : get_the_excerpt() ); ?>
				</div>
			</div>
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php
	}

	// Previous/next page navigation.
	twenty_twenty_one_the_posts_navigation();

} else {

	// If no content, include the "No posts found" template.
	get_template_part( 'template-parts/content/content-none' );

}
?>
</div><!-- /.fit-tdc-posts-container -->

<?php
get_footer();
