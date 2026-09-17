<?php
/**
 * page.php - Module 13: Static Pages
 * Shows posts in vertical card layout (1 per row, responsive)
 * Reference: el.tdc.edu.vn
 */
get_header(); ?>

<div class="page-banner">
    <div class="container">
        <h1><i class="fas fa-file-alt mr-2"></i><?php the_title(); ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'mytheme'); ?></a>
                </li>
                <li class="breadcrumb-item active"><?php the_title(); ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="content-area">
    <div class="container">
        <div class="row">

            <!-- Main Content -->
            <div class="col-lg-8">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <!-- ══════════════════════════════════════
                     MODULE 13: PAGE CONTENT
                     Below the page content, show related posts
                     in vertical column cards (responsive)
                ═══════════════════════════════════════ -->
                <div class="single-post-wrapper mb-4">
                    <?php if (has_post_thumbnail()) :
                        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    ?>
                    <img src="<?php echo esc_url($thumb); ?>"
                         alt="<?php the_title_attribute(); ?>"
                         class="single-post-featured">
                    <?php endif; ?>

                    <div class="single-post-body">
                        <div class="single-post-meta">
                            <span><i class="fas fa-user mr-1"></i><?php the_author(); ?></span>
                            <span><i class="fas fa-calendar-alt mr-1"></i><?php the_date('d F Y'); ?></span>
                        </div>
                        <h1 class="single-post-title"><?php the_title(); ?></h1>
                        <div class="single-post-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>

                <!-- Recent posts in vertical column layout (1 per row) -->
                <div class="section-title mt-4">
                    <i class="fas fa-newspaper"></i>
                    <?php _e('Latest Articles', 'mytheme'); ?>
                </div>

                <?php
                $page_posts = new WP_Query(array(
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ));
                if ($page_posts->have_posts()) :
                    while ($page_posts->have_posts()) : $page_posts->the_post();
                        $pp_id    = get_the_ID();
                        $pp_thumb = get_the_post_thumbnail_url($pp_id, 'post-thumbnail-medium');
                        $pp_day   = get_the_date('j');
                        $pp_month = get_the_date('M');
                        $pp_cats  = get_the_category();
                ?>

                <!-- Module 13: Vertical column card (1 per row) -->
                <div class="page-post-card" style="flex-direction:row; min-height:130px;">
                    <?php if ($pp_thumb) : ?>
                        <img src="<?php echo esc_url($pp_thumb); ?>"
                             alt="<?php the_title_attribute(); ?>"
                             style="width:180px;height:130px;object-fit:cover;flex-shrink:0;">
                    <?php else : ?>
                        <div class="page-post-thumb-placeholder"
                             style="width:180px;height:130px;flex-shrink:0;">
                            <i class="fas fa-image"></i>
                        </div>
                    <?php endif; ?>
                    <div class="page-post-body">
                        <div class="page-post-date-row">
                            <div class="page-post-date-box">
                                <div class="d"><?php echo esc_html($pp_day); ?></div>
                                <div class="m"><?php echo esc_html($pp_month); ?></div>
                            </div>
                            <?php if ($pp_cats) : ?>
                            <span style="font-size:.75rem;color:#2563eb;font-weight:700;text-transform:uppercase;">
                                <?php echo esc_html($pp_cats[0]->name); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="page-post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </div>
                        <div class="page-post-excerpt">
                            <?php echo mytheme_excerpt(18); ?>
                        </div>
                    </div>
                </div>

                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
                <!-- END MODULE 13 -->

                <?php endwhile; endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>

        </div><!-- /.row -->
    </div><!-- /.container -->
</div>

<?php get_footer(); ?>
