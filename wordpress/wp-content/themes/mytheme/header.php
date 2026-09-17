<?php
/**
 * header.php - Module 1: Header / Navbar
 * Uses Bootstrap 4 Navbar with Search Form + Account Dropdown
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="site-wrapper">

<!-- ═══════════════════════════════════════════════════
     MODULE 1: HEADER / NAVBAR
══════════════════════════════════════════════════════ -->
<nav class="navbar navbar-expand-lg site-navbar fixed-top light-theme-header" role="navigation">
    <div class="container-fluid px-lg-5">

        <!-- ─ Left Group: Logo + Home + Search Form ────────── -->
        <div class="header-left-group d-flex align-items-center">
            <!-- Brand / Logo -->
            <?php
            $brand_title = get_bloginfo('name');
            $display_logo = (!empty($brand_title) && $brand_title !== 'WordPress' && $brand_title !== 'WORDPRESS V631') ? $brand_title : 'Group C';
            ?>
            <a class="navbar-brand header-logo" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr($display_logo); ?>">
                <?php echo esc_html($display_logo); ?>
            </a>

            <!-- Home Link -->
            <a class="header-home-link d-none d-md-block" href="<?php echo esc_url(home_url('/')); ?>">
                <?php _e('Home', 'mytheme'); ?>
            </a>

            <!-- Search Form (Nhập từ khóa tìm kiếm: ra trang kết quả search) -->
            <form class="header-inline-search d-none d-md-flex" method="GET" action="<?php echo esc_url(home_url('/')); ?>" role="search">
                <input type="search" name="s" class="form-control form-control-sm" placeholder="Search" value="<?php echo esc_attr(get_search_query()); ?>" autocomplete="off">
                <button type="submit" class="btn btn-sm btn-outline-secondary">Submit</button>
            </form>
        </div>

        <!-- ─ Mobile Toggle ─────────────────── -->
        <button class="navbar-toggler" type="button"
                data-toggle="collapse" data-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- ─ Right Group: Navigation & Icons ───────────── -->
        <div class="collapse navbar-collapse" id="navbarMain">

            <!-- Primary Menu / Categories -->
            <div class="ml-auto header-main-menu">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'navbar-nav',
                        'fallback_cb'    => false,
                        'walker'         => new Bootstrap4_Nav_Walker(),
                    ));
                } else {
                    echo '<ul class="navbar-nav">';
                    $categories = get_categories(array('number' => 4, 'hide_empty' => false));
                    $c_count = 0;
                    if (!empty($categories)) {
                        foreach ($categories as $cat) {
                            if (strtolower($cat->slug) !== 'uncategorized' && strtolower($cat->slug) !== 'chua-phan-loai') {
                                echo '<li class="nav-item"><a class="nav-link" href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
                                $c_count++;
                                if ($c_count >= 3) break;
                            }
                        }
                    }
                    if ($c_count === 0) {
                        echo '<li class="nav-item"><a class="nav-link" href="' . esc_url(home_url('/category/the-thao/')) . '">Thể thao</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="' . esc_url(home_url('/category/khoa-hoc/')) . '">Khoa học</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="' . esc_url(home_url('/category/tin-tuc/')) . '">Tin tức</a></li>';
                    }
                    echo '</ul>';
                }
                ?>
            </div>

            <!-- Icons Menu -->
            <ul class="navbar-nav header-icon-menu align-items-center ml-3">
                <!-- Menu Icon (Không xử lý chỗ Menu) -->
                <li class="nav-item icon-item">
                    <a class="nav-link" href="javascript:void(0);" style="cursor: default;">
                        <i class="fas fa-ellipsis-h"></i>
                        <span>Menu</span>
                    </a>
                </li>

                <!-- Search Icon (Nhấn search ra trang tìm kiếm) -->
                <li class="nav-item icon-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/?s=')); ?>" title="Search">
                        <i class="fas fa-search"></i>
                        <span>Search</span>
                    </a>
                </li>

                <!-- Account Dropdown (dạng dropdown) -->
                <?php if (is_user_logged_in()) :
                    $current_user = wp_get_current_user();
                    $avatar       = get_avatar_url($current_user->ID, array('size' => 24));
                ?>
                <li class="nav-item icon-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($current_user->display_name); ?>" class="account-avatar">
                        <span>Account <i class="fas fa-caret-down" style="font-size: 10px;"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
                        <div class="dropdown-item user-email-txt"><strong><?php echo esc_html($current_user->display_name); ?></strong><br><?php echo esc_html($current_user->user_email); ?></div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo esc_url(get_edit_profile_url()); ?>"><i class="fas fa-user-edit mr-2"></i> Hồ sơ cá nhân</a>
                        <?php if (current_user_can('manage_options')) : ?>
                        <a class="dropdown-item" href="<?php echo esc_url(admin_url()); ?>"><i class="fas fa-tachometer-alt mr-2"></i> Bảng quản trị</a>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất</a>
                    </div>
                </li>
                <?php else : ?>
                <li class="nav-item icon-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        <span>Account <i class="fas fa-caret-down" style="font-size: 10px;"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
                        <a class="dropdown-item" href="<?php echo esc_url(wp_login_url(get_permalink())); ?>"><i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập</a>
                        <?php if (get_option('users_can_register')) : ?>
                        <a class="dropdown-item" href="<?php echo esc_url(wp_registration_url()); ?>"><i class="fas fa-user-plus mr-2"></i> Đăng ký</a>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endif; ?>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<!-- END MODULE 1: HEADER -->

