<?php

add_action( 'wp_enqueue_scripts', 'coc_sky_blue_parent_theme_enqueue_styles' );

function coc_sky_blue_parent_theme_enqueue_styles() {
    wp_enqueue_style( 'coc-sky-blue-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'coc-sky-blue-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'coc-sky-blue-style' )
    );

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

add_shortcode('get_leadership', 'coc_get_leadership_list');

function coc_get_leadership_list() {
    ob_start();
    global $wpdb;
    $leader_meta = $wpdb->get_results("SELECT * FROM wp_usermeta WHERE user_id IN (SELECT user_id FROM wp_users) AND (meta_key = 'first_name' || meta_key = 'last_name');");

    foreach ($leader_meta as $meta_key) {
        if ($meta_key->meta_key == 'first_name') {
            ?>
                <div class="leader-item">
                    <h3 class="grey-header"><?php echo $meta_key->meta_value . ' ' ?>
            <?php
        } else if ($meta_key->meta_key == 'last_name'){
            ?>
                <?php echo $meta_key->meta_value; ?></h3>
                <h4>(417) 434 - 0754</h4>
                <p>Description goes here</p>
            </div>
            <?php
        }
    }

    return ob_get_clean();
}
