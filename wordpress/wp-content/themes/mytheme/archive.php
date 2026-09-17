<?php
/**
 * archive.php - Module 11: Archive by date
 * Reference: vnexpress.net style - shows posts by month/year
 */
get_header();

$year  = get_query_var('year');
$month = get_query_var('monthnum');
$day   = get_query_var('day');

if ($day) {
    $archive_title = sprintf(__('Daily Archive: %s', 'mytheme'), get_the_date('d F Y'));
} elseif ($month) {
    $archive_title = sprintf(__('Monthly Archive: %s', 'mytheme'), date_i18n('F Y', mktime(0,0,0,$month,1,$year)));
} elseif ($year) {
    $archive_title = sprintf(__('Yearly Archive: %s', 'mytheme'), $year);
} else {
    $archive_title = get_the_archive_title();
}
?>

<div class="page-banner">
    <div class="container">
        <h1><i class="fas fa-calendar-alt mr-2"></i><?php echo esc_html($archive_title); ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'mytheme'); ?></a>
                </li>
                <li class="breadcrumb-item active"><?php echo esc_html($archive_title); ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">

                <?php if (have_posts()) : while (have_posts()) : the_post();
                    $post_id   = get_the_ID();
                    $day_n     = get_the_date('j');
                    $month_n   = get_the_date('M');
                    $thumb_url = get_the_post_thumbnail_url($post_id, 'post-thumbnail-medium');
                    $cats      = get_the_category();
                    $cat_name  = $cats ? $cats[0]->name : '';
                    $cat_link  = $cats ? get_category_link($cats[0]->term_id) : '#';
                ?>

                <article class="post-card" id="post-<?php echo $post_id; ?>">
                    <div class="post-card-date">
                        <span class="day"><?php echo esc_html($day_n); ?></span>
                        <span class="month"><?php echo esc_html($month_n); ?></span>
                    </div>
                    <?php if ($thumb_url) : ?>
                        <img src="<?php echo esc_url($thumb_url); ?>"
                             alt="<?php the_title_attribute(); ?>"
                             class="post-card-thumb">
                    <?php else : ?>
                        <div class="post-card-thumb-placeholder">
                            <i class="fas fa-image"></i>
                        </div>
                    <?php endif; ?>
                    <div class="post-card-body">
                        <?php if ($cat_name) : ?>
                        <div class="post-card-category">
                            <a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html($cat_name); ?></a>
                        </div>
                        <?php endif; ?>
                        <h2 class="post-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="post-card-excerpt"><?php echo mytheme_excerpt(22); ?></div>
                        <div class="post-card-meta">
                            <span><i class="fas fa-user-circle"></i> <?php the_author(); ?></span>
                            <span><i class="fas fa-calendar-alt"></i> <?php the_date('d/m/Y'); ?></span>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn-read-more">
                            <?php _e('Read more', 'mytheme'); ?> <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </article>

                <?php endwhile;
                mytheme_pagination();

                else : ?>
                <div class="no-results">
                    <i class="fas fa-calendar-times d-block"></i>
                    <h3><?php _e('No posts found for this period.', 'mytheme'); ?></h3>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
