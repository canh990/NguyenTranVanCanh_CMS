<?php
/**
 * footer.php - Module 3: Footer with 4 columns of real DB data
 * References: bootsnipp.com/snippets/rlXdE
 */
?>

<!-- ═══════════════════════════════════════════════════
     MODULE 3: FOOTER
══════════════════════════════════════════════════════ -->
<footer class="site-footer">
    <div class="container">
        <div class="row">

            <!-- Column 1: About the blog -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5><i class="fas fa-blog mr-1"></i><?php bloginfo('name'); ?></h5>
                <p><?php bloginfo('description'); ?></p>
                <div class="footer-socials mt-3">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Column 2: Recent Posts (real data from DB) -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5><i class="fas fa-newspaper mr-1"></i><?php _e('Recent Posts', 'mytheme'); ?></h5>
                <?php
                $recent_posts = wp_get_recent_posts(array(
                    'numberposts' => 4,
                    'post_status' => 'publish',
                ));
                foreach ($recent_posts as $rp) :
                    $thumb = get_the_post_thumbnail_url($rp['ID'], 'thumbnail');
                    $date  = get_the_date('d M Y', $rp['ID']);
                ?>
                <div class="footer-post-item">
                    <?php if ($thumb) : ?>
                        <img src="<?php echo esc_url($thumb); ?>"
                             alt="<?php echo esc_attr($rp['post_title']); ?>"
                             class="footer-post-thumb">
                    <?php else : ?>
                        <div class="footer-post-thumb" style="background:linear-gradient(135deg,#1e3a5f,#2563eb);display:flex;align-items:center;justify-content:center;border-radius:6px;">
                            <i class="fas fa-image" style="color:#60a5fa;font-size:.9rem;"></i>
                        </div>
                    <?php endif; ?>
                    <div class="footer-post-info">
                        <a href="<?php echo esc_url(get_permalink($rp['ID'])); ?>">
                            <?php echo esc_html(wp_trim_words($rp['post_title'], 8, '...')); ?>
                        </a>
                        <span><i class="far fa-calendar-alt mr-1"></i><?php echo esc_html($date); ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Column 3: Categories (real data from DB) -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5><i class="fas fa-folder-open mr-1"></i><?php _e('Categories', 'mytheme'); ?></h5>
                <?php
                $cats = get_categories(array(
                    'orderby'    => 'count',
                    'order'      => 'DESC',
                    'hide_empty' => true,
                    'number'     => 7,
                ));
                if ($cats) :
                ?>
                <ul class="footer-list">
                    <?php foreach ($cats as $cat) : ?>
                    <li>
                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
                            <i class="fas fa-chevron-right"></i>
                            <?php echo esc_html($cat->name); ?>
                        </a>
                        <span class="cat-count"><?php echo (int)$cat->count; ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else : ?>
                    <p style="font-size:.85rem;"><?php _e('No categories yet.', 'mytheme'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Column 4: Recent Comments (real data from DB) -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5><i class="fas fa-comments mr-1"></i><?php _e('Recent Comments', 'mytheme'); ?></h5>
                <?php
                $comments = get_comments(array(
                    'number'  => 5,
                    'status'  => 'approve',
                    'type'    => 'comment',
                ));
                if ($comments) :
                ?>
                    <?php foreach ($comments as $comment) :
                        $post_title = get_the_title($comment->comment_post_ID);
                        $author     = $comment->comment_author;
                        $snippet    = wp_trim_words(strip_tags($comment->comment_content), 8, '...');
                    ?>
                    <div class="recent-comment-item">
                        <div>
                            <span class="recent-comment-author"><?php echo esc_html($author); ?></span>
                            <?php _e(' on ', 'mytheme'); ?>
                            <a class="recent-comment-post"
                               href="<?php echo esc_url(get_comment_link($comment)); ?>">
                                <?php echo esc_html(wp_trim_words($post_title, 5, '...')); ?>
                            </a>
                        </div>
                        <div class="recent-comment-text"><?php echo esc_html($snippet); ?></div>
                    </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p style="font-size:.85rem;"><?php _e('No comments yet.', 'mytheme'); ?></p>
                <?php endif; ?>
            </div>

        </div><!-- /.row -->
    </div><!-- /.container -->

    <!-- Footer bottom bar -->
    <div class="footer-bottom">
        <div class="container">
            &copy; <?php echo date('Y'); ?>
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>.
            <?php _e('All rights reserved.', 'mytheme'); ?>
            &mdash;
            <?php _e('Built with', 'mytheme'); ?>
            <i class="fas fa-heart" style="color:#ef4444;"></i>
            <?php _e('WordPress', 'mytheme'); ?>
        </div>
    </div>
</footer>
<!-- END MODULE 3: FOOTER -->

</div><!-- /.site-wrapper -->

<?php wp_footer(); ?>
</body>
</html>
