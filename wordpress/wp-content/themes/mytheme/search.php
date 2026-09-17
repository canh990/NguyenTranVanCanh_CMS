<?php
/**
 * search.php - Module 4 + 5: Search Page & Search Results
 * Reference: bootsnipp.com/snippets/35V6b & fit.tdc.edu.vn/tin-tuc
 */
get_header();
$search_query = get_search_query();
?>

<!-- ─ Module 4: Search Hero ─────────────────────────── -->
<div class="search-hero">
    <div class="container">
        <h2><i class="fas fa-search mr-2"></i><?php _e('Search', 'mytheme'); ?></h2>
        <p><?php _e('Find the articles you are looking for', 'mytheme'); ?></p>
        <?php get_search_form(); ?>
    </div>
</div>
<!-- END MODULE 4 -->

<!-- ─ Module 5: Search Results ─────────────────────── -->
<div class="content-area">
    <div class="container">
        <div class="row">

            <!-- Results column -->
            <div class="col-lg-8">

                <!-- Result header bar -->
                <div class="search-result-header">
                    <?php if ($search_query) : ?>
                    <h2>
                        <?php _e('Results for:', 'mytheme'); ?>
                        <span class="search-keyword">"<?php echo esc_html($search_query); ?>"</span>
                    </h2>
                    <span class="search-result-count">
                        <?php
                        global $wp_query;
                        $count = $wp_query->found_posts;
                        printf(
                            _n('%s result found', '%s results found', $count, 'mytheme'),
                            number_format_i18n($count)
                        );
                        ?>
                    </span>
                    <?php else : ?>
                    <h2><?php _e('Search Results', 'mytheme'); ?></h2>
                    <?php endif; ?>
                </div>

                <?php if (have_posts()) : while (have_posts()) : the_post();
                    $post_id   = get_the_ID();
                    $day       = get_the_date('j');
                    $month     = get_the_date('M');
                    $thumb_url = get_the_post_thumbnail_url($post_id, 'post-thumbnail-medium');
                    $cats      = get_the_category();
                    $cat_name  = $cats ? $cats[0]->name : '';
                    $cat_link  = $cats ? get_category_link($cats[0]->term_id) : '#';
                ?>

                <!-- Search Result Post Card -->
                <article class="post-card" id="post-<?php echo $post_id; ?>">
                    <div class="post-card-date">
                        <span class="day"><?php echo esc_html($day); ?></span>
                        <span class="month"><?php echo esc_html($month); ?></span>
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

                        <div class="post-card-excerpt">
                            <?php echo mytheme_excerpt(25); ?>
                        </div>

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
                    <i class="fas fa-search-minus d-block"></i>
                    <h3><?php _e('No results found', 'mytheme'); ?></h3>
                    <p><?php _e('Try a different keyword or browse the categories below.', 'mytheme'); ?></p>
                    <?php get_search_form(); ?>
                </div>

                <?php endif; ?>
            </div><!-- /.col -->

            <!-- Sidebar -->
            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>

        </div><!-- /.row -->
    </div><!-- /.container -->
</div>
<!-- END MODULE 5 -->

<?php get_footer(); ?>
