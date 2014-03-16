<?php
/**
 * Global searchform
 *
 * @package Écoute Prolongée
 * @since   1.0.0
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
    <input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search-field" placeholder="<?php _e('Search', 'hugo'); ?>">
    <button type="submit" class="search-btn"><i class="icon-search"></i></button>
</form>