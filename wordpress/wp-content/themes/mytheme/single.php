<?php
/**
 * single.php - Module 6: Post Detail + Module 7: Prev/Next Post
 * Reference: fit.tdc.edu.vn/blog/2018/06/...
 */
get_header(); ?>

<div class="content-area">
    <div class="container">
        <div class="row">

            <!-- Main Post Content -->
            <div class="col-lg-8">

                <?php if (have_posts()) : while (have_posts()) : the_post();
                    $post_id   = get_the_ID();
                    $thumb_url = get_the_post_thumbnail_url($post_id, 'full');
                    $cats      = get_the_category();
                    $tags      = get_the_tags();
                    $day       = get_the_date('j');
                    $month     = get_the_date('F');
                    $post_date = get_the_date('d', $post_id);
                    $post_month = get_the_date('m', $post_id);
                ?>

                <!-- ══════════════════════════════════════
                     MODULE 6: POST DETAIL
                ═══════════════════════════════════════ -->
                <article class="single-post-wrapper" id="post-<?php echo $post_id; ?>">

                    <?php if ($thumb_url) : ?>
                    <img src="<?php echo esc_url($thumb_url); ?>"
                         alt="<?php the_title_attribute(); ?>"
                         class="single-post-featured">
                    <?php endif; ?>

                    <div class="single-post-body">

                        <!-- Category badge + meta -->
                        <div class="single-post-meta">
                            <?php if ($cats) : ?>
                            <a class="single-post-cat-badge"
                               href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>">
                                <?php echo esc_html($cats[0]->name); ?>
                            </a>
                            <?php endif; ?>
                            <span><i class="fas fa-user mr-1"></i><?php the_author(); ?></span>
                            <span><i class="fas fa-calendar-alt mr-1"></i><?php echo esc_html($day . ' ' . $month); ?></span>
                            <span><i class="fas fa-eye mr-1"></i><?php comments_number('0', '1', '%'); ?> <?php _e('comments', 'mytheme'); ?></span>
                        </div>

                        <!-- Post title -->
                        <h1 class="single-post-title"><?php the_title(); ?></h1>

                        <!-- Post content -->
                        <div class="single-post-content">
                            <?php the_content(); ?>
                        </div>

                        <!-- Tags -->
                        <?php if ($tags) : ?>
                        <div class="post-tags">
                            <span class="tag-label"><i class="fas fa-tags mr-1"></i><?php _e('Tags:', 'mytheme'); ?></span>
                            <?php foreach ($tags as $tag) : ?>
                            <a class="tag-badge" href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                <?php echo esc_html($tag->name); ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                    </div><!-- /.single-post-body -->
                </article>
                <!-- END MODULE 6 -->

                <!-- ══════════════════════════════════════
                     MODULE 7: PREV / NEXT POST
                ═══════════════════════════════════════ -->
                <div class="post-navigation">
                    <div class="row">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>

                        <!-- Previous Post -->
                        <?php if ($prev_post) :
                            $prev_thumb = get_the_post_thumbnail_url($prev_post->ID, 'post-thumbnail-small');
                        ?>
                        <div class="col-sm-6 mb-3">
                            <div class="post-nav-card">
                                <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
                                    <?php if ($prev_thumb) : ?>
                                        <img src="<?php echo esc_url($prev_thumb); ?>"
                                             alt="<?php echo esc_attr($prev_post->post_title); ?>"
                                             class="post-nav-thumb">
                                    <?php else : ?>
                                        <div class="post-nav-thumb-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="post-nav-info">
                                        <div class="post-nav-label">
                                            <i class="fas fa-chevron-left"></i>
                                            <?php _e('Previous Post', 'mytheme'); ?>
                                        </div>
                                        <div class="post-nav-title">
                                            <?php echo esc_html(wp_trim_words($prev_post->post_title, 10, '...')); ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Next Post -->
                        <?php if ($next_post) :
                            $next_thumb = get_the_post_thumbnail_url($next_post->ID, 'post-thumbnail-small');
                        ?>
                        <div class="col-sm-6 mb-3">
                            <div class="post-nav-card">
                                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" style="flex-direction:row-reverse;">
                                    <?php if ($next_thumb) : ?>
                                        <img src="<?php echo esc_url($next_thumb); ?>"
                                             alt="<?php echo esc_attr($next_post->post_title); ?>"
                                             class="post-nav-thumb">
                                    <?php else : ?>
                                        <div class="post-nav-thumb-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="post-nav-info" style="text-align:right;">
                                        <div class="post-nav-label" style="justify-content:flex-end;">
                                            <?php _e('Next Post', 'mytheme'); ?>
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                        <div class="post-nav-title">
                                            <?php echo esc_html(wp_trim_words($next_post->post_title, 10, '...')); ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
                <!-- END MODULE 7 -->

                <!-- ══════════════════════════════════════
                     MODULE 8 / 14: COMMENTS
                ═══════════════════════════════════════ -->
                <?php
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
                ?>
                <!-- END MODULE 8/14 -->

                <?php endwhile; endif; ?>

            </div><!-- /.col main -->

            <!-- Sidebar -->
            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>

        </div><!-- /.row -->
    </div><!-- /.container -->
</div>

<?php get_footer(); ?>
