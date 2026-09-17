<?php
/**
 * searchform.php - Module 4: Search Form (fullpage hero style)
 * Reference: bootsnipp.com/snippets/35V6b
 * This file is used by get_search_form() and also embedded in search.php
 */
?>
<form class="search-form-big" role="search" method="GET" action="<?php echo esc_url(home_url('/')); ?>">
    <input type="search"
           name="s"
           id="search-field"
           placeholder="<?php esc_attr_e('Enter keyword to search...', 'mytheme'); ?>"
           value="<?php echo esc_attr(get_search_query()); ?>"
           aria-label="<?php esc_attr_e('Search', 'mytheme'); ?>"
           autocomplete="off">
    <button type="submit">
        <i class="fas fa-search"></i>
        <?php _e('Search', 'mytheme'); ?>
    </button>
</form>
