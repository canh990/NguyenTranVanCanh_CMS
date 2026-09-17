<?php
/**
 * category.php - Module 9: Category Listing Page
 */
get_header();
$category = get_queried_object();
?>

<div class="page-banner">
    <div class="container">
        <h1>
            <i class="fas fa-folder-open mr-2"></i>
            <?php echo esc_html(single_cat_title('', false)); ?>
        </h1>
        <?php if ($category->description) : ?>
        <p style="color:rgba(255,255,255,.75); margin-top:6px; margin-bottom:0; font-size:.95rem;">
            <?php echo esc_html($category->description); ?>
        </p>
        <?php endif; ?>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'mytheme'); ?></a>
                </li>
                <li class="breadcrumb-item active"><?php single_cat_title(); ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-title">
                    <i class="fas fa-folder-open"></i>
                    <?php
                    printf(
                        __('Posts in: %s (%d)', 'mytheme'),
                        esc_html(single_cat_title('', false)),
                        (int)$category->count
                    );
                    ?>
                </div>

                <?php if (have_posts()) : while (have_posts()) : the_post();
                    $post_id   = get_the_ID();
                    $day_n     = get_the_date('j');
                    $month_n   = get_the_date('M');
                    $thumb_url = get_the_post_thumbnail_url($post_id, 'post-thumbnail-medium');
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
                        <h2 class="post-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="post-card-excerpt"><?php echo mytheme_excerpt(22); ?></div>
                        <div class="post-card-meta">
                            <span><i class="fas fa-user-circle"></i> <?php the_author(); ?></span>
                            <span><i class="fas fa-calendar-alt"></i> <?php the_date('d/m/Y'); ?></span>
                            <span><i class="fas fa-comments"></i> <?php comments_number('0', '1', '%'); ?></span>
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
                    <i class="fas fa-folder-open d-block"></i>
                    <h3><?php _e('No posts in this category.', 'mytheme'); ?></h3>
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
