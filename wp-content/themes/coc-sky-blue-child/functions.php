<?php

remove_filter('the_content', 'wpautop');

add_action( 'wp_enqueue_scripts', 'coc_sky_blue_parent_theme_enqueue_styles' );

function coc_sky_blue_parent_theme_enqueue_styles() {
    wp_enqueue_style( 'coc-sky-blue-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'coc-sky-blue-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'coc-sky-blue-style' )
    );

}

add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
    wp_enqueue_style( 'dashicons' ); 
}

add_action('coc_sky_blue_footer_content', 'footer_content');

function footer_content() {
    ?>
        <div class="center-text">Copyright &copy; <?php echo date('Y') ?> Carthage church of Christ</div>
    <?php
}

add_filter( 'wp_nav_menu_items', 'coc_loginout_menu_link', 10, 2 );

function coc_loginout_menu_link( $items, $args ) {
    if (is_user_logged_in()) {
        $items .= '<li class="right"><a href="'. wp_logout_url() .'">'. __("Log Out") .'</a></li>';
    } else {
        $items .= '<li class="right"><a href="'. wp_login_url(get_permalink()) .'">'. __("Log In") .'</a></li>';
    }

    return $items;
}
