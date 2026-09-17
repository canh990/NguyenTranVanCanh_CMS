<?php
/**
 * Displays the site header.
 *
 * Module 1: Header / Navbar
 * Reference: bootsnipp.com/snippets/4n8Qe
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

$site_name = get_bloginfo( 'name' );
// Use 'Group C' if site title is default or matches assignment
$brand_label = ( ! empty( $site_name ) && $site_name !== 'WordPress' && $site_name !== 'WORDPRESS V631' ) ? $site_name : 'Group C';
?>

<header id="masthead" class="site-header custom-site-header" role="banner">
	<div class="custom-header-navbar">

		<!-- ─ Left Section: Brand (Group C) + Home + Search Form ────────── -->
		<div class="header-left-section">
			<!-- Brand / Logo -->
			<a class="header-brand-tab" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( $brand_label ); ?>">
				<?php echo esc_html( $brand_label ); ?>
			</a>

			<!-- Home Link Tab -->
			<a class="header-home-tab d-none d-sm-flex" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Home', 'twentytwentyone' ); ?>
			</a>

			<!-- Inline Search Form -->
			<!-- Hướng dẫn: Nhập từ khóa tìm kiếm: ra trang kết quả search -->
			<form class="header-search-form d-none d-md-flex" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
				<div class="search-input-group">
					<input type="search"
					       name="s"
					       class="header-search-input"
					       placeholder="<?php esc_attr_e( 'Search', 'twentytwentyone' ); ?>"
					       value="<?php echo esc_attr( get_search_query() ); ?>"
					       autocomplete="off">
					<button type="submit" class="header-search-btn">
						<?php esc_html_e( 'Submit', 'twentytwentyone' ); ?>
					</button>
				</div>
			</form>
		</div><!-- /.header-left-section -->

		<!-- ─ Mobile Toggle Button ──────────────────────────────────────── -->
		<button class="header-mobile-toggle d-lg-none" id="headerMobileToggle" type="button" aria-label="<?php esc_attr_e( 'Toggle navigation', 'twentytwentyone' ); ?>">
			<i class="fas fa-bars"></i>
		</button>

		<!-- ─ Right Section: Categories / Nav + Menu / Search / Account Icons ── -->
		<div class="header-right-section" id="headerCollapseWrapper">

			<!-- Categories / Menu Navigation -->
			<ul class="header-nav-categories">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'container'      => false,
						'items_wrap'     => '%3$s',
						'depth'          => 1,
						'fallback_cb'    => false,
					) );
				} else {
					// Default categories shown in guide: Thể thao, Khoa học, Tin tức
					$categories = get_categories( array(
						'number'     => 5,
						'hide_empty' => false,
					) );
					$count = 0;
					if ( ! empty( $categories ) ) {
						foreach ( $categories as $category ) {
							if ( strtolower( $category->slug ) !== 'uncategorized' && strtolower( $category->slug ) !== 'chua-phan-loai' ) {
								echo '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
								$count++;
								if ( $count >= 3 ) {
									break;
								}
							}
						}
					}
					if ( $count === 0 ) {
						echo '<li><a href="' . esc_url( home_url( '/category/the-thao/' ) ) . '">Thể thao</a></li>';
						echo '<li><a href="' . esc_url( home_url( '/category/khoa-hoc/' ) ) . '">Khoa học</a></li>';
						echo '<li><a href="' . esc_url( home_url( '/category/tin-tuc/' ) ) . '">Tin tức</a></li>';
					}
				}
				?>
			</ul>

			<!-- Icons: Menu, Search, Account -->
			<ul class="header-icon-group">
				<!-- 1. Menu Icon (Không xử lý chỗ Menu) -->
				<li class="icon-item">
					<a class="header-icon-link" href="javascript:void(0);" title="<?php esc_attr_e( 'Menu', 'twentytwentyone' ); ?>" style="cursor: default;">
						<i class="fas fa-ellipsis-h"></i>
						<span><?php esc_html_e( 'Menu', 'twentytwentyone' ); ?></span>
					</a>
				</li>

				<!-- 2. Search Icon (Nhấn search ra trang tìm kiếm) -->
				<li class="icon-item">
					<a class="header-icon-link" href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" title="<?php esc_attr_e( 'Search', 'twentytwentyone' ); ?>">
						<i class="fas fa-search"></i>
						<span><?php esc_html_e( 'Search', 'twentytwentyone' ); ?></span>
					</a>
				</li>

				<!-- 3. Account Dropdown (Account => đây là dạng dropdown) -->
				<li class="icon-item dropdown" id="accountDropdownContainer">
					<a class="header-icon-link dropdown-toggle" href="#" id="accountDropdownToggle" role="button" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-user-circle"></i>
						<span><?php esc_html_e( 'Account', 'twentytwentyone' ); ?> <i class="fas fa-caret-down"></i></span>
					</a>

					<ul class="header-dropdown-menu dropdown-menu dropdown-menu-right" id="accountDropdownMenu" aria-labelledby="accountDropdownToggle">
						<?php if ( is_user_logged_in() ) :
							$curr_user = wp_get_current_user();
						?>
							<li class="header-dropdown-header">
								<strong><?php echo esc_html( $curr_user->display_name ); ?></strong>
								<div style="font-size:11px;color:#888;font-weight:normal;"><?php echo esc_html( $curr_user->user_email ); ?></div>
							</li>
							<li class="header-dropdown-divider divider"></li>
							<li>
								<a class="header-dropdown-item dropdown-item" href="<?php echo esc_url( get_edit_profile_url() ); ?>">
									<i class="fas fa-user-edit" style="width:20px;margin-right:8px;"></i> Hồ sơ cá nhân
								</a>
							</li>
							<?php if ( current_user_can( 'manage_options' ) ) : ?>
							<li>
								<a class="header-dropdown-item dropdown-item" href="<?php echo esc_url( admin_url() ); ?>">
									<i class="fas fa-tachometer-alt" style="width:20px;margin-right:8px;"></i> Bảng quản trị
								</a>
							</li>
							<?php endif; ?>
							<li class="header-dropdown-divider divider"></li>
							<li>
								<a class="header-dropdown-item dropdown-item text-danger" href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" style="color:#dc3545 !important;">
									<i class="fas fa-sign-out-alt" style="width:20px;margin-right:8px;"></i> Đăng xuất
								</a>
							</li>
						<?php else : ?>
							<li>
								<a class="header-dropdown-item dropdown-item" href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>">
									<i class="fas fa-sign-in-alt" style="width:20px;margin-right:8px;"></i> Đăng nhập
								</a>
							</li>
							<?php if ( get_option( 'users_can_register' ) ) : ?>
							<li>
								<a class="header-dropdown-item dropdown-item" href="<?php echo esc_url( wp_registration_url() ); ?>">
									<i class="fas fa-user-plus" style="width:20px;margin-right:8px;"></i> Đăng ký
								</a>
							</li>
							<?php endif; ?>
						<?php endif; ?>
					</ul>
				</li>
			</ul><!-- /.header-icon-group -->

		</div><!-- /.header-right-section -->

	</div><!-- /.custom-header-navbar -->
</header><!-- #masthead -->
