<?php
/**
 * sidebar.php - Sidebar with Modules 9, 10, 11, 12, 15
 * Module 9:  Categories Widget
 * Module 10: Recent Posts Widget
 * Module 11: Archive Widget
 * Module 12: Recent Comments Widget
 * Module 15: Last Posts Widget (bootsnipp xrKXW style)
 */
?>

<!-- ══════════════════════════════════════════════════════
     MODULE 9: CATEGORIES WIDGET
═══════════════════════════════════════════════════════ -->
<div class="widget-card">
    <div class="widget-header">
        <i class="fas fa-folder-open"></i>
        <?php _e('Categories', 'mytheme'); ?>
    </div>
    <div class="widget-body">
        <?php
        $cats = get_categories(array(
            'orderby'    => 'count',
            'order'      => 'DESC',
            'hide_empty' => true,
        ));
        if ($cats) :
        ?>
        <ul class="categories-list">
            <?php foreach ($cats as $cat) : ?>
            <li>
                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
                    <i class="fas fa-angle-right"></i>
                    <?php echo esc_html($cat->name); ?>
                </a>
                <span class="cat-count"><?php echo (int)$cat->count; ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else : ?>
        <p style="color:#94a3b8;font-size:.85rem;"><?php _e('No categories yet.', 'mytheme'); ?></p>
        <?php endif; ?>
    </div>
</div>
<!-- END MODULE 9 -->


<!-- ══════════════════════════════════════════════════════
     MODULE 10: RECENT POSTS WIDGET
═══════════════════════════════════════════════════════ -->
<div class="widget-card">
    <div class="widget-header">
        <i class="fas fa-clock"></i>
        <?php _e('Recent Posts', 'mytheme'); ?>
    </div>
    <div class="widget-body">
        <?php
        $recent = wp_get_recent_posts(array(
            'numberposts' => 5,
            'post_status' => 'publish',
        ));
        foreach ($recent as $rp) :
            $thumb = get_the_post_thumbnail_url($rp['ID'], 'post-thumbnail-small');
            $date  = get_the_date('d M Y', $rp['ID']);
        ?>
        <div class="recent-post-item">
            <?php if ($thumb) : ?>
                <img src="<?php echo esc_url($thumb); ?>"
                     alt="<?php echo esc_attr($rp['post_title']); ?>"
                     class="recent-post-thumb">
            <?php else : ?>
                <div class="recent-post-thumb-placeholder">
                    <i class="fas fa-image"></i>
                </div>
            <?php endif; ?>
            <div class="recent-post-info">
                <a class="recent-post-title"
                   href="<?php echo esc_url(get_permalink($rp['ID'])); ?>">
                    <?php echo esc_html(wp_trim_words($rp['post_title'], 9, '...')); ?>
                </a>
                <span class="recent-post-date">
                    <i class="far fa-calendar-alt mr-1"></i><?php echo esc_html($date); ?>
                </span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- END MODULE 10 -->


<!-- ══════════════════════════════════════════════════════
     MODULE 15: LAST POSTS WIDGET (bootsnipp xrKXW style)
═══════════════════════════════════════════════════════ -->
<div class="widget-card">
    <div class="widget-header">
        <i class="fas fa-list"></i>
        <?php _e('Last Posts', 'mytheme'); ?>
    </div>
    <div class="widget-body">
        <?php
        $last_posts = new WP_Query(array(
            'posts_per_page' => 5,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        if ($last_posts->have_posts()) :
            while ($last_posts->have_posts()) : $last_posts->the_post();
                $lp_id    = get_the_ID();
                $lp_thumb = get_the_post_thumbnail_url($lp_id, 'post-thumbnail-small');
                $lp_date  = get_the_date('d M Y');
        ?>
        <div class="last-post-item">
            <div class="last-post-item-inner">
                <?php if ($lp_thumb) : ?>
                    <img src="<?php echo esc_url($lp_thumb); ?>"
                         alt="<?php the_title_attribute(); ?>"
                         class="last-post-item-thumb">
                <?php else : ?>
                    <div class="last-post-item-thumb-placeholder">
                        <i class="fas fa-image"></i>
                    </div>
                <?php endif; ?>
                <div class="last-post-item-info">
                    <a class="last-post-item-title" href="<?php the_permalink(); ?>">
                        <?php echo esc_html(wp_trim_words(get_the_title(), 8, '...')); ?>
                    </a>
                    <span class="last-post-item-meta">
                        <i class="far fa-calendar-alt mr-1"></i><?php echo esc_html($lp_date); ?>
                    </span>
                </div>
            </div>
        </div>
        <?php endwhile;
        wp_reset_postdata();
        endif; ?>
    </div>
</div>
<!-- END MODULE 15 -->


<!-- ══════════════════════════════════════════════════════
     MODULE 11: ARCHIVE WIDGET
═══════════════════════════════════════════════════════ -->
<div class="widget-card">
    <div class="widget-header">
        <i class="fas fa-calendar-alt"></i>
        <?php _e('Archives', 'mytheme'); ?>
    </div>
    <div class="widget-body">
        <?php
        // Get archives with count
        $archives = wp_get_archives(array(
            'type'   => 'monthly',
            'limit'  => 12,
            'format' => 'custom',
            'before' => '',
            'after'  => '',
            'show_post_count' => true,
            'echo'   => false,
        ));
        // Manual: get monthly archives with counts
        global $wpdb;
        $arc_results = $wpdb->get_results(
            "SELECT YEAR(post_date) AS year, MONTH(post_date) AS month,
                    COUNT(ID) AS count
             FROM {$wpdb->posts}
             WHERE post_type = 'post' AND post_status = 'publish'
             GROUP BY year, month
             ORDER BY year DESC, month DESC
             LIMIT 12"
        );
        if ($arc_results) :
        ?>
        <ul class="archive-list">
            <?php foreach ($arc_results as $arc) :
                $arc_url   = get_month_link($arc->year, $arc->month);
                $arc_label = date_i18n('F Y', mktime(0, 0, 0, $arc->month, 1, $arc->year));
            ?>
            <li>
                <a href="<?php echo esc_url($arc_url); ?>">
                    <i class="far fa-calendar-alt"></i>
                    <?php echo esc_html($arc_label); ?>
                </a>
                <span class="archive-count"><?php echo (int)$arc->count; ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else : ?>
        <p style="color:#94a3b8;font-size:.85rem;"><?php _e('No archives yet.', 'mytheme'); ?></p>
        <?php endif; ?>
    </div>
</div>
<!-- END MODULE 11 -->


<!-- ══════════════════════════════════════════════════════
     MODULE 12: RECENT COMMENTS WIDGET
═══════════════════════════════════════════════════════ -->
<div class="widget-card">
    <div class="widget-header">
        <i class="fas fa-comment-dots"></i>
        <?php _e('Recent Comments', 'mytheme'); ?>
    </div>
    <div class="widget-body">
        <?php
        $recent_comments = get_comments(array(
            'number'  => 5,
            'status'  => 'approve',
            'type'    => 'comment',
        ));
        if ($recent_comments) :
            foreach ($recent_comments as $rc) :
                $rc_post  = get_the_title($rc->comment_post_ID);
                $rc_link  = get_comment_link($rc);
                $rc_text  = wp_trim_words(strip_tags($rc->comment_content), 8, '...');
        ?>
        <div class="recent-comment-item">
            <span class="recent-comment-author"><?php echo esc_html($rc->comment_author); ?></span>
            <?php _e(' on ', 'mytheme'); ?>
            <a class="recent-comment-post" href="<?php echo esc_url($rc_link); ?>">
                <?php echo esc_html(wp_trim_words($rc_post, 5, '...')); ?>
            </a>
            <div class="recent-comment-text"><?php echo esc_html($rc_text); ?></div>
        </div>
        <?php endforeach;
        else : ?>
        <p style="color:#94a3b8;font-size:.85rem;"><?php _e('No comments yet.', 'mytheme'); ?></p>
        <?php endif; ?>
    </div>
</div>
<!-- END MODULE 12 -->


<!-- Search widget -->
<div class="widget-card">
    <div class="widget-header">
        <i class="fas fa-search"></i>
        <?php _e('Search', 'mytheme'); ?>
    </div>
    <div class="widget-body">
        <form role="search" method="GET" action="<?php echo esc_url(home_url('/')); ?>"
              style="display:flex;gap:6px;">
            <input type="search" name="s"
                   class="form-control form-control-sm"
                   placeholder="<?php esc_attr_e('Search...', 'mytheme'); ?>"
                   value="<?php echo esc_attr(get_search_query()); ?>">
            <button type="submit" class="btn btn-primary btn-sm" style="border-radius:6px;white-space:nowrap;">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>
