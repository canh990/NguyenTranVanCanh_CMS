<?php
/**
 * Template part for displaying posts
 * Module 2: Content (FIT-TDC Style Post Listing)
 * Reference: http://fit.tdc.edu.vn
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

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
