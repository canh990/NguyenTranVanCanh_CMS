<?php
/**
 * The template for displaying archive pages
 * Module 2: Content (FIT-TDC Style Post Listing)
 * Reference: http://fit.tdc.edu.vn
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$description = get_the_archive_description();
?>

<?php if ( have_posts() ) : ?>

	<header class="page-header alignwide">
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php if ( $description ) : ?>
			<div class="archive-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
		<?php endif; ?>
	</header><!-- .page-header -->

	<div class="fit-tdc-posts-container" style="max-width:680px; margin:25px auto; padding:0 15px;">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
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
	<?php endwhile; ?>

	<?php twenty_twenty_one_the_posts_navigation(); ?>
	</div><!-- /.fit-tdc-posts-container -->

<?php else : ?>
	<?php get_template_part( 'template-parts/content/content-none' ); ?>
<?php endif; ?>

<?php
get_footer();
