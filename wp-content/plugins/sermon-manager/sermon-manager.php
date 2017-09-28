<?php
/**
 * Plugin Name:     Sermon Manager
 * Plugin URI:      http://carthage-coc.com/
 * Description:     Handles Sermon creation, viewing, and management as well as other core functionality for Carthage church of Christ. 
 * Author:          Jesse Lloyd
 * Author URI:      https://github.com/jesselloyd
 * Text Domain:     sermon-manager
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Sermon_Manager
 */

require_once( dirname(__FILE__) . '/inc/setup.php');
register_activation_hook(__FILE__, 'sermon_manager_install');

require_once( dirname(__FILE__) . '/inc/youtube-live-stream.php');
require_once( dirname(__FILE__) . '/inc/links.php');

add_action('admin_head', 'plugin_menu_styles');

function plugin_menu_styles() {
    ?><style><?php require_once(plugin_dir_path( __FILE__ ) . "styles/base.css"); ?></style><?php 
}

add_action( 'admin_menu', 'sermon_manager_menu' );
function sermon_manager_menu() {
	add_menu_page( 'Sermon Manager', 'Sermon Manager', 'manage_options', 'Sermon Manager', 'sermon_manager_options', 'dashicons-video-alt2', 2 );
}
function sermon_manager_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
	echo '<div class="wrap">';
    echo '<h1>Sermon Manager</h1>';
    echo '<div class="group"><input name="sermon_search" class="plugin-search pull-left" placeholder="Search Sermons">';
    echo '<button id="create-new-sermon" class="button button-primary action pull-right">Create New Sermon</button></div>';
    echo '<h3>Sermons</h3>';
    echo '========= LIST OF SERMONS TO GO HERE =========';
	echo '</div>';
}

add_action( 'admin_menu', 'links_menu' );
function links_menu() {
    add_menu_page('Links', 'Links', 'manage_options', 'Links', 'links_menu_options', 'dashicons-admin-links', 3);
}

function links_menu_options() {
    if ( !current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    require_once(plugin_dir_path( __FILE__ ) . "menus/links.php");
}

add_shortcode('get_resource_links', 'get_coc_resource_links');

function get_coc_resource_links() {
    $links = get_coc_links();
    ob_start();

    foreach ($links as $link) {
        ?>
            <div class="link">
            <a href="<?php echo $link->link_url; ?>"><img src="<?php echo coc_theme_uri_shortcode() ?>/images/<?php echo $link->logo_image_name; ?>" alt="<?php echo $link->link_name ?>"></a>
            </div> 
        <?php
    }

    return ob_get_clean();    
}

function get_coc_links_for_admin() {
    $links = get_coc_links();
    ob_start();
    ?><div class="link-list"><?php
    foreach ($links as $link) {
        ?>
            <div class="link-item">
                <label for="link_url">Link URL</label>
                <input name="link_url" readonly value="<?php echo $link->link_url ?>">
                <label for="link_url">Link Name</label>               
                <input name="link_url" readonly value="<?php echo $link->link_name ?>">
                <label for="link_url">Logo Image</label>
                <img src="<?php echo coc_theme_uri_shortcode() ?>/images/<?php echo $link->logo_image_name; ?>">
            </div> 
        <?php
    }
    ?></div><?php

    return ob_get_clean();
}
