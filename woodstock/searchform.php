<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">    
    <label class="screen-reader-text"><?php esc_html_e( 'Search for:', 'woodstock' ); ?></label>
    <input type="search" class="search-field" placeholder="<?php esc_html_e( 'Search &hellip;', 'woodstock' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
    <input type="submit" class="search-submit" value="<?php esc_html_e( 'Search', 'woodstock' ); ?>">
</form>