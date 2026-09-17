<?php
/**
 * index.php - Module 2: Homepage / Blog Loop
 */
get_header(); ?>

<!-- ─ Page Banner ──────────────────────────────────── -->
<div class="page-banner">
    <div class="container">
        <h1><i class="fas fa-home mr-2"></i><?php _e('Latest Posts', 'mytheme'); ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><?php _e('Home', 'mytheme'); ?></li>
            </ol>
        </nav>
    </div>
</div>

<!-- ─ Main Content Area ─────────────────────────────── -->
<div class="content-area">
    <div class="container">
        <div class="row">

            <!-- Main Posts Column -->
            <div class="col-lg-8 main-content">
                <div class="section-title">
                    <i class="fas fa-stream"></i>
                    <?php _e('All Posts', 'mytheme'); ?>
                </div>

                <?php if (have_posts()) : while (have_posts()) : the_post();
                    $post_id    = get_the_ID();
                    $day        = get_the_date('j');
                    $month      = get_the_date('M');
                    $thumb_url  = get_the_post_thumbnail_url($post_id, 'post-thumbnail-medium');
                    $cats       = get_the_category();
                    $cat_name   = $cats ? $cats[0]->name : '';
                    $cat_link   = $cats ? get_category_link($cats[0]->term_id) : '#';
                ?>

                <!-- ═══ MODULE 2: POST CARD ═══ -->
                <article class="post-card" id="post-<?php echo $post_id; ?>">

                    <!-- Date Box -->
                    <div class="post-card-date">
                        <span class="day"><?php echo esc_html($day); ?></span>
                        <span class="month"><?php echo esc_html($month); ?></span>
                    </div>

                    <!-- Thumbnail -->
                    <?php if ($thumb_url) : ?>
                        <img src="<?php echo esc_url($thumb_url); ?>"
                             alt="<?php the_title_attribute(); ?>"
                             class="post-card-thumb">
                    <?php else : ?>
                        <div class="post-card-thumb-placeholder">
                            <i class="fas fa-image"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Card Body -->
                    <div class="post-card-body">
                        <?php if ($cat_name) : ?>
                        <div class="post-card-category">
                            <a href="<?php echo esc_url($cat_link); ?>">
                                <?php echo esc_html($cat_name); ?>
                            </a>
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
                            <span><i class="fas fa-comments"></i> <?php comments_number('0', '1', '%'); ?> <?php _e('comments', 'mytheme'); ?></span>
                        </div>

                        <a href="<?php the_permalink(); ?>" class="btn-read-more">
                            <?php _e('Read more', 'mytheme'); ?> <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </article>
                <!-- END POST CARD -->

                <?php endwhile;

                // Pagination
                mytheme_pagination();

                else : ?>

                <div class="no-results">
                    <i class="fas fa-inbox d-block"></i>
                    <h3><?php _e('No posts found.', 'mytheme'); ?></h3>
                    <p><?php _e('There are no posts to display yet.', 'mytheme'); ?></p>
                </div>

                <?php endif; ?>
            </div><!-- /.col main -->

            <!-- Sidebar Column -->
            <div class="col-lg-4 sidebar">
                <?php get_sidebar(); ?>
            </div>

        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.content-area -->

<?php get_footer(); ?>
