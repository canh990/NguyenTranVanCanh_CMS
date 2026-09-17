<?php
/**
 * functions.php - Theme setup, enqueue scripts, widgets, menus
 */

// ── Theme setup ───────────────────────────────────────────────────────────────
function mytheme_setup() {
    // Allow translated strings
    load_theme_textdomain('mytheme', get_template_directory() . '/languages');

    // Add HTML5 support
    add_theme_support('html5', array('search-form','comment-form','comment-list','gallery','caption'));

    // Featured images
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(800, 480, true);
    add_image_size('post-thumbnail-small', 150, 120, true);
    add_image_size('post-thumbnail-medium', 400, 280, true);

    // Title tag handled by WordPress
    add_theme_support('title-tag');

    // Register nav menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'mytheme'),
    ));
}
add_action('after_setup_theme', 'mytheme_setup');

// ── Enqueue styles & scripts ──────────────────────────────────────────────────
function mytheme_enqueue_assets() {
    // Bootstrap 4 CSS
    wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css',
        array(),
        '4.6.2'
    );

    // Font Awesome 5
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
        array(),
        '5.15.4'
    );

    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );

    // Theme main CSS
    wp_enqueue_style(
        'mytheme-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array('bootstrap'),
        '1.0'
    );

    // WordPress default style (required)
    wp_enqueue_style(
        'mytheme-style',
        get_stylesheet_uri(),
        array(),
        '1.0'
    );

    // jQuery (WordPress bundled)
    wp_enqueue_script('jquery');

    // Bootstrap 4 Bundle (Popper included)
    wp_enqueue_script(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        '4.6.2',
        true
    );

    // Theme JS
    wp_enqueue_script(
        'mytheme-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array('jquery', 'bootstrap'),
        '1.0',
        true
    );

    // Comment reply script
    if (is_singular() && comments_open()) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_assets');

// ── Register Sidebar Widgets ───────────────────────────────────────────────────
function mytheme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Primary Sidebar', 'mytheme'),
        'id'            => 'sidebar-1',
        'description'   => __('Main sidebar for blog/posts pages.', 'mytheme'),
        'before_widget' => '<div class="widget-card"><div class="widget-body">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<div class="widget-header"><i class="fas fa-angle-right"></i><span>',
        'after_title'   => '</span></div>',
    ));

    register_sidebar(array(
        'name'          => __('Footer Sidebar', 'mytheme'),
        'id'            => 'footer-sidebar',
        'description'   => __('Widgets shown in the footer.', 'mytheme'),
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h5>',
        'after_title'   => '</h5>',
    ));
}
add_action('widgets_init', 'mytheme_widgets_init');

// ── Helper: Get post thumbnail or placeholder ─────────────────────────────────
function mytheme_post_thumbnail($post_id, $size = 'post-thumbnail-medium', $css_class = '') {
    if (has_post_thumbnail($post_id)) {
        $thumb = get_the_post_thumbnail_url($post_id, $size);
        return '<img src="' . esc_url($thumb) . '" alt="' . esc_attr(get_the_title($post_id)) . '" class="' . esc_attr($css_class) . '">';
    }
    return '<div class="post-card-thumb-placeholder"><i class="fas fa-image"></i></div>';
}

// ── Helper: Excerpt with custom length ───────────────────────────────────────
function mytheme_excerpt($length = 20) {
    $excerpt = get_the_excerpt();
    $words   = explode(' ', $excerpt);
    if (count($words) > $length) {
        $words   = array_slice($words, 0, $length);
        $excerpt = implode(' ', $words) . '...';
    }
    return esc_html($excerpt);
}

// ── Fix pagination ────────────────────────────────────────────────────────────
function mytheme_pagination($query = null) {
    global $wp_query;
    if (!$query) {
        $query = $wp_query;
    }
    $total = $query->max_num_pages;
    if ($total <= 1) return;

    $current = max(1, get_query_var('paged'));
    $links   = paginate_links(array(
        'base'      => get_pagenum_link(1) . '%_%',
        'format'    => 'page/%#%',
        'current'   => $current,
        'total'     => $total,
        'prev_text' => '<i class="fas fa-chevron-left"></i>',
        'next_text' => '<i class="fas fa-chevron-right"></i>',
        'type'      => 'array',
    ));

    if ($links) {
        echo '<nav class="pagination-wrapper"><ul class="pagination">';
        foreach ($links as $link) {
            $active = strpos($link, 'current') !== false ? ' active' : '';
            echo '<li class="page-item' . $active . '">';
            // Replace <a> with .page-link class
            echo str_replace('<a ', '<a class="page-link" ', str_replace('<span ', '<span class="page-link" ', $link));
            echo '</li>';
        }
        echo '</ul></nav>';
    }
}

// ── Custom comment callback ────────────────────────────────────────────────────
function mytheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    $author  = get_comment_author_link($comment->comment_ID);
    $date    = get_comment_date('d M Y', $comment->comment_ID);
    $time    = get_comment_time('H:i', false, false, $comment->comment_ID);
    $avatar  = get_avatar($comment, 46, '', '', array('class' => 'comment-avatar'));
    $initial = strtoupper(substr(get_comment_author($comment->comment_ID), 0, 1));
    ?>
    <li id="comment-<?php echo $comment->comment_ID; ?>" class="comment-item">
        <?php if ($avatar): echo $avatar; else: ?>
            <div class="comment-avatar-default"><?php echo esc_html($initial); ?></div>
        <?php endif; ?>
        <div class="comment-body">
            <div class="comment-header">
                <span class="comment-author-name"><?php echo $author; ?></span>
                <span class="comment-date"><i class="far fa-clock"></i> <?php echo $date; ?> - <?php echo $time; ?></span>
            </div>
            <div class="comment-text"><?php comment_text(); ?></div>
            <?php comment_reply_link(array_merge($args, array(
                'reply_text' => '<i class="fas fa-reply"></i> Reply',
                'before'     => '<button class="comment-reply-btn">',
                'after'      => '</button>',
                'depth'      => $depth,
                'max_depth'  => $args['max_depth'],
            ))); ?>
        </div>
    <?php
    // Note: </li> is closed by wp_list_comments
}

// ── Add body class ────────────────────────────────────────────────────────────
add_filter('body_class', function($classes) {
    $classes[] = 'mytheme-body';
    return $classes;
});

/**
 * Bootstrap 4 Nav Walker - handles dropdown menus in wp_nav_menu
 */
if (!class_exists('Bootstrap4_Nav_Walker')) {
class Bootstrap4_Nav_Walker extends Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<div class="dropdown-menu" aria-labelledby="navDropdown-' . $depth . '">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</div>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes   = empty($item->classes) ? array() : (array) $item->classes;
        $has_child = in_array('menu-item-has-children', $classes);

        if ($depth === 0) {
            $output .= '<li class="nav-item' . ($has_child ? ' dropdown' : '') . '">';
            $output .= '<a id="navDropdown-' . $depth . '" class="nav-link' . ($has_child ? ' dropdown-toggle' : '') . '"'
                     . ($has_child ? ' data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"' : ' href="' . esc_url($item->url) . '"') . '>'
                     . esc_html($item->title) . '</a>';
        } else {
            $output .= '<a class="dropdown-item" href="' . esc_url($item->url) . '">'
                     . esc_html($item->title) . '</a>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        if ($depth === 0) $output .= '</li>';
    }
}
}
