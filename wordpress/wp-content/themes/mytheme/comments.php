<?php
/**
 * comments.php - Module 8 + 14: Comments list + Comment Form
 * Reference: bootsnipp.com/snippets/rNEdR (Module 8 - for logged in)
 *            bootsnipp.com/snippets/gNVj0 (Module 14 - comments list)
 */

if (post_password_required()) {
    echo '<p class="text-center p-4">' . __('This post is password protected. Enter the password to view comments.', 'mytheme') . '</p>';
    return;
}
?>

<!-- ══════════════════════════════════════════════════════
     MODULE 14: COMMENTS LIST
═══════════════════════════════════════════════════════ -->
<?php if (have_comments()) : ?>
<div class="comments-section" id="comments">
    <h3>
        <i class="fas fa-comments"></i>
        <?php comments_number(
            __('No comments', 'mytheme'),
            __('1 Comment', 'mytheme'),
            __('% Comments', 'mytheme')
        ); ?>
    </h3>

    <ul class="comment-list list-unstyled" id="comment-list">
        <?php
        wp_list_comments(array(
            'style'       => 'ul',
            'short_ping'  => true,
            'callback'    => 'mytheme_comment',
            'avatar_size' => 46,
            'max_depth'   => 3,
        ));
        ?>
    </ul>

    <!-- Nested comment children -->
    <?php if (get_comment_pages_count() > 1) : ?>
    <nav class="pagination-wrapper mt-3">
        <?php paginate_comments_links(array(
            'prev_text' => '<i class="fas fa-chevron-left"></i>',
            'next_text' => '<i class="fas fa-chevron-right"></i>',
        )); ?>
    </nav>
    <?php endif; ?>

</div><!-- /.comments-section -->
<?php endif; ?>
<!-- END MODULE 14 -->


<!-- ══════════════════════════════════════════════════════
     MODULE 8: COMMENT FORM
     Interface for logged-in user (bootsnipp rNEdR style)
═══════════════════════════════════════════════════════ -->
<?php if (comments_open()) : ?>
<div class="comments-section" id="comment-reply-form">
    <h3>
        <i class="fas fa-pen"></i>
        <?php _e('Leave a Comment', 'mytheme'); ?>
    </h3>

    <?php if (is_user_logged_in()) :
        $current_user = wp_get_current_user();
        $avatar       = get_avatar_url($current_user->ID, array('size' => 44));
    ?>
    <!-- Logged-in user info bar -->
    <div class="comment-user-info">
        <img src="<?php echo esc_url($avatar); ?>"
             alt="<?php echo esc_attr($current_user->display_name); ?>">
        <div>
            <div class="user-name"><?php echo esc_html($current_user->display_name); ?></div>
            <div class="user-note">
                <?php _e('Posting as', 'mytheme'); ?>
                <a href="<?php echo esc_url(wp_logout_url(get_permalink())); ?>" style="color:#ef4444;">
                    <?php _e('(Logout?)', 'mytheme'); ?>
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php
    $commenter = wp_get_current_commenter();
    comment_form(array(
        'title_reply'         => '',
        'title_reply_before'  => '',
        'title_reply_after'   => '',
        'comment_notes_before'=> '',
        'comment_notes_after' => '',
        'fields' => array(
            'author' => '<div class="form-group"><label for="author">' . __('Name', 'mytheme') . ' <span class="text-danger">*</span></label>'
                      . '<input id="author" name="author" type="text" class="form-control" value="' . esc_attr($commenter['comment_author']) . '" required></div>',
            'email'  => '<div class="form-group"><label for="email">' . __('Email', 'mytheme') . ' <span class="text-danger">*</span></label>'
                      . '<input id="email" name="email" type="email" class="form-control" value="' . esc_attr($commenter['comment_author_email']) . '" required></div>',
            'url'    => '<div class="form-group"><label for="url">' . __('Website', 'mytheme') . '</label>'
                      . '<input id="url" name="url" type="url" class="form-control" value="' . esc_attr($commenter['comment_author_url']) . '"></div>',
        ),
        'comment_field' => '<div class="form-group"><label for="comment">' . __('Comment', 'mytheme') . ' <span class="text-danger">*</span></label>'
                         . '<textarea id="comment" name="comment" class="form-control comment-form-wrapper" rows="5" required placeholder="' . esc_attr__('Write your comment here...', 'mytheme') . '"></textarea></div>',
        'submit_button'  => '<button type="submit" id="submit" class="btn-comment-submit"><i class="fas fa-paper-plane mr-2"></i>' . __('Post Comment', 'mytheme') . '</button>',
        'submit_field'   => '<div class="form-group mt-3">%1$s %2$s</div>',
        'class_form'     => 'comment-form-wrapper',
    ));
    ?>
</div><!-- /.comments-section -->
<?php else : ?>
<div class="comments-section">
    <p class="text-center" style="color:#64748b;">
        <i class="fas fa-lock mr-2"></i>
        <?php _e('Comments are closed.', 'mytheme'); ?>
    </p>
</div>
<?php endif; ?>
<!-- END MODULE 8 -->
